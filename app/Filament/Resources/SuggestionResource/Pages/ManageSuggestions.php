<?php

namespace App\Filament\Resources\SuggestionResource\Pages;

use App\Filament\Resources\SuggestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables\Filters\Layout;

class ManageSuggestions extends ManageRecords
{
    protected static string $resource = SuggestionResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 5;
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }
}
