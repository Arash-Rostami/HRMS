<?php

namespace App\Models;

use App\Services\DepartmentDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    use HasFactory;

    protected $fillable = ['dept', 'user_id', 'sub_duty', 'details'];

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDepartmentNameAttribute()
    {
        return DepartmentDetails::getName($this->dept);
    }

    public function getDepartmentCodeAttribute()
    {
        return DepartmentDetails::getCode($this->dept);
    }

    public function getDepartmentDescriptionAttribute()
    {
        return DepartmentDetails::getDescription($this->dept);
    }


    public static function getDutyCounts()
    {
        return [
            'duty' => self::where('sub_duty', true)->count(),
            'sub_duty' => self::where('sub_duty', false)->count(),
        ];
    }

    public static function getImpactScoreStats(): string
    {
        $impactScores = self::selectRaw('
        SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.impact_score")) = "very_high" THEN 1 ELSE 0 END) as very_high,
        SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.impact_score")) = "high" THEN 1 ELSE 0 END) as high,
        SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.impact_score")) = "medium" THEN 1 ELSE 0 END) as medium,
        SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.impact_score")) = "low" THEN 1 ELSE 0 END) as low
    ')->first();

        return "{$impactScores->very_high} - {$impactScores->high} - {$impactScores->medium} - {$impactScores->low}";
    }


    public static function getMonthlyRepeatStats(): string
    {
        $repeatFrequencies = self::selectRaw('
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.repeat_frequency")) = "frequent" THEN 1 ELSE 0 END) as frequent,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.repeat_frequency")) = "regular" THEN 1 ELSE 0 END) as regular,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(details, "$.repeat_frequency")) = "occasional" THEN 1 ELSE 0 END) as occasional
        ')->first();

        return "{$repeatFrequencies->frequent} - {$repeatFrequencies->regular} -  {$repeatFrequencies->occasional}";
    }
}
