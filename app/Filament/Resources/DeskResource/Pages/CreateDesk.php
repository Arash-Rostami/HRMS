<?php

namespace App\Filament\Resources\DeskResource\Pages;

use App\Filament\Resources\DeskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDesk extends CreateRecord
{
    protected static string $resource = DeskResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Admin::fetch($data);
    }
}
