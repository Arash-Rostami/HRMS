<?php

use App\Http\Livewire\Suggestion\ReviewSubmission;
use App\Http\Livewire\Suggestion\SuggestionData;
use App\Http\Livewire\Suggestion\SuggestionSubmission;
use App\Models\DMS;
use App\Models\Feed;
use App\Models\Park;
use App\Models\Profile;
use App\Models\Survey;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Dashboard;
use App\Services\DashboardDesign;
use App\Services\Date;
use App\Services\DepartmentDetails;
use App\Services\ISPservice;
use App\Services\Reservation;
use App\Services\TimeOfDay;
use App\Services\UserStatistics;
use App\Services\Utility;
use App\Services\WeatherAPI;
use Illuminate\Support\Facades\Cache;
use Morilog\Jalali\Jalalian;


function canCancelSuggestion($record)
{
    return (isSuggester($record->user_id)) && (!isSuggestionResponded($record)) && ($record->abort != 'yes');
}

function canReserveSeat($user): bool
{
    return Reservation::canReserveSeat($user);
}

function canReserveSpot($user): bool
{
    return Reservation::canReserveSpot($user);
}

function changeToDateFormat($date): string
{
    return Utility::changeToDateFormat($date);
}

function confirmDesk($desk): bool
{
    return Reservation::confirmDesk($desk);
}

function confirmParking($space): bool
{
    return Reservation::confirmParking($space);
}

function convertFromUnix($unix): string
{
    return Date::convertFromUnix($unix);
}

function convertTheClickedDayIntoFarsi($day): string
{
    return Date::convertTheClickedDayIntoFarsi($day);
}

function convertTheClickedDayIntoLatin($day): string
{
    return Date::convertTheClickedDayIntoLatin($day);
}

function convertTimeStamp($date)
{
    return Date::convertTimeStamp($date);
}


function countNumberOfDaysPassed()
{
    static $daysPassed = null;

    if ($daysPassed === null) {
        $startDate = auth()->user()?->profile?->start_date;
        $daysPassed = $startDate ? auth()->user()->profile->countDaysPassedSince($startDate) : ' ';
    }

    return $daysPassed;
}

function countNumberOfDaysToBirthday()
{
    static $daysToBirthday = null;

    if ($daysToBirthday === null) {
        $birthdate = auth()->user()?->profile?->birthdate;
        $daysToBirthday = $birthdate ? auth()->user()->profile->countNumberOfDaysTo($birthdate) : ' ';
    }

    return $daysToBirthday;
}

function countOffSiteUsers()
{
    static $count = null;

    if ($count === null) {
        $count = User::countOffSite();
    }

    return $count;
}

function countOnLeaveUsers()
{
    static $count = null;

    if ($count === null) {
        $count = User::countOnLeave();
    }

    return $count;
}

function countOnSiteUsers()
{
    static $count = null;

    if ($count === null) {
        $count = User::countOnSite();
    }

    return $count;
}

function getDashboardModel()
{
    return Dashboard::getDashboardModel();
}

function getDashboardType(): string
{
    return Dashboard::getDashboardType();
}

function getExecutionProcedureIcon($status)
{
    $iconMap = [
        'yes' => ['src' => '/img/user/check_icon.png', 'alt' => 'yes'],
        'pending' => ['src' => '/img/user/pending_icon.png', 'alt' => 'pending'],
        'no' => ['src' => '/img/user/no_icon.png', 'alt' => 'no']
    ];

    return $iconMap[$status] ?? $iconMap['no'];
}

function getPersianNamesOfDepts()
{
    return DepartmentDetails::getDepartmentsDescriptions();
}

function getCodesOfDepts($description)
{
    return DepartmentDetails::getDepartmentDetails($description);
}

function getEnglishNameOfDepartment($department)
{
    return DepartmentDetails::getName($department);
}

function getFarsiNameOfDepartment($department)
{
    return DepartmentDetails::getDescription($department);
}

function getPersonnelCode()
{
    static $code = null;

    if ($code === null) {
        $code = auth()->user()?->profile?->personnel_id ?: '';
    }

    return $code;
}

