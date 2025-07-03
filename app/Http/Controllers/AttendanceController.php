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
}
