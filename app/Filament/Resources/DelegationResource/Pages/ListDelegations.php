<?php

namespace App\Filament\Resources\DelegationResource\Pages;

use App\Filament\Resources\DelegationResource;
use App\Filament\Resources\DelegationResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDelegations extends ListRecords
{
    protected static string $resource = DelegationResource::class;

    protected static ?string $title = 'Authorities';


    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New authority'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
