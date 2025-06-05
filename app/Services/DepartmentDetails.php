<?php

namespace App\Services;

class DepartmentDetails
{
    public static $departments = [
        'HR' => [
            'name' => 'Human Resources',
            'code' => 'HR',
            'description' => 'منابع انسانی',
        ],
        'AS' => [
            'name' => 'Administration & Support',
            'code' => 'AS',
            'description' => 'اداری و پشتیبانی',
        ],
        'PR' => [
            'name' => 'Public Relations',
            'code' => 'PR',
            'description' => 'روابط عمومی و مسئولیت اجتماعی',
        ],
        'VC' => [
            'name' => 'Investment',
            'code' => 'VC',
            'description' => 'سرمایه‌گذاری',
        ],
        'FP' => [
            'name' => 'Food Products',
            'code' => 'FP',
            'description' => 'بازرگانی مواد غذایی',
        ],
        'CM' => [
            'name' => 'Commercial Import Operation',
            'code' => 'CM',
            'description' => 'بازرگانی (واردات و خرید داخلی)',
        ],
        'CP' => [
            'name' => 'Cellulosic Products',
            'code' => 'CP',
            'description' => 'فروش فراورده‌های سلولزی',
        ],
        'AC' => [
            'name' => 'Accounting',
            'code' => 'AC',
            'description' => 'مالی',
        ],
        'PS' => [
            'name' => 'Planning & System',
            'code' => 'PS',
            'description' => 'برنامه‌ریزی و بهبود سیستم‌ها',
        ],
        'WP' => [
            'name' => 'Wood Products',
            'code' => 'WP',
            'description' => 'فروش فراورده های چوب',
        ],
        'SA' => [
            'name' => 'Sales',
            'code' => 'SA',
            'description' => 'واحد(های) فروش',
        ],
        'MK' => [
            'name' => 'Marketing',
            'code' => 'MK',
            'description' => 'واحد بازاریابی',
        ],
        'PO' => [
            'name' => 'Polymer Products',
            'code' => 'PO',
            'description' => 'فروش محصولات پلیمری',
        ],
        'CH' => [
            'name' => 'Chemical and Polymer Products',
            'code' => 'CH',
            'description' => 'فروش فراورده های شیمیایی و پلیمری',
        ],
        'SP' => [
            'name' => 'Sales Platform',
            'code' => 'SP',
            'description' => 'پلتفرم فروش',
        ],
        'CX' => [
            'name' => 'Commercial Export Operation',
            'code' => 'CX',
            'description' => 'بازرگانی (صادرات)',
        ],
        'BD' => [
            'name' => 'Business Development',
            'code' => 'BD',
            'description' => 'توسعه کسب و کار',
        ],
        'MG' => [
            'name' => 'Management (deprecated)',
            'code' => 'MG',
            'description' => 'مدیریت',
        ],
        'MA' => [
            'name' => 'Management',
            'code' => 'MA',
            'description' => 'مدیریت (جدید)',
        ],
        'HC' => [
            'name' => 'Human Capital',
            'code' => 'HC',
            'description' => 'سرمایه انسانی',
        ],
        'SO' => [
            'name' => 'Solar Panels',
            'code' => 'SO',
            'description' => 'پنل خورشیدی',
        ],
        'PERSORE' => [
            'name' => 'Persore',
            'code' => 'PERSORE',
            'description' => 'پرسور',
        ]
    ];

    public static function getName($department)
    {
        return static::$departments[$department]['name'];
    }

    public static function getCode($department)
    {
        return static::$departments[$department]['code'];
    }

    public static function getDescription($department)
    {
        return static::$departments[$department]['description'];
    }

    public static function getDepartmentsArray()
    {
        $departmentsArray = [];
        foreach (self::$departments as $code => $details) {
            $departmentsArray[$code] = $details['name'];
        }
        asort($departmentsArray);

        return $departmentsArray;
    }

    public static function getDepartmentsDescriptions()
    {
        $departmentsArray = [];
        foreach (self::$departments as $code => $details) {
            if (!in_array($code, ['CX', 'MG', 'FP', 'PR', 'VC', 'PO', 'SA', 'SP'])) {
                $departmentsArray[$code] = $details['description'];
            }
        }
        asort($departmentsArray);

        return $departmentsArray;
    }

    public static function getDepartmentDetails($departmentName)
    {
        foreach (self::$departments as $code => $details) {
            if ($details['description'] === $departmentName) {
                return
                    $code;

            }
        }
        return null;
    }
}
