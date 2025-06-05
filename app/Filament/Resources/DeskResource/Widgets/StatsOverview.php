<?php

namespace App\Filament\Resources\DeskResource\Widgets;

use App\Models\Desk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total reservations', Desk::countAll()),
            Card::make('Active reservations', Desk::countActive()),
            Card::make('Reservations deactivated', Desk::countInactive()),
            Card::make('Reservations cancelled', Desk::countDeleted()),
        ];
    }
}
