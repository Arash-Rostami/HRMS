<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Profile;
use App\Services\UserStatistics;
use Filament\Widgets\BarChartWidget;

class PositionChart extends BarChartWidget
{
    protected static ?string $heading = 'Position & Gender';


    private function fetchStatistics(): array
    {
        $dataset = UserStatistics::getGenderAndPositions();
        $data = [];

        foreach ($dataset['data'] as $position => $values) {
            $data['male'][$position] = $values[0];
            $data['female'][$position] = $values[1];
            $data['total'][$position] = $values[0] + $values[1];
        }
        return $data;
    }

    protected function getData(): array
    {
        $data = $this->fetchStatistics();

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $data['total'],
                    'backgroundColor' => 'rgb(182,162,145)',
                    'hover' => 0.9,
                ],
                [
                    'label' => 'Male',
                    'data' => $data['male'],
                    'backgroundColor' => 'rgb(33,53,73)',
                    'hover' => 0.9,
                ], [
                    'label' => 'Female',
                    'data' => $data['female'],
                    'backgroundColor' => 'rgb(76,53,70)',
                    'hover' => 0.9,
                ]
            ],
            'labels' => Profile::$positions,
        ];
    }
}
