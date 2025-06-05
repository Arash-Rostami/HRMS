<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Services\UserStatistics;
use Filament\Widgets\PolarAreaChartWidget;

class WorkingHoursChart extends PolarAreaChartWidget
{
    protected static ?string $heading = 'Total & Average Working Hours';


    private function fetchStatistics(): array
    {
        $dataset = UserStatistics::getAverageWorkingHoursOfDepartments();

        $averages = $totals = [];
        $labels = [];

        foreach ($dataset['chartData'] as $department => $values) {
            $averages[] = $values['average'];
            $totals[] = $values['total_hours'];
            $labels[] = $department;
        }
        return array($totals, $averages, $labels);
    }

    protected function getData(): array
    {
        list($totals, $averages, $labels) = $this->fetchStatistics();

        return [
            'datasets' => [
                [
                    'label' => 'Average Working Hours',
                    'data' => $averages,
                    'backgroundColor' => ' rgb(255,99,132, 0.2)',
                    'hover' => 0.9,
                    'spanGaps' => true
                ],
                [
                    'label' => 'Total Working Hours',
                    'data' => $totals,
                    'backgroundColor' => 'rgb(103,151,162, 0.2)',
                    'hover' => 0.9,
                    'spanGaps' => true
                ],
            ],
            'labels' => $labels,
        ];
    }
}
