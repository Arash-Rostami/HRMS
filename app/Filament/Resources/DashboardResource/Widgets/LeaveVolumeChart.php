<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Leave;
use App\Services\Date;
use App\Services\UserStatistics;
use Filament\Widgets\BarChartWidget;

class LeaveVolumeChart extends BarChartWidget
{

    protected function getHeading(): string
    {
        return "Leaves duration in " . Date::getFarsiYear();
    }

    protected function getData(): array
    {
        $data = UserStatistics::getHourlyAndDailyLeaves();

        return [
            'datasets' => [
                [
                    'label' => 'Hourly leaves (Hours)',
                    'data' => $data['chartData']['hourlyDurations'],
                    'backgroundColor' => ['rgb(66,94,108)'],
                    'tension' => 1.0,

                ], [
                    'label' => 'Daily leaves (Days)',
                    'data' => $data['chartData']['dailyDurations'],
                    'backgroundColor' => ['rgb(75, 67, 192, 0.4)'],
                    'tension' => 1.0

                ],
            ],
            'labels' => $data['labels'],

        ];
    }
}
