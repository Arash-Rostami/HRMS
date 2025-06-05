<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatusOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $statistics = $this->makeData();
        return [
            Card::make('Total users', User::countAll()),
            Card::make('Active | Inactive | Suspended', $statistics),
            Card::make('Users of parking space', User::wantParking()),
            Card::make('Users of office space', User::wantOffice()),
        ];
    }

    /**
     * @return string
     */
    protected function makeData(): string
    {
        return User::countActive() . ' -- ' . User::countInactive() . ' -- ' . User::countSuspended();
    }
}
