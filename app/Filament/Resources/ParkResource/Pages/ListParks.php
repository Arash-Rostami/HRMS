<?php

namespace App\Filament\Resources\ParkResource\Pages;

use App\Filament\Resources\ParkResource;
use App\Filament\Resources\ParkResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParks extends ListRecords
{
    protected static string $resource = ParkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
