<?php

namespace App\Filament\Resources\ParkResource\Widgets;

use App\Models\Park;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total reservations', Park::countAll()),
            Card::make('Active reservations', Park::countActive()),
            Card::make('Reservations deactivated', Park::countInactive()),
            Card::make('Reservations cancelled', Park::countDeleted()),
        ];
    }
}
