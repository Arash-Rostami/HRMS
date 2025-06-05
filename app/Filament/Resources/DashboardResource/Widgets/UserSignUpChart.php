<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\User;
use App\Services\Date;
use Filament\Widgets\LineChartWidget;

class UserSignUpChart extends LineChartWidget
{
    protected static ?string $heading = 'Signups';


    private function fetchStatistics(): array
    {
        $data = User::showInMonth()->toArray();
        $months = array_keys($data);
        $totalUsers = array_values($data);

        return array($months, $totalUsers);
    }

    protected function getData(): array
    {
        list($months, $totalUsers) = $this->fetchStatistics();
        return [
            'datasets' => [
                [
                    'label' => 'Users signing up in each month of ' . Date::getFarsiYear(),
                    'data' => $totalUsers,
                    'borderColor' => ['rgb(75, 192, 192)'],
                    'backgroundColor' => ['rgb(75, 192, 192,0.5)'],
                    'tension' => 1.0,
                    'fill' => true,

                ],
            ],
            // to convert latin month to persian one
            'labels' => array_map(fn($v) => ($v >= 3 && $v <= 12) ? $v - 2 : $v + 10, $months),
        ];
    }
}

