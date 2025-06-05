<?php

namespace App\Filament\Resources\LinkResource\Widgets;

use App\Models\Link;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('External links', Link::countExternals())->color('danger'),
            Card::make('Internal links', Link::countInternals())->color('success'),
            Card::make('Double links', Link::countDoubleLinks()),
        ];
    }
}
