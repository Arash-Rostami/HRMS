<?php


namespace App\Services;


use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use phpDocumentor\Reflection\Types\False_;

class Date
{
    static $latinDate;
    static $farsiDate;

    public function __construct()
    {
        self::$latinDate = date('Y-m-d');
        self::$farsiDate = Jalalian::now();
    }

    /**
     * @param $latinDate
     * @return string
     */
    public static function convertIntoFarsi($latinDate): string
    {
        return Jalalian::fromCarbon($latinDate);
    }

    /**
     * @param $latinDate
     * @return string
     */
    public static function convertToFarsiWithoutTime($latinDate): string
    {
        return Jalalian::fromCarbon(Carbon::parse($latinDate))->format('Y-m-d');
    }

    /**
     * @param $timestamp
     * @param $year
     * @return string
     */
    public static function convertTimestampIntoFarsi($timestamp, $year = false): string
    {
        return Jalalian::fromDateTime($timestamp)->format($year ? 'Y-m-d' : 'm-d');
    }

    public static function convertTimestampToFarsi($timestamp): array
    {
        $jalaliDate = \Morilog\Jalali\Jalalian::forge($timestamp);

        return [
            'year' => $jalaliDate->getYear(),
            'month' => $jalaliDate->getMonth(),
            'day' => $jalaliDate->getDay(),
        ];
    }

    /**
     * @param string $date
     * @return Carbon
     */
    public static function convertIntoCarbon(string $date): \Carbon\Carbon
    {
        return Jalalian::fromFormat('Y-m-d', $date)->toCarbon();
    }

    /**
     * @param $farsiDate
     * @return string
     */
    public static function convertIntoLatin($farsiDate): string
    {
        return \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d', $farsiDate)
            ->format('Y-m-d');
    }

    public static function convertIntoLatinWithNoFormat($farsiDate)
    {
        return \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d', $farsiDate);
    }

    /**
     * @param $farsiDate
     * @return string
     */
    public static function convertIntoLatinWithHour($farsiDate)
    {
        return \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $farsiDate);
    }

    /**
     * @param $unix
     * @return Jalalian
     */
    public static function convertFromUnix($unix)
    {
        return Jalalian::forge($unix);
    }

    public static function convertTheClickedDayIntoDay($day)
    {
        return $day;
    }

    /**
     * @param $day
     * @return string
     */
    public static function convertTheClickedDayIntoLatin($day): string
    {
        return CalendarUtils::createCarbonFromFormat('Y-m-d',
            self::convertTheClickedDayIntoFarsi($day)
        )->format('Y-m-d');
    }

    /**
     * @param $day
     * @return string
     */
    public static function convertTheClickedDayIntoFarsi($day): string
    {
        return self::getFarsiYear() . showDateDivider()
            . makeDoubleDigit(self::getFarsiMonth())
            . showDateDivider() . $day;
    }

    /**
     * @return int
     */
    public static function getFarsiYear(): int
    {
        return Jalalian::now()->getYear();
    }

    /**
     * @return int
     */
    public static function getFarsiMonth(): int
    {
        return makeDoubleDigit(Jalalian::now()->getMonth());
    }

    public static function convertTimeStamp($time): Jalalian
    {
        return Jalalian::forge($time);
    }

    public static function getEndOfMonth(): string
    {
        return implode('-',
                CalendarUtils::toGregorian(Date::getFarsiYear(), Date::getFarsiMonth(), Date::getLastDayOfMonth())) . " 23:59:59";
    }

    public static function getLastDayOfMonth(): int
    {
        return (new Jalalian(Date::getFarsiYear(), Date::getFarsiMonth(), 1))->getMonthDays();
    }

    /**
     * @return int
     */
    public static function getFarsiDay(): int
    {
        return makeDoubleDigit(Jalalian::now()->getDay());
    }

    /**
     * @return int
     */
    public static function getFarsiTime(): int
    {
        return makeDoubleDigit(Jalalian::now()->getTimestamp());
    }

    public static function getStartOfMonth(): string
    {
        return implode('-',
                CalendarUtils::toGregorian(self::getFarsiYear(), self::getFarsiMonth(), 1)) . " 00:00:00";
    }

    public static function getStartOfPersianMonth($next = 0)
    {
        $month = self::getFarsiMonth() + $next;
        $date = (new Jalalian(
            ($month == 13) ? (self::getFarsiYear() + 1) : (self::getFarsiYear()),
            ($month == 13) ? (01) : $month,
            01))->toArray();
        return $date['timestamp'];
    }

    public static function getStartOfPersianYear($next = 0)
    {
        $date = (new Jalalian((self::getFarsiYear() + $next), 01, 01))->toArray();
        return $date['timestamp'];
    }

    public static function listWeekDays(): array
    {
        $week = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        $length = count(array_slice($week, array_search(date('l'), $week)));
        $extras = [];
        $i = 0;

        while ($i < (3 - $length)) {
            $extras[] = $week[$i];
            $i++;
        }
        // merge end days of week with starting days of week
        return ($length > 3)
            ?
            array_slice($week, array_search(date('l'), $week), 4)
            :
            array_merge(array_slice($week, array_search(date('l'), $week)), $extras);
    }

    /**
     * @param $day
     * @return string
     */
    public static function shortenDaysName($day): string
    {
        return strtoupper(substr($day, 0, 3));
    }

    /**
     * @param $date
     * @return array
     */
    public static function showRemainingDaysOfWeek($date): array
    {
        $i = 1;
        $remaining = [];
        // to show the remaining days if the given day is Sat
        list($remaining, $date) = self::displayFromSaturday($date, $remaining);
        // to show the remaining days if the given day is after Sat
        return self::displayAfterSaturday($date, $remaining, $i);
    }

    /**
     * @param $date
     * @param array $remaining
     * @return array
     */
    public static function displayFromSaturday($date, array $remaining): array
    {
        if (self::showNumberOfDayInWeek($date) == 6) {
            $remaining[] = self::makeDate(self::convertIntoUnix($date));
            $date = self::addOneToDay(self::convertIntoUnix($date));
        }
        return array($remaining, $date);
    }

    /**
     * @param $date
     * @return false|string
     */
    public static function showNumberOfDayInWeek($date)
    {
        return date('w', strtotime($date));
    }

    /**
     * @param $currentUnix
     * @return false|string
     */
    public static function makeDate($currentUnix)
    {
        return date('Y-m-d', $currentUnix);
    }

    /**
     * @param $dateFormat
     * @return false|int
     */
    public static function convertIntoUnix($dateFormat)
    {
        return strtotime($dateFormat);

    }

    /**
     * @param $currentUnix
     * @return false|string
     */
    public static function addOneToDay($currentUnix)
    {
        return date('Y-m-d', ($currentUnix + (86400)));
    }

    /**
     * @param bool $date
     * @param array $remaining
     * @param int $i
     * @return array
     */
    public static function displayAfterSaturday(bool $date, array $remaining, int $i): array
    {
        while (self::showNumberOfDayInWeek($date) < 6) {
            $remaining[] = self::makeDate(self::convertIntoUnix($date));
            $date = self::addOneToDay(self::convertIntoUnix($date));
            $i++;
        }
        return $remaining;
    }

    public static function toJalali($date, $format): string
    {
        $dt = match (true) {
            $date instanceof \DateTimeInterface => Carbon::instance($date),
            is_numeric($date) => Carbon::createFromTimestamp($date),
            default => Carbon::parse($date),
        };

        return Jalalian::fromDateTime($dt)->format($format);
    }
}
