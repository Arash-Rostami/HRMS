<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Desk;
use App\Models\Park;
use Filament\Widgets\BarChartWidget;

class ReservationPercentageChart extends BarChartWidget
{
    protected static ?string $heading = 'Reservations';

    public ?string $filter = 'null';

    /**
     * @return array
     */
    private function fetchStatistics(): array
    {
        $activeFilter = $this->filter;
        $activePark = Park::countActive($activeFilter);
        $activeDesk = Desk::countActive($activeFilter);
        $inactivePark = Park::countInactive($activeFilter);
        $inactiveDesk = Desk::countInactive($activeFilter);
        $deletedPark = Park::countDeleted($activeFilter);
        $deletedDesk = Desk::countDeleted($activeFilter);

        return [$activePark, $activeDesk, $inactivePark, $inactiveDesk, $deletedPark, $deletedDesk];
    }

    protected function getFilters(): ?array
    {
        return [
            'null' => 'Total',
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'This month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        list($activePark, $activeDesk, $inactivePark, $inactiveDesk, $deletedPark, $deletedDesk) = $this->fetchStatistics();

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [
                        ($activePark + $activeDesk),
                        ($inactivePark + $inactiveDesk),
                        ($deletedPark + $deletedDesk),
                    ],
                    'backgroundColor' =>
                        [
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                        ],
                ],
                [
                    'label' => 'Park',
                    'data' => [
                        $activePark,
                        $inactivePark,
                        $deletedPark
                    ],
                    'backgroundColor' =>
                        [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                ],
                [
                    'label' => 'Office',
                    'data' => [
                        $activeDesk,
                        $inactiveDesk,
                        $deletedDesk
                    ],
                    'backgroundColor' =>
                        [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                ],
            ],
            'labels' => ['Reserved', 'Cancelled by Admin', 'Cancelled by User'],
        ];
    }
}
