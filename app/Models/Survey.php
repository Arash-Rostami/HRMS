<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Survey extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'days', 'resource', 'team', 'manager', 'company',
        'join', 'newcomer', 'buddy', 'role', 'challenge', 'stage',
        'improvement', 'suggestion'
    ];

    public static function getAvg($col)
    {
        $average = self::where(DB::raw('YEAR(created_at)'), Carbon::now()->year)
            ->select(DB::raw("AVG({$col}) as average"))
            ->first()->average;

        return number_format($average, 2) . ' Avg.';
    }

    public static function getAvgJoin()
    {
        $average = self::where(DB::raw('YEAR(created_at)'), Carbon::now()->year)
            ->average('join');

        return number_format($average, 2) . ' Avg.';
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function hasUserRecord($numOfDays)
    {
        return self::where('user_id', auth()->user()->id)
            ->where('days', $numOfDays)->exists();
    }

    private static function showRatingStars($average)
    {
        return showRating($average) . number_format($average, 2) . ' Avg.';
    }
}
