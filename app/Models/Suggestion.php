<?php

namespace App\Models;

use App\Services\UserStatistics;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'suggestions';


    protected $fillable = ['title', 'description', 'department', 'purpose', 'rule', 'attachment', 'stage', 'self_fill', 'abort', 'priority', 'comments', 'user_id'];


    public static function countAborted()
    {
        return self::where('abort', 'yes')->count();
    }

    public static function countAttachment()
    {
        return self::whereNotNull('attachment')->count();
    }

    public static function countClosed()
    {
        return self::where('stage', 'closed')->count();
    }

    public static function countPending()
    {
        return self::whereNotIn('stage', ['accepted', 'rejected', 'closed'])->count();
    }

    public static function countSelfFilled()
    {
        return self::where('self_fill', true)->count();
    }

    public static function countStage($stage)
    {
        return self::where('stage', $stage)->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getDepAttribute()
    {
        return UserStatistics::$departmentPersianNames[$this->user->profile->department];
    }

    public function getRuleAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getPurposeAttribute($value)
    {
        return json_decode($value, true);
    }

    public function inProcessReviews()
    {
        return $this->hasMany(Review::class)->where('department', 'MA')
            ->whereNotNull('referral');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function stageIcon()
    {
        return match ($this->stage) {
            'pending' => '🕒 ارسال شده',
            'team_remarks' => '💬 منتظر هم‌تیمی‌ها',
            'dept_remarks' => '📝 منتظر ذینفعان',
            'awaiting_decision' => '🤔 منتظر تصمیم نهایی',
            'accepted' => '😊 پذیرفته شده',
            'rejected' => '😔 پذیرفته ‌نشده',
            'under_review' => '🔍 نیازمند تکمیل',
            'closed' => '🔒 پایان‌یافته',
            default => '❓',
        };
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
