<?php

namespace App\Filament\Resources\ParkResource\Pages;

use App\Filament\Resources\ParkResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePark extends CreateRecord
{
    protected static string $resource = ParkResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Admin::fetch($data);
    }
}
