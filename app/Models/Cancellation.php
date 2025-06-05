<?php

namespace App\Models;

use App\Services\Utility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking', 'number', 'start_date', 'end_date', 'user_id', 'edit', 'soft_delete'
    ];

    public static function countAll()
    {
        return self::all()->count();
    }

    public static function countParking(): int
    {
        return self::where('booking', 'parking')->count();
    }

    public static function countDesks()
    {
        return self::where('booking', 'office')->count();
    }

    public static function getThis($number)
    {
        return self::where('number', $number)
            ->where('user_id', '!=', auth()->user()->id)
            ->where('start_date', '<=', Utility::makePreciseDate('from', request()))
            ->where('end_date', '>=', Utility::makePreciseDate('to', request(), true))
            ->exists();
    }


    public function isAppended($num)
    {
        return $this->where('number', $num)
            ->where('user_id', auth()->user()->id)
            ->where('end_date', Utility::makePreciseDate('from', request(), true))
            ->exists();
    }

    public function isPrepended($num)
    {
        return $this->where('number', $num)
            ->where('user_id', auth()->user()->id)
            ->where('start_date', Utility::makePreciseDate('to', request()))
            ->exists();
    }

    public function seat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seat::class, 'number');
    }

    public function spot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Spot::class, 'number');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