function getOpenTicketCount()
{
    static $count = null;

    if ($count === null) {
        $count = Ticket::getOpenTicketCount();
    }

    return $count;
}

function getInProgressTicketCount()
{
    static $count = null;

    if ($count === null) {
        $count = Ticket::getInProgressTicketCount();
    }

    return $count;
}

function getUnsignedDocCount()
{
    static $count = null;

    if ($count === null) {
        $count = DMS::getUnsignedDocumentsCount();
    }

    return $count;
}

function getUnreadDocCount()
{
    static $count = null;

    if ($count === null) {
        $count = DMS::getNotReadDocumentsCount();
    }

    return $count;
}

function getTodayFeedCount(): int
{
    $cacheKey = 'today_feed_count';
    $cacheDuration = now()->addMinutes(10);

    return Cache::remember($cacheKey, $cacheDuration, function () {
        return Feed::getTodayCount();
    });
}

function getTodoCount(): int
{
    $userId = auth()->id();
    $cacheKey = 'todo_count_' . $userId;
    $cacheDuration = now()->addMinutes(10);
    return Cache::remember($cacheKey, $cacheDuration, fn() => Task::getTodoCount($userId));
}

function getInProgressCount(): int
{
    $userId = auth()->id();
    $cacheKey = 'in_progress_count_' . $userId;
    $cacheDuration = now()->addMinutes(10);
    return Cache::remember($cacheKey, $cacheDuration, fn() => Task::getInProgressCount($userId));
}

function hasCancelledMore($user)
{
    return Park::countUserCancellation($user);
}

function hasChosenAnalytics()
{
    return Cache::has('profile_initiate_analytics_' . auth()->user()->id);
}

function hasChosenMusic()
{
    return Cache::has('profile_initiate_music_' . auth()->user()->id);
}

function hasChosenEnergy()
{
    return Cache::has('profile_initiate_energy_' . auth()->user()->id);
}

function hasChosenDMS()
{
    return Cache::has('profile_initiate_dms_' . auth()->user()->id);
}

function hasChosenTHS()
{
    return Cache::has('profile_initiate_ths_' . auth()->user()->id);
}

function hasChosenDelegation()
{
    return Cache::has('profile_initiate_delegation_' . auth()->user()->id);
}

function hasChosenOnboarding()
{
    return Cache::has('profile_initiate_onboarding_' . auth()->user()->id);
}

function hasChosenSuggestion()
{
    return Cache::has('profile_initiate_suggestion_' . auth()->user()->id);
}

function hasChosenSurveys()
{
    return Cache::has('profile_initiate_surveys_' . auth()->user()->id);
}

function hasGivenFeedback($id)
{
    return ReviewSubmission::isFeedbackSent($id);
}

function hasNoEmptyFields()
{
    static $result = null;

    if ($result === null) {
        $profile = optional(auth()->user())->profile;
        $result = optional($profile)->hasNoEmptyFields();
    }

    return $result;
}

function hasUserReserved(): bool
{
    return Reservation::hasUserReserved();
}

function initializeString($string)
{
    return strtoupper(substr($string, 0, 1));
}

function isAborted($record)
{
    return SuggestionData::isSuggestionAborted($record);
}

function isAwaitingDecision($record)
{
    return SuggestionData::isSuggestionAwaitingDecision($record);
}

function isAdmin($user = null)
{
    return Utility::isAdmin($user);
}

function isAdminButNotDev($user = null)
{
    return Utility::isAdminButNotDev($user);
}

function isAdminPage(): bool
{
    return Utility::isAdminPage();
}

function isAwaitingManager($id)
{
    return SuggestionData::isSuggestionCompleted($id);
}

function isDarkMode(): bool
{
    return Utility::isDarkMode();
}

function isOptionalQuestionnairePeriod($user = null): bool
{
    $user = $user ?? auth()->user();

    if (!$user) return false;

    $hasCompleted = $user->latestEnergyTest && $user->latestEnergyTest->completed_at->isCurrentMonth();

    if ($hasCompleted) return false;

    $dayOfMonth = Jalalian::fromCarbon(now())->getDay();

    if ($dayOfMonth >= 20 && $dayOfMonth < 25) return true;

    return false;
}

