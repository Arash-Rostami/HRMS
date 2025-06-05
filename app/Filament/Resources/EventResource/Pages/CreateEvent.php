<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Services\Date;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $persianDate = $data['year'] . '-' . makeDoubleDigit($data['month']) . '-' . makeDoubleDigit($data['day']);

        $data['date'] = Date::convertIntoLatin($persianDate);

        return $data;
    }
}
