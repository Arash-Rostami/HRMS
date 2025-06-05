<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\UserStatistics;
use Filament\Widgets\BarChartWidget;

class ExperienceChart extends BarChartWidget
{
    protected static ?string $heading = 'Education & Experience';


    private function fetchStatistics(): array
    {
        $dataset = UserStatistics::getEducationAndExperience();
        $data = [];
        $label = [];

        foreach ($dataset['chartData'] as $ageBrackets => $values) {
            $data['undergraduate'][] = $values['undergraduate'];
            $data['graduate'][] = $values['graduate'];
            $data['postgraduate'][] = $values['postgraduate'];
            $label[] = $ageBrackets;
        }
        return array($data, $label);
    }

    protected function getData(): array
    {
        list($data, $label) = $this->fetchStatistics();
        return [
            'datasets' => [
                [
                    'label' => 'Undergraduate',
                    'data' => $data['undergraduate'],
                    'backgroundColor' => 'rgb(103,151,162,0.2)',
                    'hover' => 0.5,
                ], [
                    'label' => 'Graduate',
                    'data' => $data['graduate'],
                    'backgroundColor' => 'rgb(147,216,231,0.3)',
                    'hover' => 0.5,
                ], [
                    'label' => 'Post graduate',
                    'data' => $data['postgraduate'],
                    'backgroundColor' => 'rgb(199,204,205, 0.4)',
                    'hover' => 0.5,
                ],
            ],
            'labels' => $label,
        ];
    }
}
