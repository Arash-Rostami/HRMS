<?php


namespace App\Services;


use App\Models\Desk;
use App\Models\Park;
use App\Models\Seat;
use App\Models\Spot;
use Illuminate\Support\Facades\Cache;

class Reservation
{

    public static function canReserveSeat($user): bool
    {
        return $user->booking == 'all' or $user->booking == 'office';
    }


    public static function canReserveSpot($user): bool
    {
        return $user->booking == 'all' or $user->booking == 'parking';
    }


    public static function countDaysOfReservation(): int
    {
        $matchingUser = session('user')->first(function ($user) {
            return self::listAllNumbers(url()->full())->contains('id', $user->number);
        });

        if ($matchingUser) {
            $totalSeconds = $matchingUser->end_date - $matchingUser->start_date;
            $days = floor($totalSeconds / 86400);

            if ($totalSeconds % 86400 > 0) {
                $days += 1;
            }
            return (int)$days;
        }

        return 0;
    }


    public static function confirmDesk($desk): bool
    {
        return session()->has('day') && self::isSeatReserved($desk);
    }


    public static function confirmParking($space): bool
    {
        return isNotInCenter($space) && session()->has('day') && self::isSpotReserved($space);
    }

//    /**
//     * @param $space
//     * @param $column
//     * @return array
//     */
//    public static function filterReserves($space, $column): array
//    {
//        $reservedIds = array_flip(array_column(session('area')->toArray(), $column));
//
//        // Filter only those not in reserved IDs
//        return $space->all()->filter(function ($value) use ($reservedIds) {
//            return !isset($reservedIds[$value->id]);
//        })->all();
//    }


    public static function getReservationId()
    {
        foreach (session('user') as $data) {
            return $data->id;
        }
    }


    public static function getReservationNumber()
    {
        $reservations = self::listAllNumbers(url()->full());

        $userNumbers = session('user')->pluck('number')->flip();

        return $reservations->first(function ($reservation) use ($userNumbers) {
            return isset($userNumbers[$reservation->id]);
        })->number ?? null;
    }


    /**
     * @return bool
     */
    public static function hasUserReserved(): bool
    {
        return session()->has('user') && count(session('user')) != 0;
    }

    /**
     * @param $user
     * @return bool
     */
    public static function hasUserMaxed($user, $park): bool
    {
        // ignore limit on that specific day
        if (now()->timestamp > $park->start_date && now()->timestamp < $park->end_date) {
            return false;
        }

        // allow to register for the next month
        $day = Date::getFarsiDay();
        if ($day == 30 or $day == 31) return false;

        return (Park::countLimit($user->id) >= $user->maximum);
    }


    public static function isSeatReserved($seat): bool
    {
        if (!session()->has('area')) {
            return false;
        }
        $reservedDeskIds = session('area')->pluck('id')->flip();

        return $seat->desks->pluck('id')->intersect($reservedDeskIds->keys())->isNotEmpty();
    }

    public static function isSpotReserved($spot)
    {
        if (!session()->has('area')) {
            return false;
        }

        $reservedSpotIds = session('area')->pluck('id')->flip();

        return $spot->parks->pluck('id')->intersect($reservedSpotIds->keys())->isNotEmpty();
    }


    public static function listAllNumbers($url)
    {
        return Cache::remember('list_all_numbers_' . md5($url), 20, function () use ($url) {
            return (strpos($url, "parking") !== false) ? Spot::all() : Seat::all();
        });
    }


    public static function listUntakenNumbers($url)
    {
        return (str_contains($url, "parking")) ? self::showUntakenSpots() : self::showUntakenSeats();
    }


    public static function showMyArea($reservations)
    {
        return DB::showMyTakenArea($reservations);
    }


    public static function showReserveArea($number)
    {
        $modelClass = getDashboardType() == 'parking' ? Park::class : Desk::class;

        return $modelClass::betweenStartAndEndDate($number);
    }


    public static function showDetails($space)
    {
        $reservations = isParking() ? $space->parks : $space->desks;

        $reservedIds = session('area')->pluck('id')->flip();

        $matchingReservation = $reservations->first(function ($reservation) use ($reservedIds) {
            return isset($reservedIds[$reservation->id]);
        });

        if ($matchingReservation) {
            Utility::showPopUpDetails($matchingReservation);
        }
    }

    public static function showUntakenSeats()
    {
        return self::getUntakenEntities(Seat::class, 'seat_id');
    }

    public static function showUntakenSpots()
    {
        return self::getUntakenEntities(Spot::class, 'spot_id');
    }

    private static function getUntakenEntities($model, $sessionColumn)
    {
        if (session()->has('area')) {
            $reservedIds = array_column(session('area')->toArray(), $sessionColumn);
            return $model::whereNotIn('id', $reservedIds)->get();
        }

        return $model::all();
    }
}
