<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\UserStatistics;
use Filament\Widgets\LineChartWidget;

class AgeChart extends LineChartWidget
{
    protected static ?string $heading = 'Age & Gender';

    protected function getData(): array
    {
        $dataset = UserStatistics::getAgeDistribution();

        $data = [];
        $labels = [];

        foreach ($dataset['data'] as $gender => $values) {

            foreach ($values as $key => $value) {
                $data[$gender][] = $value;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Both',
                    'data' => $data['both'],
                    'backgroundColor' => 'rgb(182,162,145)',
                    'borderColor' => 'rgb(182,162,145)'
                ],
                [
                    'label' => 'Females',
                    'data' => $data['female']
                    ,
                    'backgroundColor' => 'rgb(76,53,70)',
                    'borderColor' => 'rgb(76,53,70)'
                ],
                [
                    'label' => 'Males',
                    'data' => $data['male'],
                    'backgroundColor' => 'rgb(36,65,91)',
                    'borderColor' => 'rgb(36,65,91)'
                ],
            ],
            'labels' => $dataset['labels'],
        ];
    }
}
