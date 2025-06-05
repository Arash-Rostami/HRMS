<?php

namespace App\Models;

use App\Services\CancellationList;
use App\Services\Date;
use App\Services\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as Laravel;

class Desk extends Model
{
    use HasFactory;


    protected $fillable = [
        'number', 'start_date', 'start_hour', 'end_date',
        'end_hour', 'state', 'soft_delete', 'user_id', 'seat_id'
    ];

    public static function countAll(): int
    {
        return self::all()->count();
    }

    public static function countActive($filter = null)
    {
        $query = self::where('state', 'active');

        self::filterResult($filter, $query);

        return $query->count();
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

    public static function countUsers($type): int
    {
        return self::where('state', 'active')
            ->isNotCancelled()
            ->join('users', 'desks.user_id', '=', 'users.id')
            ->where('type', $type)
            ->count();
    }

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

    public function getStart()
    {
        return Date::convertTimestampIntoFarsi($this->attributes['start_date']);
    }


    public function isReservedByOthers($user)
    {
        $DB = new DB('desks', $user);

        return $DB->checkAnyConflict();
    }

    public function isReservedByUser($user)
    {
        $DB = new DB('desks', $user);

        return $DB->checkUserConflict();
    }

    public function scopeBetweenStartAndEndDate($query, $param)
    {
        return DB::showDatesInBetween($query, $param, 'desks');
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
        return DB::showTakenArea($query, $param, 'desks') ?? null;
    }

    public function showCurrentDeskNumbers($user): mixed
    {
        return $this->isNotCancelled()
            ->isNotDeactivated()
            ->where('end_date', '>=', Carbon::now()->timestamp)
            ->where('desks.user_id', '=', $user)
            ->join('seats', 'desks.seat_id', '=', 'seats.id')
            ->select('seats.*')
            ->pluck('number', 'id');
    }

    public function showCurrentDeskUsers()
    {
        $users = $this
            ->isNotCancelled()
            ->isNotDeactivated()
            ->where('end_date', '>=', Carbon::now()->timestamp)
            ->join('users', 'desks.user_id', '=', 'users.id')
            ->select("users.id", "desks.number", "desks.start_date", "desks.end_date",
                Laravel::raw("CONCAT(users.surname,', ',users.forename) AS fullName"))
            ->orderBy('desks.created_at')
            ->get()
            ->toArray();

        return (new CancellationList($users))->listUsers();
    }

    public function seat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
