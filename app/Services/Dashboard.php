<?php


namespace App\Services;


use App\Models\Desk;
use App\Models\Park;
use Illuminate\Support\Facades\Cache;


class Dashboard
{

    public static $total = [
        'parking' => 25,
        'office' => 86,
    ];
    protected static $model = [
        'parking' => Park::class,
        'office' => Desk::class,
    ];
    protected static $table = [
        'parking' => 'parks',
        'office' => 'desks',
    ];

    /**
     * @return string
     */
    public static function getCurrentDashboardType(): string
    {
        $type = ltrim(strstr(url()->full(), '='), '=');
        return $type ?: 'parking';
    }

    /**
     * @return string
     */
    public static function getDashboardModel()
    {
        $type = self::getDashboardType();
        return self::$model[$type] ?? self::$model['parking'];
    }

    /**
     * @return string
     */
    public static function getDashboardType(): string
    {
        $type = ltrim(strstr(url()->previous(), '='), '=');
        return $type ?: 'parking';
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
     * @return string
     */
    public static function showQuotaMessage(): string
    {
        $quota = Park::showMonthlyQouta();

        if ($quota <= 0) {
            return 'MAX';
        }

        return (string)$quota;
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
     * @param $number
     * @return int
     */
    public static function showRemainingReservations($number)
    {
        return Dashboard::showRemaining($number);
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
}
