<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $casts = [
        'attachments' => 'array',
    ];

    public static array $positions = [
        'manager', 'supervisor', 'senior', 'expert', 'employee'
    ];


    protected $fillable = [
        'user_id',
        'personnel_id',
        'image',
        'attachments',
        'gender',
        'employment_type',
        'marital_status',
        'number_of_children',
        'employment_status',
        'id_card_number',
        'id_booklet_number',
        'degree',
        'field',
        'birthdate',
        'landline',
        'cellphone',
        'license_plate',
        'zip_code',
        'address',
        'accessibility',
        'department',
        'position',
        'insurance',
        'emergency_phone',
        'emergency_relationship',
        'start_date',
        'end_date',
        'work_experience',
        'interests',
        'favorite_colors',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function countMale()
    {
        return self::where('gender', 'male')->count();
    }

    public static function countFemale()
    {
        return self::where('gender', 'female')->count();
    }

    public static function countMarried()
    {
        return self::where('marital_status', 'married')->count();
    }

    public static function countSingle()
    {
        return self::where('marital_status', 'single')->count();
    }

    public static function countFullTime()
    {
        return self::where('employment_type', 'fulltime')->count();
    }

    public static function countPartTime()
    {
        return self::where('employment_type', 'parttime')->count();
    }

    public static function countContract()
    {
        return self::where('employment_type', 'contract')->count();
    }

    public static function countProbational()
    {
        return self::where('employment_status', 'probational')->count();
    }

    public static function countWorking()
    {
        return self::where('employment_status', 'working')->count();
    }

    public static function countTerminated()
    {
        return self::where('employment_status', 'terminated')->count();
    }

    public static function findByPersonnelId($personnelId)
    {
        return self::where('personnel_id', $personnelId)->first();
    }

    public static function findNonPresentProfiles($attendanceData)
    {
        return self::whereNotIn('personnel_id', array_column($attendanceData, 'employeeCode'))->get();
    }

    public function countNumberOfDaysTo($event)
    {
        $format = str_contains($event, ' ') ? 'Y-m-d H:i:s' : 'Y-m-d';
        $nextBirthday = Carbon::createFromFormat($format, $event)->startOfDay()->setYear(now()->year);

        // If the birthday has already occurred this year, set the year to next year
        if ($nextBirthday->lt(now())) {
            $nextBirthday->addYear();
        }

        $diff = now()->diffInDays($nextBirthday) + 1;

        return ($diff === 0) ? ':)' : $diff;
    }

    public function countDaysPassedSince($event)
    {
        $format = str_contains($event, ' ') ? 'Y-m-d H:i:s' : 'Y-m-d';
        $eventDate = Carbon::createFromFormat($format, $event);

        return $eventDate->diffInDays(now());
    }

    public static function getDaysUser($numOfDays)
    {
        return self::where(function ($query) {
            $query->whereNull('end_date')->orWhere('end_date', '=', '');
        })
            ->where('start_date', '=', today()->subDays($numOfDays)->toDateString())->pluck('user_id');
    }


    public function hasNoEmptyFields()
    {
        $filledFields = [
            'personnel_id', 'department', 'employment_status', 'employment_type', 'position', 'start_date'
        ];

        $fieldsToCheck = [
            'gender', 'marital_status', 'number_of_children',
            'id_card_number', 'id_booklet_number', 'degree', 'field',
            'cellphone', 'zip_code', 'address', 'insurance', 'emergency_phone', 'emergency_relationship',
            'work_experience'
        ];

        foreach ($filledFields as $field) {
            if ($this->{$field} === null || $this->{$field} === '') {
                return true;
            }
        }

        foreach ($fieldsToCheck as $field) {
            if ($this->{$field} === null || $this->{$field} === '') {
                return false;
            }
        }

        return true;
    }
}
