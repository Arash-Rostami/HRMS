<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;


    const PRESENCE_ONSITE = 'onsite';
    const PRESENCE_OFFSITE = 'off-site';
    const PRESENCE_ONLEAVE = 'on-leave';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'forename', 'surname', 'open_password', 'password', 'maximum', 'email', 'type',
        'role', 'status', 'booking', 'details', 'presence', 'last_seen'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'open_password',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen' => 'datetime',
    ];

    public function canAccessFilament(): bool
    {
        return ($this->role == 'admin') or ($this->role == 'developer') or $this->hasVerifiedEmail();
    }

    public function desks()
    {
        return $this->hasMany(Desk::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function suggestions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Suggestion::class);
    }


    /**
     * @param $name
     * @return mixed
     */
    public static function findByKeyword($name): mixed
    {
        return self::where('forename', 'LIKE', '%' . $name . '%')
            ->orWhere('surname', 'LIKE', '%' . $name . '%')->get();
    }

    public function getFilamentName(): string
    {
        return "{$this->forename}";
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile && $this->profile->image
            ? public_path($this->profile->image)
            : '';
    }

//    public function getLastSeenAttribute($value)
//    {
//        return Carbon::parse($value);
//    }

    /**
     * @param $user
     * @return bool
     */
    public static function isUserActive($user): bool
    {
        return $user->status == 'active';
    }

    public function parks()
    {
        return $this->hasMany(Park::class);
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    /**
     * @return int
     */
    public static function countOnSite(): int
    {
        return self::where('presence', self::PRESENCE_ONSITE)
            ->where('status', 'active')->count();
    }

    /**
     * @return int
     */
    public static function countOffSite(): int
    {
        return self::where('presence', self::PRESENCE_OFFSITE)
            ->where('status', 'active')->count();
    }

    /**
     * @return int
     */
    public static function countOnLeave(): int
    {
        return self::where('presence', self::PRESENCE_ONLEAVE)
            ->where('status', 'active')->count();
    }


    /**
     * @return int
     */
    public static function countAll(): int
    {
        return self::all()->count();
    }

    /**
     * @return int
     */
    public static function countActive(): int
    {
        return self::where('status', 'active')->count();
    }

    /**
     * @return int
     */
    public static function countInactive(): int
    {
        return self::where('status', 'inactive')->count();
    }

    /**
     * @return int
     */
    public static function countSuspended(): int
    {
        return self::where('status', 'suspended')->count();
    }

    /**
     * @param $var
     * @return int
     */
    public static function countType($var): int
    {
        return self::where('type', "$var")->count();
    }

    /**
     * @return bool
     */
    public function hasOffice(): bool
    {
        return $this->booking == 'office' || $this->booking == 'all';
    }

    /**
     * @return bool
     */
    public function hasParking(): bool
    {
        return $this->booking == 'parking' || $this->booking == 'all';
    }

    /**
     * @return int
     */
    public static function wantParking(): int
    {
        return self::where('booking', 'all')
            ->orWhere('booking', 'parking')
            ->where('status', 'active')
            ->count();
    }

    /**
     * @return int
     */
    public static function wantOffice(): int
    {
        return self::whereIn('booking', ['all', 'office'])
            ->where('status', 'active')
            ->count();
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('forename', 'like', '%' . $search . '%')
                ->orWhere('surname', 'like', '%' . $search . '%');
        });
    }

    public static function showInMonth()
    {
        $now = Carbon::now();
        $currentGregorianYear = $now->year;
        $iranianYear = $now->month < 3 || ($now->month == 3 && $now->day < 21)
            ? $currentGregorianYear - 1
            : $currentGregorianYear;

        $startOfYear = Carbon::create($iranianYear - 1, 3, 21, 0, 0, 0);
        $endOfYear = Carbon::create($iranianYear, 3, 20, 23, 59, 59);


        return self::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');
    }

    public static function showHR()
    {
        return self::with('profile')
            ->where('status', 'active')
            ->where('forename', 'not like', '%Guest%')
            ->where('surname', 'not like', '%Guest%')
//            ->where('surname', 'Rostami') // should be commented out for development
            ->whereHas('profile', function ($query) {
                $query->where('department', 'HR');
            })
            ->get();
    }


    public function getTodaysDeskExtension()
    {
        $todaysDesk = $this->desks()
            ->where('start_date', '<=', now()->timestamp)
            ->where('end_date', '>=', now()->timestamp)
            ->where('state', 'active')
            ->latest()
            ->first();

        return ($todaysDesk)
            ? $todaysDesk->seat->extension
            : (($this->profile) ? tel($this->profile->cellphone) : 'N/A');
    }


    public function getFullNameAttribute($value)
    {
        return "{$this->forename} {$this->surname}";
    }

    public function getInitialsAttribute($value)
    {
        return $this->forename . ' ' . initializeString($this->surname) . '.';
    }

    public function getForenameInitialsAttribute($value)
    {
        return initializeString($this->forename) . '. ' . $this->surname;
    }

    public static function getPresentUsers()
    {
        return self::where('status', '=', 'active')
            ->where('forename', 'not like', '%Guest%')
            ->pluck('email')
            ->toArray();
    }

    public function permissions()
    {
        if ($this->role === 'admin' or $this->role === 'developer') {
            return $this->hasMany(Permission::class);
        }
        return null;
    }

    public function timesheets()
    {
        return $this->hasManyThrough(Timesheet::class, Profile::class,
            'user_id', 'employee_code', 'id', 'personnel_id');
    }

    public static function getActiveNonGuestUsers()
    {
        return self::where('status', 'active')
            ->where(function ($query) {
                $query->where('forename', 'not like', '%Guest%')
                    ->where('surname', 'not like', '%Guest%');
            })
            ->orderByRaw('CONCAT(forename, " ", surname)')
            ->get()
            ->pluck('full_name', 'id');
    }

    public static function getActivePSDepartmentUsers()
    {
        return self::with('profile')
            ->where('status', 'active')
            ->where('forename', 'not like', '%Guest%')
            ->where('surname', 'not like', '%Guest%')
//            ->where('surname', 'Rostami') // should be commented out for development
            ->whereHas('profile', function ($query) {
                $query->where('department', 'PS');
            })
            ->get();
    }
}
