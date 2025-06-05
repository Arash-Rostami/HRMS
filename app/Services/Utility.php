<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use LanguageDetection\Language;
use Morilog\Jalali\Jalalian;

/**
 * Class Utility
 * @package App\Services
 */
class Utility
{
    /**
     * @param $date
     * @return string
     */
    public static function changeToDateFormat($date): string
    {
        return explode(' ', $date)[0];
    }


    public static function generatePresenceCircle()
    {
        $user = auth()->user();
        $presence = $user->presence;

        $circleClass = '';
        $circleTitle = '';

        if (Cache::has('idle_' . $user->id)) {
            $circleClass = 'bg-red-500';
            $circleTitle = 'busy';
        } elseif ($presence === 'onsite') {
            $circleClass = 'bg-green-500';
            $circleTitle = 'onsite';
        } elseif ($presence === 'off-site') {
            $circleClass = 'bg-yellow-500';
            $circleTitle = 'off-site';
        }

        echo '<div class="w-2 h-2 rounded-full inline-block ' . $circleClass . '" title="' . $circleTitle . '"></div>';
    }

    public static function hasOffice(): array
    {
        if (auth()->user()->hasOffice()) {
            return ['css' => 'text-[#14532d]', 'title' => 'ON'];
        }
        return ['css' => ' ', 'title' => 'OFF'];
    }


    public static function hasParking(): array
    {
        if (auth()->user()->hasParking()) {
            return ['css' => 'text-[#14532d]', 'title' => 'ON'];
        }
        return ['css' => ' ', 'title' => 'OFF'];
    }


    /**
     * @return bool
     */
    public static function isAdminPage(): bool
    {
        return str_contains(url()->current(), 'admin');
    }


    /**
     * @param $user
     * @return bool
     */
    public static function isAdmin($user)
    {
        return $user->role == 'admin' or $user->role == 'developer';
    }


    /**
     * @param $user
     * @return bool
     */
    public static function isAdminButNotDev($user)
    {
        return $user->role == 'admin' && ($user->profile && $user->profile->department == 'MA');
    }

    /**
     * @return bool
     */
    public static function isDarkMode(): bool
    {

        $mode = Cookie::get('mode');

        // Check if cookie value is empty or null
        if (empty($mode) || $mode === null) {
            // Cookie value is empty or not set, return false
            return false;
        }

        // Check if cookie value is equal to "#1B232E"
        return ($mode === "#1B232E");
    }


    /**
     * @return bool
     */
    public static function isLightMode(): bool
    {

        // Check if the 'mode' cookie exists
        if (!Cookie::has('mode')) {
            return false;
        }

        // Get the value of the 'mode' cookie
        $mode = Cookie::get('mode');

        return ($mode == "#F1F1F1");
    }

    /**
     * @return bool
     */
    public static function isDashboardTypeNotGiven(): bool
    {
        return parse_url(url()->previous(), PHP_URL_QUERY) == '';
    }


    public static function isCalenderSet($input, $request)
    {
        return isset(json_decode($request->$input, true)['year']);
    }

    /**
     * @param $input
     * @param $request
     * @return bool
     */
    public static function isHourNotSet($input, $request): bool
    {
        return makeDoubleDigit(json_decode($request->$input, true)['hour']) == '12';
    }


    /**
     * @param $day
     * @return bool
     */
    public static function isInitialDaysOfMonth($day): bool
    {
        $currentDay = Date::getFarsiDay();
        return ($currentDay >= 27 and $currentDay <= 31) and ($day >= 1 and $day <= 4);
    }

    /**
     * @param $input
     * @param $request
     * @return bool
     */
    public static function isMinuteNotSet($input, $request): bool
    {
        return makeDoubleDigit(json_decode($request->$input, true)['minute']) == '00';
    }

    /**
     * @param $url
     * @return bool
     */
    public static function isParking($url): bool
    {
        return (strpos($url, "parking") !== false);
    }


    /**
     * @param $content
     * @return bool
     */
    public static function isFarsi($content): bool
    {
        $ld = new Language;

        // get the top first likely lingos
        $lingos = array_slice($ld->detect($content)->close(), 0, 5, true);


        if (array_key_exists("fa", $lingos)) return true;

        return false;
    }

    /**
     * @param $mode
     * @return bool
     */
    public static function isMode($mode): bool
    {
        return strpos($mode, 'mode') !== false;
    }

    /**
     * @param $theme
     * @return bool
     */
    public static function isTheme($theme): bool
    {
        return strpos($theme, 'theme') !== false;
    }

    /**
     * @return bool
     */
    public static function isTimeSkipped(): bool
    {
        return (json_decode(request()->to)->hour == 12 and json_decode(request()->to)->minute == 0)
            and (json_decode(request()->from)->hour == 12 and json_decode(request()->from)->minute == 0);
    }

    /**
     * @return bool
     */
    public static function isUserPanel(): bool
    {
        return basename(request()->path()) == 'main';
    }


    public static function isWeekend(string $dateString): bool
    {
        return Date::convertIntoCarbon($dateString)->dayOfWeek === 5;
    }


