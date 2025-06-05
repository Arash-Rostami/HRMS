<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageResponses extends ManageRecords
{
    protected static string $resource = ResponseResource::class;

    protected function getActions(): array
    {
        return [];
    }


}
