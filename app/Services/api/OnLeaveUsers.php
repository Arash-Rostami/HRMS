<?php

namespace App\Services\api;

use App\Models\Leave;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Uri;
use Morilog\Jalali\Jalalian;
use GuzzleHttp\Client;


class OnLeaveUsers extends ETS
{

    public string $dates;

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
        $this->attendanceData = [];

        if ($recordsResult === null) {
            return [];
        }

        foreach ($recordsResult as $record) {
            $attendanceData = [
                'EmployeeCode' => (string)$record['EmployeeCode'],
                'FullName' => (string)$record['FullName'],
                'BeginDate' => (string)$record['BeginDateInText'],
                'EndDate' => (string)$record['EndDateInText'],
                'VacationType' => (string)$record['VacationTypeInText'],
            ];

            if ($attendanceData['VacationType'] === 'ساعتی') {
                $attendanceData['BeginTime'] = (string)$record['BeginTimeInText'];
                $attendanceData['EndTime'] = (string)$record['EndTimeInText'];
            }

            $attendanceData['Duration'] = $this->calculateDuration($attendanceData);

            $this->attendanceData[] = $attendanceData;
        }

        return $this->attendanceData;
    }

    private function calculateDuration(array $attendanceData)
    {
        if (str_contains($attendanceData['VacationType'], 'روزانه')) {
            $duration = floor((strtotime($attendanceData['EndDate']) - strtotime($attendanceData['BeginDate'])) / 86400);
            return $duration ?: 1.0;
        }
        if ($attendanceData['VacationType'] === 'ساعتی') {
            return number_format((strtotime($attendanceData['EndTime']) - strtotime($attendanceData['BeginTime'])) / 3600, 2);
        }

        return '';
    }

    public function updateUsers(): void
    {
        $existingRecords = Leave::whereIn('employee_code', array_column($this->attendanceData, 'EmployeeCode'))
            ->whereDate('created_at', Carbon::today())
            ->get();

        if (!$existingRecords) {
            foreach ($this->attendanceData as $attendance) {
                Leave::create([
                    'employee_code' => $attendance['EmployeeCode'],
                    'employee_name' => $attendance['FullName'],
                    'begin_date' => $attendance['BeginDate'] ?? null,
                    'end_date' => $attendance['EndDate'] ?? null,
                    'leave_type' => $attendance['VacationType'],
                    'begin_time' => $attendance['BeginTime'] ?? null,
                    'end_time' => $attendance['EndTime'] ?? null,
                    'duration' => $attendance['Duration'],
                    'note' => '',
                ]);
            }
        }
    }
}
