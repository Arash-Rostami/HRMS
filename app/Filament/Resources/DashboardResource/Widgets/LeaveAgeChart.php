<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\UserStatistics;
use Filament\Widgets\BarChartWidget;

class LeaveAgeChart extends BarChartWidget
{
    protected static ?string $heading = 'Leaves Type & Age';

    /**
     * @return array
     */
    public function fetchStatistics(): array
    {
        $data = UserStatistics::getLeaveTypeByAgeRange();

        $labels = array_map(fn($item) => $item['label'], $data['Hourly']);
        $hourlyData = array_map(fn($item) => $item['count'], $data['Hourly']);
        $dailyData = array_map(fn($item) => $item['count'], $data['Daily']);
        return array($labels, $hourlyData, $dailyData);
    }

    protected function getData(): array
    {
        list($labels, $hourlyData, $dailyData) = $this->fetchStatistics();

        return [
            'datasets' => [
                [
                    'label' => 'Hourly leaves',
                    'data' => $hourlyData,
                    'backgroundColor' => 'rgb(76,53,70)',
                    'hover' => 0.5,
                ], [
                    'label' => 'Daily leaves',
                    'data' => $dailyData,
                    'backgroundColor' => 'rgb(182,162,145, 0.7)',
                    'hover' => 0.5,
                ],
            ],
            'labels' => $labels,
        ];
    }

}
