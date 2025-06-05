<?php

namespace App\Services\api;

use App\Models\Profile;
use App\Models\Timesheet;
use Carbon\Carbon;

class OnsiteUsers extends ETS
{

    public function prepareSoapRequest(): string
    {
        return <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetAllIoRecordsByDate xmlns="http://tempuri.org/">
      <date>{$this->currentDate}</date>
    </GetAllIoRecordsByDate>
  </soap:Body>
</soap:Envelope>
EOT;
    }

    public function sendSoapRequest(string $soapRequest): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->post($this->ip, [
            'headers' => [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://tempuri.org/GetAllIoRecordsByDate',
            ],
            'body' => $soapRequest,
        ]);
    }

    public function receiveSoapResponse(\Psr\Http\Message\ResponseInterface $response): null|false|\SimpleXMLElement
    {
        $soapBody = $this->extractBody($response);

        // Find the GetAllIoRecordsByDateResponse element within soapBody
        $getRecordsResponse = $soapBody->children('http://tempuri.org/')->GetAllIoRecordsByDateResponse;

        // Find the GetAllIoRecordsByDateResult element within GetIoRecordsResponse
        return $getRecordsResponse->GetAllIoRecordsByDateResult->IoRecordDataModel;
    }

    public function processSoapResponse(\SimpleXMLElement|bool|null $recordsResult): array
    {
        if ($recordsResult !== null) {
            foreach ($recordsResult as $attendance) {
                $this->attendanceData = $this->processAttendance($attendance);
            }
            // Update presence status based on entry and exit times for mission records
            foreach ($this->attendanceData as $employeeCode => $data) {

                $this->attendanceData = $this->changePresence($employeeCode);
            }

            return $this->attendanceData;
        }

        return $this->attendanceData;
    }


    public function persistData()
    {
        $existingRecords = Timesheet::whereIn('employee_code', array_column($this->attendanceData, 'employeeCode'))
            ->whereDate('created_at', Carbon::today())
            ->get();

        $newRecords = collect($this->attendanceData)->filter(function ($attendance) use ($existingRecords) {
            return !empty($attendance['exitTime']) && !$existingRecords->contains('employee_code', $attendance['employeeCode']);
        });

        foreach ($newRecords as $record) {
            Timesheet::create([
                'employee_code' => $record['employeeCode'],
                'employee_name' => $record['employeeName'],
                'entry_time' => $record['entryTime'],
                'exit_time' => $record['exitTime'],
                'mission' => $record['mission'],
                'presence' => $record['presence'],
            ]);
        }
    }


    public function processAttendance(mixed $attendance): array
    {
        $employeeCode = (string)$attendance->EmployeeCode;
        $employeeName = (string)$attendance->FullName;
        $finalTimeInText = (string)$attendance->FinalTimeInText;

        if (!isset($this->attendanceData[$employeeCode])) {
            $this->attendanceData[$employeeCode] = [
                'employeeCode' => $employeeCode,
                'employeeName' => $employeeName,
                'entryTime' => null,
                'exitTime' => null,
                'mission' => false,
            ];
        }

        // Determine if it's an entry or exit time
        if (isset($attendance->FinalRecordIoTypeInText)) {
            if ($attendance->FinalRecordIoTypeInText == 'ورود') {
                $this->attendanceData[$employeeCode]['entryTime'] = $finalTimeInText;
            } elseif ($attendance->FinalRecordIoTypeInText == 'خروج') {
                $this->attendanceData[$employeeCode]['exitTime'] = $finalTimeInText;
            }
        }
        return $this->attendanceData;
    }

    public function updatePresentUsers()
    {
        foreach ($this->attendanceData as $attendance) {
            $profile = Profile::findByPersonnelId($attendance['employeeCode']);
            if ($profile) {
                if ($attendance['presence'] == 'onsite') {
                    $this->logUserIn($profile);
                };
                if ($attendance['presence'] == 'on-leave') {
                    $this->logUserOut($profile);
                };
            }
        }
    }

    public function updateNonPresentUsers(): void
    {
        $nonPresentProfiles = Profile::findNonPresentProfiles($this->attendanceData);

        // Update non-present profiles' presence status
        foreach ($nonPresentProfiles as $profile) {
            if (optional($profile->user)->presence !== 'on-leave') {
                $this->logUserOut($profile);
            }
        }
    }

    public function updateUsers(): void
    {
        $this->updatePresentUsers();

        $this->persistData();

        $this->updateNonPresentUsers();
    }
}

