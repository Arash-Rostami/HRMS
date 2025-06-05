<?php


use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SarvCRMController;
use App\Http\Controllers\UserPanelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// to Update Users based on AJAX api requests sent by pcs or laptops
Route::post('/{user}/{isp}/{presence}', [UserPanelController::class, 'updatePresence']);

// to Update Users status/presence based on ETS api requests
Route::get('/fetch-attendance', [AttendanceController::class, 'updateAttendance']);

// to Update Users leave based on ETS api requests
Route::get('/fetch-leave', [AttendanceController::class, 'updateLeave']);


//Route::get('/test', [AttendanceController::class, 'getCRMAccountInfo'])->name('apiTest');



