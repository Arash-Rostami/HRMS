<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class Search
{
    protected static $mainTable = [
        'parking' => 'parks',
        'office' => 'desks'
    ];
    protected static $sideTable = [
        'parking' => 'spots',
        'office' => 'seats'
    ];

    protected static $column = [
        'parking' => '.spot_id',
        'office' => '.seat_id'
    ];

    protected static function getColumn(): string
    {
        return self::$column[getDashboardType()];
    }

    protected static function getMainTable(): string
    {
        return self::$mainTable[getDashboardType()];
    }

    protected static function getSideTable(): string
    {
        return self::$sideTable[getDashboardType()];
    }

    /**
     * @return \Illuminate\Support\Collection|string
     */
    public static function findByKeyword()
    {

        if (request()->input('key') == '') return 'Nothing searched!';
        if (request()->input('day') == '') return 'No day given!';


        $reservation = self::queryKeyword();

        if ($reservation->isEmpty()) return 'No user on this day!';

        return $reservation;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected static function queryKeyword(): \Illuminate\Support\Collection
    {
        return DB::table(self::getMainTable())
            //get users table
            ->join('users', self::getMainTable() . '.user_id', '=', 'users.id')
            // joins either DESKS or PARKS based on dashboard
            ->join(self::getSideTable(), self::getMainTable() . self::getColumn(),
                '=', self::getSideTable() . '.id')
            // select 4 columns only
            ->select('users.forename', 'users.surname', 'users.email', self::getMainTable() . self::getColumn(),
                self::getSideTable() . '.*')
            // query non-cancelled or non-deactivated ones only
            ->where('soft_delete', '=', 'false')
            ->where('state', '=', 'active')
            // query search date
            ->where(function ($query) {
                $query->where(self::getMainTable() . '.start_date', '<=',
                    Date::convertIntoUnix(convertTheClickedDayIntoLatin(makeDoubleDigit(request()->input('day')))))
                    ->where(self::getMainTable() . '.end_date', '>',
                        Date::convertIntoUnix(convertTheClickedDayIntoLatin(makeDoubleDigit(request()->input('day')))));
            })
            // query search keyword
            ->where(function ($query) {
                if (request()->input('key') != '*') {
                    $query->where('users.forename', 'LIKE', '%' . request()->input('key') . '%')
                        ->orWhere('users.surname', 'LIKE', '%' . request()->input('key') . '%')
                        // query search keyword for number
                        ->orWhere(self::getSideTable() . '.number', 'LIKE', '%' . request()->input('key') . '%');
                }
            })
            ->orderBy('users.surname')
            ->get();
    }
}
