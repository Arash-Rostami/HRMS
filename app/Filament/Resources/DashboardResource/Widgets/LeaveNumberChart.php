<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\Date;
use App\Services\UserStatistics;
use Filament\Widgets\LineChartWidget;

class LeaveNumberChart extends LineChartWidget
{

    protected function getHeading(): string
    {
        return "Leaves number in " . Date::getFarsiYear();
    }

    protected function getData(): array
    {
        $data = UserStatistics::getHourlyAndDailyLeaves();

        return [
            'datasets' => [
                [
                    'label' => 'Hourly leaves',
                    'data' => $data['chartData']['hourlyLeaves'],
                    'borderColor' => ['rgb(66,94,108)'],
                    'tension' => 1.0
                ],
                [
                    'label' => 'Daily leaves',
                    'data' => $data['chartData']['dailyLeaves'],
                    'borderColor' => ['rgb(75, 67, 192, 0.4)'],
                    'tension' => 1.0

                ]
            ],
            'labels' => $data['labels'],
        ];
    }
}
