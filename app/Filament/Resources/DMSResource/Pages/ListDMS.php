<?php

namespace App\Filament\Resources\DMSResource\Pages;

use App\Filament\Resources\DMSResource;
use App\Filament\Resources\DMSResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListDMS extends ListRecords
{
    protected static string $resource = DMSResource::class;

    protected static ?string $label = 'DMS';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Document'),
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

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [20, 40, 60];
    }
}
