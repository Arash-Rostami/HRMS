<?php

namespace App\Filament\Resources\SpotResource\Pages;

use App\Filament\Resources\SpotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSpots extends ManageRecords
{
    protected static string $resource = SpotResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
