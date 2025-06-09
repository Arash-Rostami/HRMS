<?php

namespace App\Services\api;

use App\Models\Leave;
use GuzzleHttp\Client;


class OnLeaveUsers extends ETS
{
    public function prepareSoapRequest(): string
    {
        return <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetAllVacationRegistrationsByDate xmlns="http://tempuri.org/">
      <date>{$this->currentDate}</date>
    </GetAllVacationRegistrationsByDate>
  </soap:Body>
</soap:Envelope>
EOT;
    }

    public function sendSoapRequest(string $soapRequest): \Psr\Http\Message\ResponseInterface
    {
        $client = new Client();
        return $client->post($this->ip, [
            'headers' => [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://tempuri.org/GetAllVacationRegistrationsByDate'
            ],
            'body' => $soapRequest,
        ]);
    }

    public function receiveSoapResponse(\Psr\Http\Message\ResponseInterface $response): null|false|\SimpleXMLElement
    {
        $soapBody = $this->extractBody($response);

        // Find the GetAllIoRecordsByDateResponse element within soapBody
        $getRecordsResponse = $soapBody->children('http://tempuri.org/')->GetAllVacationRegistrationsByDateResponse;

        // Find the GetAllIoRecordsByDateResult element within GetIoRecordsResponse
        return $getRecordsResponse->GetAllVacationRegistrationsByDateResult->VacationRegistrationDataModel;
    }

    public function processSoapResponse(\SimpleXMLElement|bool|null $recordsResult): array
    {
        $result = [];

        if ($recordsResult !== null) {
            foreach ($recordsResult as $record) {
                $result[] = [
                    'Id' => (int)$record->Id,
                    'EmployeeCode' => (string)$record->EmployeeCode,
                    'BusinessPartnerId' => (int)$record->BusinessPartnerId,
                    'FullName' => (string)$record->FullName,
                    'DayOfWeekInText' => (string)$record->DayOfWeekInText,
                    'BeginDateInText' => (string)$record->BeginDateInText,
                    'BeginTimeInText' => (string)$record->BeginTimeInText,
                    'EndDateInText' => (string)$record->EndDateInText,
                    'EndTimeInText' => (string)$record->EndTimeInText,
                    'VacationName' => (string)$record->VacationName,
                    'VacationTypeInText' => (string)$record->VacationTypeInText,
                    'AcceptanceStateInText' => (string)$record->AcceptanceStateInText,
                    'SourceTypeInText' => (string)$record->SourceTypeInText,
                ];
            }
            return $result;
        }
        return $result;
    }

    public function processAttendance(\SimpleXMLElement|bool|null|array $recordsResult): array
    {
        if ($recordsResult === null) {
            return $this->attendanceData = [];
        }

        $this->attendanceData = [];

        foreach ($recordsResult as $record) {
            $vacationType = (string)$record['VacationTypeInText'];
            $isHourly = ($vacationType === 'ساعتی');

            $attendance = [
                'EmployeeCode' => (string)$record['EmployeeCode'],
                'FullName' => (string)$record['FullName'],
                'BeginDate' => (string)$record['BeginDateInText'],
                'EndDate' => (string)$record['EndDateInText'],
                'VacationType' => $vacationType,
                'BeginTime' => $isHourly ? (string)($record['BeginTimeInText'] ?? '') : '',
                'EndTime' => $isHourly ? (string)($record['EndTimeInText'] ?? '') : '',
            ];

            $attendance['Duration'] = $this->calculateDuration($attendance);
            $this->attendanceData[] = $attendance;
        }

        return $this->attendanceData;
    }

    private function calculateDuration(array $attendanceData): float
    {
        $type = $attendanceData['VacationType'] ?? '';

        if (str_contains($type, 'روزانه')) {
            $begin = $attendanceData['BeginDate'] ?? '';
            $end = $attendanceData['EndDate'] ?? '';
            if (!$begin || !$end) return 0.0;

            $beginTs = strtotime($begin);
            $endTs = strtotime($end);
            if (!$beginTs || !$endTs || $endTs < $beginTs) return 0.0;

            return max(floor(($endTs - $beginTs) / 86400), 1.0);
        }

        if ($type === 'ساعتی') {
            $beginTime = $attendanceData['BeginTime'] ?? '';
            $endTime = $attendanceData['EndTime'] ?? '';
            if (!$beginTime || !$endTime) return 0.0;

            $beginTs = strtotime($beginTime);
            $endTs = strtotime($endTime);
            if (!$beginTs || !$endTs || $endTs <= $beginTs) return 0.0;

            return round(($endTs - $beginTs) / 3600, 2);
        }

        return 0.0;
    }

    public function updateUsers(): void
    {
        $rows = collect($this->attendanceData)->map(fn($att) => [
            'employee_code' => $att['EmployeeCode'],
            'employee_name' => $att['FullName'],
            'begin_date' => $att['BeginDate'] ?? '',
            'end_date' => $att['EndDate'] ?? '',
            'leave_type' => $att['VacationType'],
            'begin_time' => $att['BeginTime'] ?? '',
            'end_time' => $att['EndTime'] ?? '',
            'duration' => $att['Duration'],
            'note' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();

        if (empty($rows)) return;

        Leave::insertOrIgnore($rows);
    }
}
