<?php

namespace App\Services;

use App\Models\Cancellation;

class Statistics
{

    public static function countdaily($model, $id, $cancellation = false)
    {
        $table = ($cancellation === true)
            ? self::getCancellations($model, $id)
            : self::getBookings($model, $id);

        return $table->whereRaw('end_date - start_date <= 86400')
            ->count();
    }


    public static function countLong($model, $id, $cancellation = false)
    {
        $total = [];
        $long = ($cancellation === true)
            ? self::getCancellations($model, $id)->whereRaw('end_date - start_date > 86400')
            : self::getBookings($model, $id)->whereRaw('end_date - start_date > 86400');

        // yield 0 when no reservation made
        if ($long->count() < 1) return 0;


        // count number of days of reservation
        if ($long->count() == 1) {
            foreach ($long->get() as $each) {
                $total = ($each->end_date - $each->start_date) / 86400;
            }
            return round($total);
        }

        // count number of days of reservation when multiple is made
        if ($long->count() > 1) {
            foreach ($long->get() as $each) {
                $total[] = ($each->end_date - $each->start_date) / 86400;
            }
            return round(array_sum($total));
        }
    }

    public static function countReservations($model, $id)
    {
        $totalReservations = self::countLong($model, $id) + self::countdaily($model, $id);
        $totalCancellations = self::countLong($model, $id, true);
        return $totalReservations - $totalCancellations;
    }


    public static function getBookings($model, $id)
    {
        return $model::where('state', 'active')
            ->isNotCancelled()
            ->where('user_id', $id)
            ->whereBetween('start_date', [Date::getStartOfPersianYear(), Date::getStartOfPersianYear(1)])
            ->whereBetween('end_date', [Date::getStartOfPersianYear(), Date::getStartOfPersianYear(1)]);
    }


    public static function getCancellations($model, $id)
    {
        $booking = [
            'App\Models\Park' => 'parking',
            'App\Models\Desk' => 'office'
        ][$model];

        return Cancellation::where('booking', $booking)->where('user_id', (int)$id);
    }
}
