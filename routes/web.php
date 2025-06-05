<?php

//use App\Http\Controllers\ISPController;
use App\Http\Controllers\Cr24Controller;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;

//use \App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReservationController;

//use App\Http\Controllers\SalesDashController;
use App\Http\Controllers\SarvCRMController;
use App\Http\Controllers\ShopHomePageController;
use App\Http\Controllers\UserEmailController;
use App\Http\Controllers\UserLoginTest;
use App\Http\Controllers\UserSmsController;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserPanelController;

//use App\Http\Controllers\WeatherController;

use Illuminate\Support\Facades\Artisan;

//for the test purpose
//Route::view('htmx','/test');


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'Cache cleared successfully.';
});


//Route::get('/test-email', function () {
//    $suggestionsByStatus = Suggestion::where('abort', 'no')
//        ->whereIn('stage', ['pending', 'team_remarks', 'dept_remarks', 'awaiting_decision'])
//        ->with(['user.profile', 'reviews.user.profile'])
//        ->get()
//        ->groupBy('stage');
//
//    dd($suggestionsByStatus);
//});



// Parking daily live view/report +
Route::get('daily-report-{type}', [ReservationController::class, 'list']);

// homepage | landing page redirect w/o prefix +
Route::get('/', function () {
    return redirect()->route('landing.page');
});
// homepage | login page mobile +
Route::match(['get', 'post'], '/otp', [UserPanelController::class, 'handleOtp'])->name('otp.handle');

// homepage +
Route::get('welcome', [LoginController::class, 'index'])->name('landing.page');

// Users' panel
Route::middleware(['auth'])->prefix('main')->group(function () {


    // panel +
    Route::get('/', [UserPanelController::class, 'index'])->middleware('lscache')->name('user.panel');
    // panel edit +
    Route::get('/edit', [UserPanelController::class, 'edit'])->name('user.panel.edit');
    // panel music +
    Route::get('/music', [UserPanelController::class, 'loadMusic'])->name('user.panel.music');
    // panel DMS +
    Route::get('/dms', [UserPanelController::class, 'loadDMS'])->name('user.panel.dms');
    // panel THS +
    Route::get('/ths', [UserPanelController::class, 'loadTHS'])->name('user.panel.ths');
    // panel delegation +
    Route::get('/delegation', [UserPanelController::class, 'loadDelegation'])->name('user.panel.delegation');
    // panel onboarding +
    Route::get('/onboarding', [UserPanelController::class, 'loadOnboarding'])->name('user.panel.onboarding');
    // panel survey +
    Route::get('/survey', [UserPanelController::class, 'loadSurvey'])->name('user.panel.survey');
    // panel suggestion +
    Route::get('/suggestion', [UserPanelController::class, 'loadSuggestion'])->name('user.panel.suggestion');
    // panel analytics +
    Route::get('/analytics', [UserPanelController::class, 'viewAnalytics'])->name('user.panel.analytics');
    // presence +
    Route::get('/presence/{status}', [UserPanelController::class, 'changePresence'])->name('user.presence');

    Route::get('/send-email', [UserEmailController::class, 'show']);
    // email dispatch #
    Route::post('/send-email', [UserEmailController::class, 'send'])->name('send-email');
    // SMS dispatch #
    Route::post('/send-sms', [UserSmsController::class, 'send'])->name('send-sms');

//    Route::get('/isp', [ISPController::class, 'getISP'])->name('isp');

    // this is for testing purposes
//    Route::get('/crm', [SalesDashController::class, 'index'])->name('crm');
});

// Not making file accessible from outside
Route::get('/authorized/{file}', [FileController::class, 'serveFile'])
    ->where('file', '.*')
    ->middleware('auth')
    ->name('secure-file');
Route::get('/authorized-document/{file?}', [FileController::class, 'serveDocument'])
    ->where('file', '.*')
    ->middleware('auth')
    ->name('protected-docs');

// Reservation Application
Route::prefix('sms')->group(function () {
    // parking map +
    Route::view('/parking-map/{number}', 'parking-map');
    // office map +
    Route::view('/office-map/{number}', 'office-map')->name('office-map');
    // dashboard #
    Route::get('/dashboard', [LoginController::class, 'show'])
        ->middleware(['auth'])->name('dashboard');
    // change theme or mode +
    Route::get('/{theme}', [LoginController::class, 'changeTheme'])
        ->name('landing-page');
    // index reservation #
    Route::get('/reservations/{number}', [ReservationController::class, 'show'])
        ->middleware(['auth'])->name('reservations.show');
    // save reservation #
    Route::post('/reservations', [ReservationController::class, 'store'])
        ->middleware(['auth'])->name('reservations.store');
    // search thru reservation #
    Route::post('/reservations/search', [ReservationController::class, 'search'])
        ->middleware(['auth'])->name('reservations.search');
    // update/soft-delete reservation #
    Route::patch('/reservations/{number}', [ReservationController::class, 'update'])
        ->middleware(['auth'])->name('reservations.update');
    // edit/add to suspension/cancellation #
    Route::post('/reservations/suspend/{number}', [ReservationController::class, 'edit'])
        ->middleware(['auth'])->name('reservations.edit');
});


// CRM API
Route::prefix('crm')->group(function () {
    // fetching crm api +
    Route::view('/login', 'api/sarvLogin')->name('crm');
//
    Route::post('/login', [SarvCRMController::class, 'loginCrm'])->name('crm-login');
    Route::post('/logout', [SarvCRMController::class, 'logoutCrm'])->name('crm-logout');
    Route::get('/contacts', [SarvCRMController::class, 'getModules'])->name('crm-contacts');
});


// PERSOL's Shop
Route::prefix('shop')->middleware(['auth'])->group(function () {
    // landing page of shop +
    Route::get('/', [ShopHomePageController::class, 'index'])->name('shop');
    Route::view('/weather', 'components.weather');

});


// import login/signup/...
require __DIR__ . '/auth.php';
// default error page +
Route::get('/error-page', function () {
    return view('errors.default');
})->name('error.page');

Route::fallback(function () {
    return view('errors.default');
});