function isForcedQuestionnairePeriod($user = null): bool
{
    $user = $user ?? auth()->user();
    if (!$user) return false;

    $dayOfMonth = Jalalian::fromCarbon(now())->getDay();
    $isWithinForcedDateRange = ($dayOfMonth >= 25 && $dayOfMonth <= 30);

    if (!$isWithinForcedDateRange) return false;

    if (!$user->latestEnergyTest || !$user->latestEnergyTest->completed_at) return true;


    $completedJalali = Jalalian::fromCarbon($user->latestEnergyTest->completed_at);
    $currentJalali = Jalalian::fromCarbon(now());

    return !($completedJalali->getYear() === $currentJalali->getYear() && $completedJalali->getMonth() === $currentJalali->getMonth());
}

function isLightMode(): bool
{
    return Utility::isLightMode();
}

function isDepartmentManager()
{
    static $isManager = null;

    if ($isManager === null) {
        $profile = auth()->user()->profile;
        list($managerPresent, $supervisorPresent) = SuggestionData::getNumberOfManagerSupervisor($profile->department);

        if (($managerPresent && $profile->position == 'manager') or (!$managerPresent && $supervisorPresent && $profile->position == 'supervisor')) {
            $isManager = true;
        } else {
            $isManager = false;
        }
    }

    return $isManager;
}

function isFarsi($content): bool
{
    return Utility::isFarsi($content);
}

function isFinalCountDown()
{
    return (countNumberOfDaysToBirthday() < 11);
}

function isInternalISP()
{
    static $isInternal = null;

    if ($isInternal === null) {
        $isInternal = ISPservice::isISPinternal(request()->ip());
    }

    return $isInternal;
}

function isManager()
{
    $profile = auth()->user()->profile;
    return ($profile->department === 'MA') && ($profile->position === 'manager');
}


function isMaxedOut($user, $park): bool
{
    return Reservation::hasUserMaxed($user, $park);
}

function isMultipleDays(): bool
{
    return (Reservation::countDaysOfReservation() > 1);
}


function isNotInCenter($space): bool
{
    return DashboardDesign::isNotInCenter($space);
}

function isNotInEditingMode()
{
    $profileCacheKey = 'profile_edit_user_' . auth()->user()->id;

    return !Cache::get($profileCacheKey);
}

function isNotMobileDevice()
{
    static $isNotMobile = null;

    if ($isNotMobile === null) {
        $isNotMobile = !preg_match(
            '/(android|webos|iphone|ipad|ipod|blackberry|windows phone)/',
            strtolower(Request::header('user-agent'))
        );
    }

    return $isNotMobile;
}


function isOneDay(): bool
{
    return (Reservation::countDaysOfReservation() == 1);
}

function isParking(): bool
{
    return Utility::isParking(url()->previous());
}

function isRelevantDepManager($dep)
{
    $profile = auth()->user()->profile;
    return ($profile->department == $dep) && ($profile->position == 'manager' or $profile->position == 'supervisor');
}


function isSpecialDay($dateColumn): bool
{
    return (
        // Check if the user is currently active (not ended their tenure)
        optional(auth()->user()->profile)->end_date === null
        &&
        // Check if today matches the user's special day (i.e. birthday or work anniversary)
        now()->format('m-d') === date('m-d', strtotime(optional(auth()->user()->profile)->{$dateColumn}))
        &&
        // Check if the user hasn't seen the special day message yet (not cached)
        !cache()->has($dateColumn . auth()->id())
    );
}


function isSuggester($record)
{
    return $record == auth()->id();
}

function isSuggestionResponded($record)
{
    return ($record->stage == 'awaiting_decision' or $record->reviews->contains('department', 'مدیریت'));
}

function isRtl(string $text): bool
{
    return (bool)preg_match('/\p{Arabic}/u', $text);
}

function isThemeOrModeActivated($color)
{
    return Utility::isTheme($color) == null && Utility::isMode($color) == null;
}

function isTimeSkipped(): bool
{
    return Utility::isTimeSkipped();
}

