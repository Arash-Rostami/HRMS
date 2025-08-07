<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\EnergyTest;
use Filament\Widgets\PieChartWidget;

class EnergyDistributionChart extends PieChartWidget
{
    protected static ?string $heading = 'Energy Status Distribution';

    public ?string $filter = 'all';
    protected static ?string $pollingInterval = '30s';


    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            'last' => 'Last Time',
        ];
    }
    protected function getData(): array
    {
        $ranges = [
            'excellent' => ['label' => 'Excellent 😊 (0–2)',  'min' => 0,  'max' => 2,  'color' => 'rgba(16,185,129,0.4)'],
            'good'      => ['label' => 'Good 🙂 (3–5)',       'min' => 3,  'max' => 5,  'color' => 'rgba(59,130,246,0.4)'],
            'moderate'  => ['label' => 'Moderate 😐 (6–9)',   'min' => 6,  'max' => 9,  'color' => 'rgba(251,191,36,0.4)'],
            'poor'      => ['label' => 'Poor 😒 (10–13)',     'min' => 10, 'max' => 13, 'color' => 'rgba(249,115,22,0.4)'],
            'critical'  => ['label' => 'Critical 😔 (14–16)','min' => 14, 'max' => 16, 'color' => 'rgba(239,68,68,0.4)'],
        ];

        $counts = EnergyTest::getDistribution($ranges, $this->filter === 'last')->first();

        $labels = array_column($ranges, 'label');
        $data = array_map(fn($rangeKey) => (int)($counts->{$rangeKey} ?? 0), array_keys($ranges));
        $bgColors = array_column($ranges, 'color');

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => $this->filter === 'last' ? 'Staff Count (Last Time)' : 'Staff Count (All Time)',
                    'data' => $data,
                    'backgroundColor' => $bgColors,
                ],
            ],
        ];
    }
}
