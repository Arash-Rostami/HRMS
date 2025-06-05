<?php

namespace App\Filament\Resources\SuggestionProcessResource\Pages;

use App\Filament\Resources\SuggestionProcessResource;
use App\Filament\Resources\SuggestionProcessResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSuggestionProcesses extends ManageRecords
{
    protected static string $resource = SuggestionProcessResource::class;

    protected function getActions(): array
    {
        return [];
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