function isTypeNotGiven(): bool
{
    return Utility::isDashboardTypeNotGiven();
}

function isUserActive($user): bool
{
    return User::isUserActive($user);
}

function isUserDep($dep, $userDep)
{
    return $dep == UserStatistics::$departmentPersianNames[$userDep];
}

function isUserPanel(): bool
{
    return Utility::isUserPanel();
}

function isWeekend(string $y, string $m, string $d)
{
    $dateString = $y . "-" . makeDoubleDigit($m) . "-" . makeDoubleDigit($d);

    return Utility::isWeekend($dateString);
}

function listUntakenNumbers($url)
{
    return Reservation::listUntakenNumbers($url);
}

function listWeekDays(): array
{
    return Date::listWeekDays();
}

function makeDate($input, $request): string
{
    return Utility::makeDate($input, $request);
}

function makeDay($input, $request): string
{
    return Utility::makeDay($input, $request);
}

function makeDoubleDigit($day): string
{
    return Utility::makeDoubleDigit($day);
}

function makeHour($input, $request): string
{
    return Utility::makeHour($input, $request);
}

function makeMonth($input, $request): string
{
    return Utility::makeMonth($input, $request);
}

function makeTime($input, $request): string
{
    return Utility::makeTime($input, $request);
}

function makeYear($input, $request): string
{
    return Utility::makeYear($input, $request);
}

function randomizeDesks(): string
{
    return DashboardDesign::randomizeDesks();
}

function removeHTMLTags($string)
{
    return str_replace('&nbsp;', ' ', strip_tags($string));
}

function shorten($day): string
{
    return Date::shortenDaysName($day);
}

function showCar(): string
{
    return DashboardDesign::showCar();
}

function showClickedDay($date)
{
    return Dashboard::showClickedDay($date);
}

function showDateDivider(): string
{
    return Utility::showDateDivider();
}

function showDetails($space): void
{
    Reservation::showDetails($space);
}

function showExactTimeOfDay()
{
    return TimeOfDay::getImage();
}

function showFewFirstPersians($text, $num)
{
    return Utility::showInitialPersinaWords($text, $num);
}

function showFiftydChar($text)
{
    return mb_substr(strip_tags(html_entity_decode($text)), 0, 50) . (mb_strlen($text) > 50 ? '...' : '');
}

function showFlash($type, $message)
{
    Utility::showFlash($type, $message);
}

function showMainDashboardComponents()
{
    return isNotInEditingMode() && hasNoEmptyFields() && !hasChosenMusic() && !hasChosenSuggestion() &&
        !hasChosenOnboarding() && !hasChosenAnalytics() && !hasChosenSurveys() && !hasChosenDelegation()
        && !hasChosenDMS() && !hasChosenTHS() && !hasChosenEnergy();
    //        && !showToOnboardedUser()
}

function showMap($place)
{
    return Dashboard::showExtension($place);
}

function showMyArea($reservations)
{
    return Reservation::showMyArea($reservations);
}

function showObjects(): string
{
    return DashboardDesign::showObjects();
}

function getOfficeData()
{
    static $data = null;

    if ($data === null) {
        $data = Utility::hasOffice();
    }
    return $data;
}

function showOfficeCss()
{
    return getOfficeData()['css'];
}

function showOfficeTitle()
{
    return getOfficeData()['title'];
}

function showOnlyNumber($spot)
{
    return Utility::showOnlyNumber($spot);
}

function showOtherDashboard()
{
    return Utility::showOtherDashboard();
}

function getParkingData()
{
    static $data = null;

    if ($data === null) {
        $data = Utility::hasParking();
    }
    return $data;
}

function showParkingCss()
{
    return getParkingData()['css'];
}

function showParkingTitle()
{
    return getParkingData()['title'];
}


function showPresence()
{
    return Utility::generatePresenceCircle();
}

function showProfile()
{
    return !hasChosenMusic() && !hasChosenOnboarding() && !hasChosenAnalytics() && !hasChosenTHS() &&
        !hasChosenSurveys() && !hasChosenSuggestion() && !hasChosenDelegation() && !hasChosenDMS() &&
        !hasChosenEnergy();
    //        && !showToOnboardedUser()
}

