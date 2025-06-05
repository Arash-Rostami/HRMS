<?php

namespace App\Services\api;

use App\Models\Profile;

class OffsiteUsers extends ETS
{
    public function prepareSoapRequest(): string
    {
        return <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetAllMissionRegistrationsByDate xmlns="http://tempuri.org/">
      <date>{$this->currentDate}</date>
    </GetAllMissionRegistrationsByDate>
  </soap:Body>
</soap:Envelope>
EOT;
    }

    public function sendSoapRequest(string $soapRequest): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->post($this->ip, [
            'headers' => [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://tempuri.org/GetAllMissionRegistrationsByDate',
            ],
            'body' => $soapRequest,
        ]);
    }

    public function receiveSoapResponse(\Psr\Http\Message\ResponseInterface $response): null|false|\SimpleXMLElement
    {
        $soapBody = $this->extractBody($response);

        // Find the GetAllMissionRegistrationsByDateResponse element within soapBody
        $getMissionResponse = $soapBody->children('http://tempuri.org/')->GetAllMissionRegistrationsByDateResponse;

        // Find the GetAllMissionRegistrationsByDateResult element within GetMissionResponse
        return $getMissionResponse->GetAllMissionRegistrationsByDateResult->MissionRegistrationDataModel;
    }

    public function processSoapResponse(\SimpleXMLElement|bool|null $recordsResult): array
    {
        // Check if mission records were fetched before processing
        if ($recordsResult !== null) {
            foreach ($recordsResult as $attendance) {
                $this->attendanceData = $this->processAttendance($attendance);
            }
            // Update presence status based on entry and exit times for mission records
            foreach ($this->attendanceData as $employeeCode => $data) {
                $this->attendanceData = $this->changePresence($employeeCode);
            }
        }

        return $this->attendanceData;
    }

    public function processAttendance(mixed $attendance): array
    {
        $employeeCode = (string)$attendance->EmployeeCode;
        $acceptanceState = (string)$attendance->AcceptanceStateInText;
        $fullName = (string)$attendance->FullName;

        if (!isset($this->attendanceData[$employeeCode])) {
            $this->attendanceData[$employeeCode] = [
                'employeeCode' => $employeeCode,
                'employeeName' => $fullName,
                'entryTime' => null,
                'exitTime' => null,
                'mission' => false,
            ];
        }

        if (isset($this->attendanceData[$employeeCode]) && $acceptanceState != 'رد شده') {
            $this->attendanceData[$employeeCode]['mission'] = true;
        }

        return $this->attendanceData;
    }

    public function updateUsers(): void
    {
        // Update on-mission profiles' presence status
        foreach ($this->attendanceData as $attendance) {
            $profile = Profile::findByPersonnelId($attendance['employeeCode']);
            if ($attendance['mission'] && ($profile)) {
                $profile->user->update([
                    'presence' => 'off-site'
                ]);
            }
        }
    }
}
