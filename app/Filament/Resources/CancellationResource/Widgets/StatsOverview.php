<?php

namespace App\Filament\Resources\CancellationResource\Widgets;

use App\Models\Cancellation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total', Cancellation::countAll()),
            Card::make('Parking', Cancellation::countParking()),
            Card::make('Office', Cancellation::countDesks()),
        ];
    }
}
