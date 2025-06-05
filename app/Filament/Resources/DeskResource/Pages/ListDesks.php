<?php

namespace App\Filament\Resources\DeskResource\Pages;

use App\Filament\Resources\DeskResource;
use App\Filament\Resources\DeskResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDesks extends ListRecords
{
    protected static string $resource = DeskResource::class;

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