function showQouta()
{
    return Dashboard::showQuotaMessage();
}

function showRating($rate)
{
    return Utility::showStarRating($rate);
}

function showRemainingReservations($number)
{
    return Dashboard::showRemainingReservations($number);
}

function showReservationId(): string
{
    return Reservation::getReservationId();
}

function showReservationNumber()
{
    return Reservation::getReservationNumber();
}

function showReserveArea($number)
{
    return Reservation::showReserveArea($number);
}


function showSpotNumber()
{
    return ltrim(strstr(URL::current(), "map/"), "map/");
}

function showSpots()
{
    return Reservation::showSpots();
}

function showSuggestion()
{
    return hasChosenSuggestion();
}

function showSuggestionBadge()
{
    return (SuggestionData::getMissingReviewsCount() > 0);
}


function showSuggestionCEOBadge()
{
    return (SuggestionSubmission::countCompletedSuggestion() > 0);
}

function showSuggestionBadgeNumber()
{
    static $count = null;

    if ($count === null) {
        $count = SuggestionData::getMissingReviewsCount();
    }

    return $count;
}

function showSuggestionCEOBadgeNumber()
{
    static $count = null;

    if ($count === null) {
        $count = SuggestionSubmission::countCompletedSuggestion();
    }

    return $count;
}


function showSurvey()
{
    return hasChosenSurveys()//        || showToOnboardedUser()
        ;
}

function getWeatherData()
{
    static $weatherData = null;

    if ($weatherData === null) {
        $weatherData = WeatherAPI::getWeather();
    }

    return $weatherData;
}

function showTemperature()
{
    return getWeatherData()['temperature'] ?? 'N/A';
}

function showWeather()
{
    return getWeatherData()['weather'] ?? 'N/A';
}


function showToOnboardedUser()
{
    return collect([30, 60, 90])->first(function ($day) {
            return Profile::getDaysUser($day)->contains(auth()->user()->id) && !Survey::hasUserRecord($day);
        }) !== null;
}

function showTotalAvailableReservations(): int
{
    return Dashboard::showTotalAvailableReservations();
}

function showTotalReservations($number): int
{
    return Dashboard::showTotalReservations($number);
}

function showUserProfile($user)
{
    $image = optional($user->profile)->image;

    return $image && file_exists(public_path($image)) ? asset($image) : asset('img/user/profiles/user.png');
}

function toJalali($date, string $format = 'Y, m, d')
{
    return Date::toJalali($date, $format);
}

function tel($num)
{
    return strlen($num) > 4 ? substr($num, 0, 4) . '-' . substr($num, 4, 7) : $num;
}


function translateDelegationLevel($delegation)
{
    return match ($delegation) {
        'decision_implementation' => 'تصمیم گیری و اجرا',
        'review_proposal' => 'بررسی و پیشنهاد',
        'review_reporting' => 'بررسی و گزارش',
        'decision_reporting' => 'تصمیم گیری و گزارش',
        default => 'داده نشده!',
    };
}

function translateExecutionProcedure($process)
{
    return match ($process) {
        'yes' => 'دارد',
        'no' => 'ندارد',
        'pending' => 'در انتظار (تصویب / بروزرسانی) ',
        default => 'داده نشده!',
    };
}

function translateImpactScore($score)
{
    return match ($score) {
        'very_high' => 'خیلی زیاد',
        'high' => 'زیاد',
        'medium' => 'متوسط',
        'low' => 'کم',
        default => 'داده نشده!',
    };
}


function translateRepeatFrequency($frequency)
{
    return match ($frequency) {
        'yearly' => 'یک بار در سال',
        'biyearly' => 'دو بار در سال',
        'quarterly' => 'فصلی',
        '5_times_a_year' => 'پنج بار در سال',
        'frequent' => 'بیشتر از 4  بار در ماه',
        'regular' => 'بین 1 تا 4 بار در ماه',
        'occasional' => 'کمتر از  بار در ماه',
        default => 'داده نشده!',
    };
}

