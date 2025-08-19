<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class AssetManager
{
    public static function getAnalyticsConfig(): array
    {
        return [
            'getGenderAndMaritalStatusChartData' => UserStatistics::getGenderAndMaritalStatus(),
            'getGenderAndPositionsChartData' => UserStatistics::getGenderAndPositions(),
            'getEmploymentTypeChartData' => UserStatistics::getEmploymentType(),
            'getDepartmentDistributionChartData' => UserStatistics::getDepartmentDistribution(),
            'getAgeDistributionChartData' => UserStatistics::getAgeDistribution(),
            'getEducationAndExperienceChartData' => UserStatistics::getEducationAndExperience(),
            'getAverageWorkingHoursChartData' => UserStatistics::getAverageWorkingHoursOfDepartments()
        ];
    }

    public static function getBodyJsAssets(): Collection
    {
        return collect([
            'js/intersect.js' => true,
            'js/fancyBox.js' => true,
            'js/modal.js' => true,
            'js/pagination.js' => true,
            'js/filter.js' => true,
            'js/tooltip.js' => true,
            'js/slogans.js' => true,
            'js/autoPlayAudio.js' => true,
            'js/google-translate.js' => (isset(request()->translatePage) && request()->translatePage == true),
            'js/jobs.js' => (isset(request()->jobs) && count(request()->jobs) > 0),
            'js/clipboard.js' => (isset($jobs) && count($jobs) > 0),
            'js/Sortable.min.js' => isNotMobileDevice(),
            'js/sortableConfig.js' => isNotMobileDevice(),
            'js/tunes.js' => hasChosenMusic(),
        ])
            ->filter()
            ->filter(fn($condition, $path) => file_exists(public_path($path)))
            ->mapWithKeys(fn($condition, $path) => [$path => md5_file(public_path($path))]);
    }

    public static function getColorMode(): ?string
    {
        return Cookie::get('mode');
    }

    public static function getCssAssets(): Collection
    {
        return collect([
            'css/app.css',
            'css/tw.css',
            'css/fancyBox.css',
        ])
            ->filter(fn($path) => file_exists(public_path($path)))
            ->mapWithKeys(fn($path) => [$path => md5_file(public_path($path))]);
    }

    public static function getHeadJsAssets(): Collection
    {
        return collect([
            'js/sortable.js' => true,
            'js/app.js' => false,
        ])
            ->filter()
            ->filter(fn($condition, $path) => file_exists(public_path($path)))
            ->mapWithKeys(fn($condition, $path) => [$path => md5_file(public_path($path))]);
    }
}
