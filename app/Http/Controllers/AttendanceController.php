<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Services\api\OnLeaveUsers;
use App\Services\Date;
use App\Services\ETSClient;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
    public function updateAttendance()
    {
        try {
            return (new ETSClient())->updateAttendance();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating attendance.', 'error' => $e->getMessage(),
            ], 500);
        }
//        return  abort(404, 'NOT ALLOWED');
    }

    public function updateLeave()
    {
        try {
            return (new ETSClient())->updateLeave();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while persisting leaves.', 'error' => $e->getMessage(),
            ], 500);
        }
    }


//    public function getCRMAccountInfo(Request $request)
//    {
//        // Get the login credentials
//        $loginData = [
//            "utype" => 'persol',
//            'user_name' => 's.salehin',
//            'password' => '38aa7a9ee7d859e053beb13f43e4305a',
//            "language" => "en_US",
//        ];
//
//        // Create a Guzzle HTTP client with SSL verification enabled
//        $client = new Client(['verify' => false]);
//
//        // Send the first API request to obtain the token
//        $response = $client->post('https://app.sarvcrm.com/API.php?method=Login', ['form_params' => $loginData,]);
//
//        // If the first API request was successful, get the token
//        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
//            $result = json_decode($response->getBody(), true);
//            $token = $result['data']['token'];
//
//
//            // Get the current page number from the request or default to page 1
//            $currentPage = $request->input('page', 1);
//
//            // Calculate the offset based on the page number
//            $perPage = 100; // Number of items per page
//            $offset = ($currentPage - 1) * $perPage;
//
//            // Send the second API request to retrieve the account data
//            $response = $client->post('https://app.sarvcrm.com/API.php?method=Retrieve&module=Accounts', [
//                'headers' => [
//                    'Authorization' => 'Bearer ' . $token,
//                ],
//                'form_params' => [
//                    "query" => "",
//                    "selected_fields" => [
//                        "name",
//                        "type",
//                        "assigned_user_name",
//                        "primary_number_raw",
//                    ],
//                    "max_results" => 500,
//                    "offset" => $offset,
//                    "order_by" => ["DESC", "accounts.date_entered"],
//                ],
//            ]);
//
//            // If the second API request was successful, paginate the account data
//            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
//                $secondApiResponse = json_decode($response->getBody(), true);
//                $data = $secondApiResponse['data'];
//
//                // Paginate the data
//                $paginator = new LengthAwarePaginator($data, count($data), $perPage, $currentPage);
//
//                // Set the URL for pagination
//                $paginator->setPath(url('/api/test'));
//
//                // Pass the paginated data to a view
//                return view('components.user.marketing.statistics', compact('paginator'));
//            } else {
//                $error = $response->getBody();
//                error_log("Error in the second API request: " . $error);
//            }
//        } else {
//            $error = $response->getBody();
//            error_log("Error in the first API request: " . $error);
//        }
//    }
}
