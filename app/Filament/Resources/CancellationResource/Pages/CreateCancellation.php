<?php

namespace App\Filament\Resources\CancellationResource\Pages;

use App\Filament\Resources\CancellationResource;
use App\Filament\Resources\DashboardResource\Model as CancellationModel;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCancellation extends CreateRecord
{
    protected static string $resource = CancellationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Admin::fetch($data);
    }
}
