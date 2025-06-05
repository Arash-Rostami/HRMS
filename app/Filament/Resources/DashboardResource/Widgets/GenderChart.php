<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\UserStatistics;
use Filament\Widgets\DoughnutChartWidget;

class GenderChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Gender & Marital Status';

    protected function getData(): array
    {
        $data = UserStatistics::getGenderAndMaritalStatus();
        return [
            'datasets' => [
                [
                    'data' =>
                        $data['chartData']
                    ,
                    'backgroundColor' => [
                        'rgb(36,65,91, 0.50)',
                        'rgb(36,65,91)',
                        'rgba(255, 99, 132, 0.1)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    'borderColor' => ['#181b27']
                ],
            ],
            'labels' => $data['label'],
        ];
    }
}
