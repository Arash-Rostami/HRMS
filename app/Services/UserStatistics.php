<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class UserStatistics
{
    static $departmentNames = [
        'HR' => 'Human Resources',
        'MA' => 'Management',
        'AS' => 'Administration & Support',
        'CM' => 'Commercial Import Operation',
        'CP' => 'Celluloid Products',
        'AC' => 'Accounting',
        'PS' => 'Planning & System',
        'WP' => 'Wood Products',
        'MK' => 'Marketing',
        'CH' => 'Chemical & Polymer Products',
        'SP' => 'Sales Platform',
        'CX' => 'Commercial Export Operation',
        'BD' => 'Business Development',
        'SO' => 'Solar Panels',
        'PERSORE' => 'PERSORE',
    ];


    static $departmentPersianNames = [
        'HR' => 'منابع انسانی',
        'MA' => 'مدیریت',
        'AS' => 'اداری و پشتیبانی',
        'CM' => ' واردات ',
        'CP' => 'فروش کاغذ و فراورده‌های سلولزی',
        'AC' => 'مالی',
        'PS' => 'برنامه‌ریزی و بهبود سیستم‌ها',
        'WP' => 'فروش چوب',
        'MK' => 'بازاریابی',
        'CH' => 'فروش فراورده‌های  شیمیایی و پلیمری',
        'SP' => 'پلتفرم فروش',
        'CX' => 'بازرگانی صادرات',
        'BD' => 'توسعه کسب‌ وکار',
        'SO'      => 'پنل خورشیدی',
        'PERSORE' => 'پرسور',
    ];


    public static function getGenderAndMaritalStatus()
    {
        // Attempt to retrieve the cached data
        return Cache::remember('genderAndMaritalStatus', now()->addHours(8), function () {
            // If not cached, calculate and store the data
            $count = Profile::selectRaw(
                "SUM(gender = 'male' AND marital_status = 'married') as marriedMale,
                 SUM(gender = 'male' AND marital_status != 'married') as singleMale,
                 SUM(gender = 'female' AND marital_status = 'married') as marriedFemale,
                 SUM(gender = 'female' AND marital_status != 'married') as singleFemale"
            )->first();

            return [
                'label' => ['Married ♂', 'Single ♂', 'Married ♀', 'Single ♀'],
                'chartData' => [$count->marriedMale, $count->singleMale, $count->marriedFemale, $count->singleFemale]
            ];
        });
    }

    public static function getGenderAndPositions()
    {
        // Attempt to retrieve the cached data
        return Cache::remember('genderAndPositions', now()->addHours(8), function () {
            // If not cached, calculate and store the data
            $chartData = [
                'label' => ['Male', 'Female'],
                'positions' => Profile::$positions,
                'data' => [],
            ];

            foreach (Profile::$positions as $position) {
                $counts = Profile::where('position', $position)
                    ->selectRaw('gender, COUNT(*) as count')
                    ->groupBy('gender')
                    ->get()
                    ->pluck('count', 'gender')
                    ->toArray();

                $chartData['data'][$position] = [$counts['male'] ?? 0, $counts['female'] ?? 0];
            }

            return $chartData;
        });
    }

    public static function getEmploymentType()
    {
        // Attempt to retrieve the cached data
        return Cache::remember('employmentType', now()->addHours(8), function () {
            // If not cached, calculate and store the data
            $employmentData = Profile::selectRaw('employment_type, COUNT(*) as count')
                ->groupBy('employment_type')
                ->get();

            $employmentCounts = [];
            foreach ($employmentData as $data) {
                $employmentCounts[$data->employment_type] = $data->count ?? 0;
            }
            return [
                'label' => ['Full-time', 'Part-time', 'Contract'],
                'chartData' => [
                    $employmentCounts['fulltime'],
                    $employmentCounts['parttime'],
                    $employmentCounts['contract']
                ]
            ];
        });
    }

    public static function getDepartmentDistribution()
    {
        // Attempt to retrieve the cached data
        return Cache::remember('departmentDistribution', now()->addHours(8), function () {
            $data = [];
            foreach (static::$departmentNames as $code => $name) {
                $data[] = Profile::where('department', $code)->count();
            }

            return [
                'label' => array_values(static::$departmentNames),
                'chartData' => $data,
            ];
        });
    }


    public static function getAgeDistribution()
    {
        return Cache::remember('ageDistribution', now()->addHours(8), function () {

            $query = Profile::selectRaw("
                        CASE
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 36 AND 45 THEN '36-45'
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 46 AND 55 THEN '46-55'
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= 56 THEN '56+'
                        END as age_range,
                        COUNT(*) as total,
                        COUNT(CASE WHEN gender = 'female' THEN 1 END) as female,
                        COUNT(CASE WHEN gender = 'male' THEN 1 END) as male")
                ->groupBy('age_range')
                ->get();

            $data = [
                'both' => [], 'female' => [], 'male' => []
            ];

            foreach ($query as $row) {
                $data['both'][$row->age_range] = $row->total;
                $data['female'][$row->age_range] = $row->female;
                $data['male'][$row->age_range] = $row->male;
            }

            return [
                'labels' => array_keys($data['both']),
                'data' => $data,
            ];
        });
    }


    public static function getEducationAndExperience()
    {
        return Cache::remember('educationAndExperience', now()->addHours(8), function () {

            $degrees = ['undergraduate', 'graduate', 'postgraduate'];

            $data = [];
            $profiles = Profile::selectRaw(
                "degree,
                        CASE
                            WHEN CAST(REGEXP_REPLACE(work_experience, '[^0-9]', '') AS SIGNED) BETWEEN 0 AND 2 THEN '0-2'
                            WHEN CAST(REGEXP_REPLACE(work_experience, '[^0-9]', '') AS SIGNED) BETWEEN 3 AND 5 THEN '3-5'
                            WHEN CAST(REGEXP_REPLACE(work_experience, '[^0-9]', '') AS SIGNED) BETWEEN 6 AND 10 THEN '6-10'
                            WHEN CAST(REGEXP_REPLACE(work_experience, '[^0-9]', '') AS SIGNED) BETWEEN 11 AND 15 THEN '11-15'
                            WHEN CAST(REGEXP_REPLACE(work_experience, '[^0-9]', '') AS SIGNED) >= 16 THEN '16+'
                        END as experience_range,
                        COUNT(*) as count")
                ->whereNotNull('work_experience')
                ->whereNotNull('degree')
                ->whereIn('degree', $degrees)
                ->groupBy('degree', 'experience_range')
                ->get();

            foreach (['0-2', '3-5', '6-10', '11-15'] as $range) {
                foreach ($degrees as $degree) {
                    // Initialize counts to zero
                    $data[$range][$degree] = 0;
                }
            }

            foreach ($profiles as $profile) {
                $data[$profile->experience_range][$profile->degree] = $profile->count;
            }

            return [
                'experienceRanges' => array_keys($data),
                'degreeTypes' => $degrees,
                'chartData' => $data,
            ];
        });
    }

    public static function getAverageWorkingHoursOfDepartments()
    {
        $usersWithTimesheets = User::with(['profile', 'timesheets' => fn($query) => $query->where('timesheets.created_at', '>=', now()->subDays(30))])
            ->where('status', 'active')
            ->get()
            ->groupBy('profile.department');

        $departmentAverages = [];
        $totalDepartments = [];

        foreach ($usersWithTimesheets as $department => $users) {
            $timesheetCount = 0;
            $totalWorkingHours = 0;

            $users->each(function ($user) use (&$totalWorkingHours, &$timesheetCount) {
                if ($user->profile && $user->timesheets->isNotEmpty()) {
                    $user->timesheets->each(function ($timesheet) use (&$totalWorkingHours, &$timesheetCount) {
                        if ($timesheet->exit_time) {
                            $entryTime = Carbon::createFromFormat('H:i', $timesheet->entry_time ?? '08:00'); // if for any reason it was NOT set
                            $exitTime = Carbon::createFromFormat('H:i', $timesheet->exit_time ?? '16:00'); // if for any reason it was NOT set
                            $workingHours = $entryTime->floatDiffInHours($exitTime);

                            $totalWorkingHours += $workingHours;
                            $timesheetCount++;
                        }
                    });
                }
            });

            if ($timesheetCount > 0) {
                $totalDepartments[] = $department;
                $departmentAverages[$department] = [
                    'department' => $department,
                    'total_hours' => $totalWorkingHours,
                    'user_count' => $users->count(),
                    'time_sheet_count' => $timesheetCount,
                    'average' => number_format($totalWorkingHours / $timesheetCount, 2),
                ];
            }
        }

        return [
            'labels' => $totalDepartments,
            'chartData' => $departmentAverages,
        ];
    }

    public static function getHourlyAndDailyLeaves()
    {
        $monthlyData = Leave::select(
            DB::raw('MONTH(begin_date) as month'),
            DB::raw('SUM(CASE WHEN leave_type = "روزانه" THEN 1 ELSE 0 END) as daily_leaves'),
            DB::raw('SUM(CASE WHEN leave_type = "ساعتی" THEN 1 ELSE 0 END) as hourly_leaves'),
            DB::raw('SUM(CASE WHEN leave_type = "روزانه" THEN duration ELSE 0 END) as daily_duration'),
            DB::raw('SUM(CASE WHEN leave_type = "ساعتی" THEN duration ELSE 0 END) as hourly_duration')
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $chartData = [];

        foreach ($monthlyData as $data) {
            $labels[] = $data->month;

            $chartData['dailyLeaves'][] = $data->daily_leaves;
            $chartData['hourlyLeaves'][] = $data->hourly_leaves;

            // Format daily durations as numbers
            $chartData['dailyDurations'][] = $data->daily_duration;

            // Format hourly durations as HH:mm
            $chartData['hourlyDurations'][] = $data->hourly_duration;
        }

        return [
            'labels' => $labels,
            'chartData' => $chartData,
        ];
    }

    public static function getLeaveTypeByAgeRange()
    {
        $ageRanges = [
            ['label' => '18-24', 'min' => 18, 'max' => 24],
            ['label' => '25-34', 'min' => 25, 'max' => 34],
            ['label' => '35-44', 'min' => 35, 'max' => 44],
            ['label' => '45-54', 'min' => 45, 'max' => 54],
            ['label' => '55-64', 'min' => 55, 'max' => 64],
            ['label' => 'Above 65', 'min' => 65, 'max' => 200],
        ];

        $leaveTypeCounts = [];

        foreach (['ساعتی', 'روزانه'] as $leaveType) {
            $leaveTypeCount = [];

            foreach ($ageRanges as $range) {
                $minAge = $range['min'];
                $maxAge = $range['max'];

                // Calculate the number of leaves in this age range for the specified leave type.
                $leaveCount = Leave::where('leave_type', $leaveType)
                    ->whereHas('profile', function ($query) use ($minAge, $maxAge) {
                        $query->whereBetween('birthdate', [now()->subYears($maxAge), now()->subYears($minAge)]);
                    })->count();

                $leaveTypeCount[] = [
                    'label' => $range['label'],
                    'count' => $leaveCount,
                ];
            }

            $leaveTypeCounts[($leaveType == 'ساعتی') ? 'Hourly' : 'Daily'] = $leaveTypeCount;
        }

        return $leaveTypeCounts;
    }
}
