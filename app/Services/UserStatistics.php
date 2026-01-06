<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserStatistics
{
    static $departmentNames = [
        'AC' => 'Accounting',
        'AS' => 'Administration & Support',
        'BD' => 'Business Development',
        'BS' => 'Business Systems',
        'CH' => 'Chemical & Polymer Products',
        'CM' => 'Commercial Import Operation',
        'CP' => 'Celluloid Products',
        'CX' => 'Commercial Export Operation',
        'HC' => 'Human Capital',
        'HR' => 'Human Resources',
        'MA' => 'Management',
        'MK' => 'Marketing',
        'PERSORE' => 'PERSORE',
        'PS' => 'Planning & System',
        'SO' => 'Solar Panels',
        'SP' => 'Sales Platform',
        'WP' => 'Wood Products',
    ];


    static $departmentPersianNames = [
        'AC' => 'مالی',
        'AS' => 'اداری و پشتیبانی',
        'BD' => 'توسعه کسب‌ وکار',
        'BS' => ' سیستم های کسب وکار',
        'CH' => 'فروش فراورده‌های  شیمیایی و پلیمری',
        'CM' => 'واردات',
        'CP' => 'فروش کاغذ و فراورده‌های سلولزی',
        'CX' => 'بازرگانی صادرات',
        'HC' => 'سرمایه انسانی',
        'HR' => 'منابع انسانی',
        'MA' => 'مدیریت',
        'MK' => 'بازاریابی',
        'PERSORE' => 'پرسور',
        'PS' => 'برنامه‌ریزی و بهبود سیستم‌ها',
        'SO' => 'پنل خورشیدی',
        'SP' => 'پلتفرم فروش',
        'WP' => 'فروش چوب',
    ];

    private static $activeUserIds;

    public static function getAgeDistribution()
    {
        return Cache::remember('ageDistribution', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();

            $query = Profile::whereIn('user_id', $activeIds)
                ->selectRaw("
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

    public static function getAverageWorkingHoursOfDepartments()
    {
        return Cache::remember('averageWorkingHoursOfDepartments', now()->addHours(8), function () {

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
        });
    }

    public static function getDepartmentDistribution()
    {
        return Cache::remember('departmentDistribution', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();
            $departmentCodes = array_keys(static::$departmentNames);

            $counts = Profile::whereIn('user_id', $activeIds)
                ->whereIn('department', $departmentCodes)
                ->selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->pluck('count', 'department');

            $chartData = [];
            foreach (static::$departmentNames as $code => $name) {
                $chartData[] = $counts->get($code, 0);
            }

            return [
                'label' => array_values(static::$departmentNames),
                'chartData' => $chartData,
            ];
        });
    }

    public static function getEducationAndExperience()
    {
        return Cache::remember('educationAndExperience', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();
            $degrees = ['undergraduate', 'graduate', 'postgraduate'];

            $data = [];
            $profiles = Profile::whereIn('user_id', $activeIds)
                ->selectRaw(
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

            foreach (['0-2', '3-5', '6-10', '11-15', '16+'] as $range) {
                foreach ($degrees as $degree) {
                    $data[$range][$degree] = 0;
                }
            }

            foreach ($profiles as $profile) {
                if ($profile->experience_range) {
                    $data[$profile->experience_range][$profile->degree] = $profile->count;
                }
            }

            return [
                'experienceRanges' => array_keys($data),
                'degreeTypes' => $degrees,
                'chartData' => $data,
            ];
        });
    }

    public static function getEmploymentType()
    {
        return Cache::remember('employmentType', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();

            $employmentData = Profile::whereIn('user_id', $activeIds)
                ->selectRaw('employment_type, COUNT(*) as count')
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

    public static function getGenderAndMaritalStatus()
    {
        return Cache::remember('genderAndMaritalStatus', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();

            $count = Profile::whereIn('user_id', $activeIds)
                ->selectRaw(
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
        return Cache::remember('genderAndPositions', now()->addHours(8), function () {
            $activeIds = self::activeUserIds();

            $counts = Profile::whereIn('user_id', $activeIds)
                ->whereIn('position', Profile::$positions)
                ->selectRaw('position, gender, COUNT(*) as count')
                ->groupBy('position', 'gender')
                ->get()
                ->groupBy('position');

            $chartData = [
                'label' => ['Male', 'Female'],
                'positions' => Profile::$positions,
                'data' => [],
            ];

            foreach (Profile::$positions as $position) {
                $positionCounts = $counts->get($position) ?? collect();

                $chartData['data'][$position] = [
                    $positionCounts->where('gender', 'male')->pluck('count')->first() ?? 0,
                    $positionCounts->where('gender', 'female')->pluck('count')->first() ?? 0,
                ];
            }

            return $chartData;
        });
    }

    public static function getHourlyAndDailyLeaves()
    {

        $currentYear = Date::getFarsiYear();

        return Cache::remember("hourlyDailyLeaves_{$currentYear}", now()->addHours(8), function () use ($currentYear) {
            $activePersonnelIds = Profile::whereIn('user_id', self::activeUserIds())->pluck('personnel_id');

            $monthlyData = Leave::whereIn('employee_code', $activePersonnelIds)
                ->select(

                    DB::raw('SUBSTRING(begin_date, 6, 2) as month'), // Extract MM from YYYY/MM/DD
                    DB::raw('SUM(CASE WHEN leave_type = "روزانه" THEN 1 ELSE 0 END) as daily_leaves'),
                    DB::raw('SUM(CASE WHEN leave_type = "ساعتی" THEN 1 ELSE 0 END) as hourly_leaves'),
                    DB::raw('SUM(CASE WHEN leave_type = "روزانه" THEN duration ELSE 0 END) as daily_duration'),
                    DB::raw('SUM(CASE WHEN leave_type = "ساعتی" THEN duration ELSE 0 END) as hourly_duration')
                )
                ->where('begin_date', 'LIKE', $currentYear . '/%') // Filter current year
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            $labels = [];
            $chartData = [
                'dailyLeaves' => [],
                'hourlyLeaves' => [],
                'dailyDurations' => [],
                'hourlyDurations' => [],
            ];

            foreach ($monthlyData as $data) {
                $labels[] = $data->month;

                $chartData['dailyLeaves'][] = $data->daily_leaves ?? 0;
                $chartData['hourlyLeaves'][] = $data->hourly_leaves ?? 0;
                $chartData['dailyDurations'][] = $data->daily_duration ?? 0;
                $chartData['hourlyDurations'][] = $data->hourly_duration ?? '00:00';
            }

            return [
                'labels' => $labels,
                'chartData' => $chartData,
            ];
        });
    }

    public static function getLeaveTypeByAgeRange()
    {
        return Cache::remember('leaveTypeByAgeRange', now()->addHours(8), function () {
            $activePersonnelIds = Profile::whereIn('user_id', self::activeUserIds())->pluck('personnel_id');

            $ageRanges = [
                ['label' => '18-24', 'min' => 18, 'max' => 24],
                ['label' => '25-34', 'min' => 25, 'max' => 34],
                ['label' => '35-44', 'min' => 35, 'max' => 44],
                ['label' => '45-54', 'min' => 45, 'max' => 54],
                ['label' => '55-64', 'min' => 55, 'max' => 64],
                ['label' => 'Above 65', 'min' => 65, 'max' => 200],
            ];

            $bindings = [];
            $caseStatements = array_map(function ($range) use (&$bindings) {
                $minDate = now()->subYears($range['max'])->format('Y-m-d');
                $maxDate = now()->subYears($range['min'])->format('Y-m-d');

                $bindings[] = $minDate;
                $bindings[] = $maxDate;

                return "SUM(CASE WHEN profiles.birthdate BETWEEN ? AND ? THEN 1 ELSE 0 END) as `{$range['label']}`";
            }, $ageRanges);

            $casesSql = implode(', ', $caseStatements);

            $results = Leave::join('profiles', 'leaves.employee_code', '=', 'profiles.personnel_id')
                ->whereIn('leaves.employee_code', $activePersonnelIds)
                ->whereIn('leave_type', ['ساعتی', 'روزانه'])
                ->selectRaw("leave_type, $casesSql", $bindings)
                ->groupBy('leave_type')
                ->get();

            $leaveTypeCounts = [];
            $typeMap = ['ساعتی' => 'Hourly', 'روزانه' => 'Daily'];

            foreach ($typeMap as $persian => $english) {
                $leaveTypeCounts[$english] = array_map(function ($range) use ($results, $persian) {
                    $count = 0;

                    if ($row = $results->firstWhere('leave_type', $persian)) {
                        $count = $row->{$range['label']} ?? 0;
                    }

                    return ['label' => $range['label'], 'count' => $count];
                }, $ageRanges);
            }

            return $leaveTypeCounts;
        });
    }

    private static function activeUserIds()
    {
        return self::$activeUserIds
            ??= Cache::remember('active_user_ids', now()->addHours(8), fn() => User::where('status', 'active')->pluck('id')
        );
    }
}
