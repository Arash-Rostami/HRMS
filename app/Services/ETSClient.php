<?php

namespace App\Services;

use App\Services\api\OffsiteUsers;
use App\Services\api\OnLeaveUsers;
use App\Services\api\OnsiteUsers;
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

        /* *** Uncomment the following line just to increase the timespan of update instead of daily to specific numbers of days
                   $allLeaveData = [];
                   for ($daysAgo = 90; $daysAgo < 180; $daysAgo++) {
                // Calculate the date for which to fetch leave data
                   $leaveUsersService->dates = Jalalian::now()->subDays($daysAgo)->format('Y/m/d');
        */
        // Prepare SOAP request for leave data
        $soapRequest = $leaveUsersService->prepareSoapRequest();

        // Send SOAP request and receive SOAP response
        $soapResponse = $leaveUsersService->sendSoapRequest($soapRequest);

        // Extract and process SOAP response for leave data
        $leaveData = $leaveUsersService->receiveSoapResponse($soapResponse);

        /* *** Uncomment the following line just to increase the timespan of update instead of daily to specific numbers of days
                $allLeaveData = array_merge($allLeaveData, $leaveUsersService->processSoapResponse($leaveData));
        */
        // Combine or update all leave data
        $allLeaveData = $leaveUsersService->processSoapResponse($leaveData);

        // Process leave data
        $processedLeaveData = $leaveUsersService->processAttendance($allLeaveData);
//        }
        // Persist data into DB - leaves table | Leave model
        $leaveUsersService->updateUsers();

        return response()->json([
            'message' => 'Attendance data on leaves processed successfully',
            'data' => [
                !empty($processedLeaveData) ? $processedLeaveData : 'There were no leave record to be persisted :(',
            ]
        ]);
    }
}
