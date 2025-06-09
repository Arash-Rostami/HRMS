<?php

namespace App\Services;

use App\Services\api\OffsiteUsers;
use App\Services\api\OnLeaveUsers;
use App\Services\api\OnsiteUsers;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;


class ETSClient
{
    public function updateAttendance()
    {
        // Create instances of OnsiteUsers and OffsiteUsers classes
        $onsiteUserService = new OnsiteUsers();
        $offsiteUserService = new OffsiteUsers();

        // Prepare SOAP requests for attendance and mission registration
        $attendanceRequest = $onsiteUserService->prepareSoapRequest();
        $missionRequest = $offsiteUserService->prepareSoapRequest();

        // Send SOAP requests and receive SOAP responses for attendance and mission
        $attendanceResponse = $onsiteUserService->sendSoapRequest($attendanceRequest);
        $missionResponse = $offsiteUserService->sendSoapRequest($missionRequest);

        // Receive and process SOAP responses for office and mission records
        $officeAttendanceRecords = $onsiteUserService->receiveSoapResponse($attendanceResponse);
        $offsiteMissionRecords = $offsiteUserService->receiveSoapResponse($missionResponse);

        // Process and update attendance data for office and mission records
        $updatedOfficeAttendance = $onsiteUserService->processSoapResponse($officeAttendanceRecords);
        $updatedOffsiteMission = $offsiteUserService->processSoapResponse($offsiteMissionRecords);

        // Update presence status for onsite and offsite users
        $onsiteUserService->updateUsers();
        $offsiteUserService->updateUsers();

        // Return JSON response with updated attendance and mission data
        return response()->json([
            'message' => 'Attendance and mission data updated successfully',
            'data' => [
                !empty($updatedOfficeAttendance) ? $updatedOfficeAttendance : 'No attendance record found in the office!',
                !empty($updatedOffsiteMission) ? $updatedOffsiteMission : 'No mission record found outside the office!',
            ]
        ]);
    }

    public function updateLeave()
    {
        // Create an instance of OnLeaveUsers class
        $leaveUsersService = new OnLeaveUsers();

        // Prepare SOAP request for leave data
        $soapRequest = $leaveUsersService->prepareSoapRequest();

        // Send SOAP request and receive SOAP response
        $soapResponse = $leaveUsersService->sendSoapRequest($soapRequest);

        // Extract and process SOAP response for leave data
        $leaveData = $leaveUsersService->receiveSoapResponse($soapResponse);

        // Combine or update all leave data
        $allLeaveData = $leaveUsersService->processSoapResponse($leaveData);

        // Process leave data
        $processedLeaveData = $leaveUsersService->processAttendance($allLeaveData);

        // Persist data into DB - leaves table | Leave model
        $leaveUsersService->updateUsers();

        return response()->json([
            'message' => 'Attendance data on leaves processed successfully',
            'data' => [
                !empty($processedLeaveData) ? $processedLeaveData : 'There were no leave record to be persisted :(',
            ]
        ]);
    }

    public function updateLeaveForDateRange(int $fromDays = 1, int $toDays = 90)
    {
        $original = ini_get('max_execution_time');
        ini_set('max_execution_time', 600);

        $leaveUsersService = new OnLeaveUsers();
        $allRawLeaveData = [];
        $delayInSeconds = 0.3;
        $totalDays = $toDays - $fromDays + 1;
        $processedDays = 0;

        for ($i = $fromDays; $i <= $toDays; $i++) {
            $dateToFetch = Jalalian::now()->subDays($i)->format('Y/m/d');
            $leaveUsersService->currentDate = $dateToFetch;

            try {
                $soapRequest = $leaveUsersService->prepareSoapRequest();
                $soapResponse = $leaveUsersService->sendSoapRequest($soapRequest);
                $dailyLeaveData = $leaveUsersService->receiveSoapResponse($soapResponse);

                if ($dailyLeaveData) {
                    $allRawLeaveData = array_merge($allRawLeaveData, $leaveUsersService->processSoapResponse($dailyLeaveData));
                }

                $processedDays++;
                Log::info("Successfully fetched leave data for {$dateToFetch} ({$processedDays}/{$totalDays})");

            } catch (\Exception $e) {
                Log::error("API Error fetching leave data for {$dateToFetch}: {$e->getMessage()}");
            }

            if ($i < $toDays) sleep($delayInSeconds);
        }

        $processedLeaveData = $leaveUsersService->processAttendance($allRawLeaveData);
        $leaveUsersService->updateUsers();
        ini_set('max_execution_time', $original);

        return response()->json([
            'message' => "Leave data processed successfully for days {$fromDays} to {$toDays}",
            'data' => [
                'records_processed' => count($processedLeaveData),
                'days_fetched' => $totalDays,
                'from_days_ago' => $fromDays,
                'to_days_ago' => $toDays
            ]
        ]);
    }
}
