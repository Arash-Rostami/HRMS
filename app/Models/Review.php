<?php

namespace App\Models;

use App\Services\UserStatistics;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['comments', 'actions', 'feedback', 'department', 'referral', 'user_id', 'suggestion_id'];

    public static $filamentDetection = false;

    public function feedbackIcon()
    {
        return match ($this->feedback) {
            'agree' => '👍',
            'disagree' => '👎',
            'neutral' => '🖖',
            'incomplete' => '⚠️',
            'unknown' => '❓'
        };
    }

    public static function countMA()
    {
        return self::where('department', 'MA')->count();
    }

    public static function countNonMA()
    {
        return self::where('department', '!=','MA')->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getDepartmentAttribute($value)
    {
        return UserStatistics::$departmentPersianNames[$value];
    }

    public function getPureDepartmentAttribute()
    {
        return $this->attributes['department'];
    }

    public function feedbackPersian()
    {
        return match ($this->feedback) {
            'agree' => 'موافق',
            'disagree' => 'مخالف',
            'neutral' => 'نیمه موافق',
            'incomplete' => 'ناقص',
            'unknown' => '❓',
        };
    }

    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class, 'suggestion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
