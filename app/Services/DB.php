<?php


namespace App\Services;


use App\Models\Park;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB as Laravel;

class DB
{
    protected $table;
    protected $user;

    /**
     * DB constructor.
     * @param $table
     * @param $user
     */
    public function __construct($table, $user)
    {
        $this->table = $table;
        $this->user = $user;
    }

    public static function showDailyReport($table, $day)
    {
        $isTablePark = $table == Park::class;


        $query = $table::with(['user.profile', $isTablePark ? 'spot' : 'seat'])
            ->whereRaw('start_date < ? AND end_date > ?', [$day, $day])
            ->isNotCancelled()
            ->isNotDeactivated()
            ->orderBy($isTablePark ? 'spot_id' : 'seat_id')
            ->orderByDesc('end_date')
            ->take(100)
            ->get();

        return $query->transform(function ($reservation) use ($table, $isTablePark) {
            $spot = $reservation->{$isTablePark ? 'spot' : 'seat'};

            $reservation->start = $reservation->getStart();
            $reservation->end = $reservation->getEnd();
            $reservation->spot = $spot->number;
            $reservation->reserver = $reservation->user->fullName;
            $reservation->floor = $spot->{$table == Park::class ? 'floor' : 'location'};
            /*if it is Park*/
            $reservation->card = $isTablePark ? $spot->card : null;
            $reservation->plate = !is_null(optional($reservation->user->profile)->license_plate)
                ? optional($reservation->user->profile)->license_plate
                : removeHTMLTags($reservation->user->details) ?? null;
            /*if it is Desk*/
            $reservation->extension = !$isTablePark ? $spot->extension : null;
            $reservation->cell = optional($reservation->user->profile)->cellphone ?? null;

            return $reservation;
        });
    }

    public static function showMyTakenArea($reservations)
    {
        return $reservations->filter(function ($reservation) {
            return $reservation->user_id == auth()->user()->id;
        });
    }

    public static function showTakenArea($query, $param, $table)
    {
        return self::showDatesInBetween($query, $param, $table)
            ->filter(function ($reservation) {
                return $reservation->user_id == auth()->user()->id;
            });
    }

    public static function showDatesInBetween($query, $param, $table)
    {
        $cacheKey = 'reservations_in_between_' . $table . '_' . $param . '_' . auth()->user()->id;
        $queryDate = Utility::showCurrentMonthDate($param);
        $startOfDay = $queryDate['startOfDay'];
        $endOfDay = $queryDate['endOfDay'];
        $dashboardType = getDashboardType();

        return Cache::remember($cacheKey, now()->addSeconds(3), function () use ($table, $dashboardType, $startOfDay, $endOfDay) {

            $sql = "
                SELECT t.*
                FROM {$table} AS t
                WHERE t.soft_delete = 'false'
                  AND t.state = 'active'
                  AND t.start_date <= ?
                  AND t.end_date >= ?
                  AND NOT EXISTS (
                      SELECT 1
                      FROM cancellations AS c
                      WHERE c.number = t.number
                        AND c.user_id = t.user_id
                        AND c.soft_delete = 'false'
                        AND c.booking = ?
                        AND (
                            c.start_date BETWEEN ? AND ?
                            OR c.end_date BETWEEN ? AND ?
                            OR (c.start_date <= ? AND c.end_date >= ?)
                        )
                  )";

            $bindings = [
                $endOfDay, $startOfDay, // For t.start_date and t.end_date conditions
                $dashboardType,         // For c.booking
                $startOfDay, $endOfDay, // For c.start_date BETWEEN
                $startOfDay, $endOfDay, // For c.end_date BETWEEN
                $startOfDay, $endOfDay  // For c.start_date <= and c.end_date >=
            ];

            $results = Laravel::select($sql, $bindings);
            return collect($results);
        });
    }

    public function checkAnyConflict()
    {
        if ($this->checkCancellationConflict() == 1) {
            return 0;
        } else {
            return ($this->checkReservationConflict()->get()->filter(function ($users) {
                return $users->num == request()->number;
            })->count());
        }
    }

    public function checkCancellationConflict()
    {
        return self::checkReservationConflict()
//            ->whereExists(function ($query) {
            ->where(function ($query) {
                $query
                    ->where('cancellations.number', request()->number)
                    ->where('cancellations.start_date', '<=', Utility::makePreciseDate('from', request()))
                    ->where('cancellations.end_date', '>=', Utility::makePreciseDate('from', request()))
                    ->where('cancellations.start_date', '<=', Utility::makePreciseDate('to', request(), true))
                    ->where('cancellations.end_date', '>=', Utility::makePreciseDate('to', request(), true));
            })->count();
    }

    public function checkReservationConflict()
    {
        $startDate = Utility::makePreciseDate('from', request());
        $endDate = Utility::makePreciseDate('to', request(), true);


        return Laravel::table($this->table)
            ->leftJoin('cancellations', function ($join) {
                $join->on($this->table . '.user_id', '=', 'cancellations.user_id')
                    ->on($this->table . '.number', '=', 'cancellations.number')
                    ->whereRaw('cancellations.start_date <= ' . $this->table . '.end_date')
                    ->whereRaw('cancellations.end_date >= ' . $this->table . '.start_date');
            })
            ->select([
                $this->table . '.*',
                'cancellations.start_date AS cancellation_start',
                $this->table . '.number AS num',
                'cancellations.end_date AS cancellation_end',
                'cancellations.booking', 'cancellations.number'
            ])
            ->whereNull('cancellations.number')
            ->where($this->table . '.soft_delete', '=', 'false')
            ->where($this->table . '.state', '=', 'active')
            ->where(function ($query) use ($startDate, $endDate) {
                // to check if it sits within the time frame
                $query->whereRaw($this->table . '.start_date <= ? AND ' . $this->table . '.end_date >= ?', [
                    $startDate, $endDate
                ])
                    // to check if some part of it starts or ends before or after the time frame
                    ->orWhereRaw('
                    CASE WHEN ' . $this->table . '.start_date >= ? THEN ' . $this->table . '.start_date < ?
                    WHEN ' . $this->table . '.end_date <= ? THEN ' . $this->table . '.end_date > ? END', [
                        $startDate, $endDate, $endDate, $startDate
                    ]);
            });
    }

    public function checkUserConflict()
    {
        return $this->checkReservationConflict()->get()->filter(function ($users) {
            return $users->user_id == $this->user->id;
        })->count();
    }
}
