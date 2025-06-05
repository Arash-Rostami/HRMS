<?php

namespace App\Models;

use App\Services\CancellationList;
use App\Services\Date;
use App\Services\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as Laravel;


class Park extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'number', 'start_date', 'start_hour', 'end_date',
        'end_hour', 'state', 'soft_delete', 'user_id', 'spot_id'
    ];

    private static function filterResult(mixed $filter, $query): void
    {
        match ($filter) {
            null => true,
            'today' => $query->whereDate('created_at', today()),
            'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereBetween('created_at', [Date::getStartOfMonth(), Date::getEndOfMonth()]),
            'year' => $query->whereBetween('created_at', [
                Date::makeDate(Date::getStartOfPersianYear()),
                Date::makeDate(Date::getStartOfPersianYear(1) - 1)
            ]),
            default => false,
        };
    }

    public function getEnd()
    {
        return Date::convertTimestampIntoFarsi($this->attributes['end_date']);
    }

    private static function getMonthlyUsage()
    {
        return self::where('user_id', '=', auth()->user()->id)
            ->where('soft_delete', 'false')
            ->whereBetween('created_at', [Date::getStartOfMonth(), Date::getEndOfMonth()])
            ->count();
    }

    public function getStart()
    {
        return Date::convertTimestampIntoFarsi($this->attributes['start_date']);
    }

    public function isReservedByOthers($user)
    {
        $DB = new DB('parks', $user);

        return $DB->checkAnyConflict();
    }

    public function isReservedByUser($user)
    {
        $DB = new DB('parks', $user);

        return $DB->checkUserConflict();
    }

    public function scopeBetweenStartAndEndDate($query, $param)
    {
        return DB::showDatesInBetween($query, $param, 'parks');
    }

    public function scopeCheckDate($query, $from, $to)
    {
        return $query->whereRaw('start_date <= ? AND end_date >= ?', [$from, $to])
            // to check if some part of it starts or ends before or after the time frame
            ->orWhereRaw('
                    CASE WHEN start_date >= ? THEN start_date < ?
                    WHEN end_date <= ? THEN end_date > ? END',
                [$from, $to, $to, $from]
            );
    }


    public function scopeIsCancelled($query)
    {
        return $query->where('soft_delete', 'true');
    }


    public function scopeIsDeactivated($query)
    {
        return $query->where('state', 'inactive');
    }

    public function scopeIsNotCancelled($query)
    {
        return $query->where('soft_delete', 'false');
    }

    public function scopeIsNotDeactivated($query)
    {
        return $query->where('state', 'active');
    }

    public function scopeShowMyArea($query, $param)
    {
        return DB::showTakenArea($query, $param, 'parks') ?? null;
    }

    public function showCurrentParkNumbers($user): mixed
    {
        return $this->isNotCancelled()
            ->isNotDeactivated()
            ->where('end_date', '>=', Carbon::now()->timestamp)
            ->where('parks.user_id', '=', $user)
            ->join('spots', 'parks.spot_id', '=', 'spots.id')
            ->select('spots.*')
            ->pluck('number', 'id');
    }

    public function showCurrentParkUsers(): mixed
    {
        $users = $this->isNotCancelled()
            ->isNotDeactivated()
            ->where('end_date', '>=', Carbon::now()->timestamp)
            ->join('users', 'parks.user_id', '=', 'users.id')
            ->select("users.id", "parks.number", "parks.start_date", "parks.end_date",
                Laravel::raw("CONCAT(users.surname,', ',users.forename) AS fullName"))
            ->orderBy('parks.created_at')
            ->get()
            ->toArray();

        return (new CancellationList($users))->listUsers();
    }

    public function spot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*static methods*/
    public static function countActive($filter = null)
    {
        $query = self::where('state', 'active');

        self::filterResult($filter, $query);

        return $query->count();
    }

    public static function countAll(): int
    {
        return self::all()->count();
    }

    public static function countDeleted($filter = null)
    {
        $query = self::where('soft_delete', 'true');

        self::filterResult($filter, $query);

        return $query->count();
    }

    public static function countInactive($filter = null)
    {
        $query = self::where('state', 'inactive');

        self::filterResult($filter, $query);

        return $query->count();
    }

    public static function countLimit($id)
    {
        return self::where('state', 'active')
            ->isNotCancelled()
            ->where('user_id', $id)
            ->whereBetween('start_date', [Date::getStartOfPersianMonth(), Date::getStartOfPersianMonth(1)])
            ->whereBetween('end_date', [Date::getStartOfPersianMonth(), Date::getStartOfPersianMonth(1)])
            ->count();
    }

    public static function countUserCancellation($user)
    {
        // Check if the user has canceled reservations more than two times in the past 30 days
        $canceledCount = Park::where('user_id', $user->id)
            ->where('soft_delete', true)
            ->whereDate('created_at', '>', Carbon::now()->subDays(30)) // Check past 30 days
            ->count();

        return $canceledCount > 2; // Allow reservation if canceled count is 2 or less
    }

    public static function countUsers($type): int
    {
        return self::where('state', 'active')
            ->isNotCancelled()
            ->join('users', 'parks.user_id', '=', 'users.id')
            ->where('type', $type)
            ->count();

    }

    public static function showMonthlyQouta()
    {
        return auth()->user()->maximum - self::getMonthlyUsage();
    }
}

