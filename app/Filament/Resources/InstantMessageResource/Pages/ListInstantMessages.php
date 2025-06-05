<?php

namespace App\Filament\Resources\InstantMessageResource\Pages;

use App\Filament\Resources\InstantMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstantMessages extends ListRecords
{
    protected static string $resource = InstantMessageResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