    public static function makeDate($input, $request)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',
            Date::convertIntoLatin(self::makeString($input, $request)) . ' ' . self::makeHour($input, $request)
        )->timestamp;
    }

    public static function makePreciseDate($input, $request, $isEndDate = false)
    {
        $dateString = self::makeString($input, $request);

        $carbonDate = Carbon::createFromFormat('Y-m-d', Date::convertIntoLatin($dateString), 'Asia/Tehran');

        ($isEndDate)
            ? $carbonDate->startOfDay()->subSecond()
            : $carbonDate->startOfDay();

        return $carbonDate->timestamp;
    }

    public static function makeString($input, $request)
    {
        if (!self::isCalenderSet($input, $request)) abort(500, 'Date was not properly selected or given; please try again :(');

        $date = json_decode($request->$input, true);
        return sprintf('%s-%s-%s', $date['year'], makeDoubleDigit($date['month']), makeDoubleDigit($date['date']));
    }

    /**
     * @param $input
     * @param $request
     * @return string
     */
    public static function makeDay($input, $request): string
    {
        return self::makeDoubleDigit(json_decode($request->$input, true)['date']);
    }


    /**
     * @param $input
     * @param $request
     * @return string
     */
    public static function makeMonth($input, $request): string
    {
        return self::makeDoubleDigit(json_decode($request->$input, true)['month']);
    }

    /**
     * @param $input
     * @param $request
     * @return int
     */
    public static function makeYear($input, $request): int
    {
        return json_decode($request->$input, true)['year'];
    }

    /**
     * @param $input
     * @param $request
     * @return string
     */
    public static function makeTime($input, $request): string
    {
        return json_decode($request->$input, true)['hour'];
    }

    /**
     * @param $day
     * @return string
     */
    public static function makeDoubleDigit($day): string
    {
        if (strlen((string)$day) == 1) {
            $day = '0' . $day;
        }
        return $day;
    }

    public static function makePreciseHour($input, $request, $isEndHour = false): string
    {
        if (self::isHourNotSet($input, $request) && self::isMinuteNotSet($input, $request)) {
            return $isEndHour ? '23:59:59' : '00:00:00';
        }

        $date = json_decode($request->$input, true);

        $hour = makeDoubleDigit($date['hour']);
        $minute = makeDoubleDigit($date['minute']);

        if ($isEndHour) {
            return sprintf('%s:%s:59', $hour, $minute);
        }

        return sprintf('%s:%s:00', $hour, $minute);
    }


    /**
     * @param $input
     * @param $request
     * @return string
     * prepare the format of hour for DB
     */
    public static function makeHour($input, $request): string
    {
        if (self::isHourNotSet($input, $request) && self::isMinuteNotSet($input, $request)) {
            return '00:00:00';
        }

        $date = json_decode($request->$input, true);
        return sprintf('%s:%s:00', makeDoubleDigit($date['hour']), makeDoubleDigit($date['minute']));
    }

    /**
     * @param $theme
     * @return string
     */
    public static function nameCookie($theme): string
    {
        return ((strpos($theme, 'mode') !== false) ? 'mode' : 'theme');
    }

    public static function showCurrentMonthDate($day)
    {
        $farsiMonth = self::isInitialDaysOfMonth($day)
            ? makeDoubleDigit(Date::getFarsiMonth() + 1)
            : makeDoubleDigit(Date::getFarsiMonth());


        $farsiDate = sprintf('%s-%s-%s', Date::getFarsiYear(), $farsiMonth, makeDoubleDigit($day));

        // Get start and end of day
        $startOfDay = Date::convertIntoLatinWithNoFormat($farsiDate)->startOfDay()->timestamp;
        $endOfDay = Date::convertIntoLatinWithNoFormat($farsiDate)->endOfDay()->timestamp;

        return compact('startOfDay', 'endOfDay');
    }


    public static function showOtherDashboard()
    {
        $type = request()->get('type');
        $dashboard = ['office' => 'parking', 'parking' => 'office'];

        return (array_key_exists($type, $dashboard))
            ? $dashboard[$type] : $dashboard['office'];
    }

    /**
     * @return string
     */
    public static function showDateDivider(): string
    {
        return '-';
    }

    /**
     * @param $reservation
     */
    public static function showPopUpDetails($reservation)
    {
        echo "<i class='fas fa-user-alt'></i> {$reservation->user->fullname} <hr> <i class='fas fa-clock'></i>"
            . "<span class='p-2'>" . convertTimeStamp($reservation->end_date) . "</span>";
    }


    public static function showOnlyNumber($spot)
    {
        $number = $spot['number'];
        return (preg_match('/[a-zA-Z]/i', $number)) ? substr($number, 0, -1) : $number;
    }

    /**
     * @param $type
     * @param $message
     */
    public static function showFlash($type, $message)
    {
        session()->flash($type, $message);
    }


    /**
     * @param $text
     * @param $number
     * @return string
     */
    public static function showInitialPersinaWords($text, $number)
    {
        return Str::limit($text, $number, '...');
    }

    /**
     * @param $rate
     */
    public static function showStarRating($rate)
    {
        return str_repeat("★", $rate) . str_repeat("☆", 5 - $rate);
    }
}
