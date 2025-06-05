<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'position',
        'certificate',
        'skill',
        'experience',
        'gender',
        'link',
        'active'
    ];

    public static function countActiveJobs()
    {
        return self::where('active', 1)->count();
    }

    public static function countInactiveJobs()
    {
        return self::where('active', 0)->count();
    }

    public static function countFemales()
    {
        return self::where('gender', 'Female')->count();
    }

    public static function countMales()
    {
        return self::where('gender', 'Male')->count();

    }

    public static function countBothGender()
    {
        return self::where('gender', 'Any')->count();

    }

}
