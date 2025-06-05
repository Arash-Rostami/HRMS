<?php


namespace App\Services;


use App\Models\Desk;
use App\Models\Park;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;


class Dashboard
{

    protected static $model = [
        'parking' => Park::class,
        'office' => Desk::class,
    ];

    protected static $table = [
        'parking' => 'parks',
        'office' => 'desks',
    ];

    public static $total = [
        'parking' => 25,
        'office' => 86,
    ];


    /**
     * @return string
     */
    public static function getDashboardModel()
    {
        return self::$model[getDashboardType()];
    }

    /**
     * @return string
     */
    public static function getCurrentDashboardType(): string
    {
        return ltrim(strstr(url()->full(), '='), '=');
    }

    /**
     * @return string
     */
    public static function getDashboardType(): string
    {
        return ltrim(strstr(url()->previous(), '='), '=');
    }

    /**
     * @param $place
     * @return string
     */
    public static function getDescription($place): string
    {
        return match (self::getCurrentDashboardType()) {
            'office' => "Ext: {$place['extension']}<br>{$place['location']}",
            'parking' => "Floor: {$place['floor']}",
        };
    }

    /**
     * @param $place
     * @return string
     */
    public static function getImagePath($place): string
    {
        return match (self::getCurrentDashboardType()) {
            'office' => "/img/desk-seats/seat-{$place['number']}.jpg",
            'parking' => "/img/parking-spots/spot-" . showOnlyNumber($place) . ".jpg",
        };
    }

    /**
     * @param $img
     * @param $des
     * @return string
     */
    private static function formatResult($img, $des): string
    {
        return sprintf('<span title="click to view the map" data-lity data-lity-target="%s"
               @click="setTimeout(()=>showModal = false, 10)" class="cursor-pointer">  <i class="fa fa-eye"></i>
                   </span><br>%s', $img, $des);
    }

    /**
     * @param $date
     * @return mixed
     */
    public static function showClickedDay($date)
    {
        return Date::showRemainingDaysOfWeek($date)[0];
    }

    /**
     * @param $place
     * @return string
     */
    public static function showExtension($place): string
    {
        return self::formatResult(self::getImagePath($place), self::getDescription($place));
    }

    /**
     * @param $date
     * @return int
     */
    public static function showRemaining($reservations)
    {
        return self::$total[getDashboardType()] - self::showReserved($reservations);
    }

    /**
     * @param $date
     * @return mixed
     */
    public static function showReserved($reservations)
    {
        $cacheKey = 'show_reserved_' . getDashboardType();

        return Cache::remember($cacheKey, now()->addSeconds(2), function () use ($reservations) {
            return $reservations->unique('number')->count();
        });
    }

    /**
     * @return string
     */
    public static function showQuotaMessage(): string
    {
        $quota = Park::showMonthlyQouta();

        if ($quota == 0) {
            return 'MAX';
        }

        if ($quota == auth()->user()->maximum) {
            return 'N/A';
        }

        return $quota;
    }

    /**
     * @param $number
     * @return int
     */
    public static function showRemainingReservations($number)
    {
        return Dashboard::showRemaining($number);
    }

    /**
     * @return int
     */
    public static function showTotalAvailableReservations()
    {
        return Dashboard::$total[getDashboardType()];
    }

    /**
     * @param $number
     * @return mixed
     */
    public static function showTotalReservations($number)
    {
        return Dashboard::showReserved($number);
    }

}
