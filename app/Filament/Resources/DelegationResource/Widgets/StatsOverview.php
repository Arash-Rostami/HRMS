<?php

namespace App\Filament\Resources\DelegationResource\Widgets;

use App\Models\Delegation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $dutyCounts = Delegation::getDutyCounts();
        $impactScoreStats = Delegation::getImpactScoreStats();
        $monthlyRepeatStats = Delegation::getMonthlyRepeatStats();

        return [
            Card::make('Impact Score (VH, H,  M,  L)', $impactScoreStats),
            Card::make('Managers\' duty - Subordinates\' duty Total', "{$dutyCounts['sub_duty']} - {$dutyCounts['duty']}"),
            Card::make('Monthly Repeat (4+, 1~4, 1-)', $monthlyRepeatStats),
        ];
    }
}
