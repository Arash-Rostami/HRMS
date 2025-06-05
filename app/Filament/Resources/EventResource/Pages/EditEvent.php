<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Services\Date;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Morilog\Jalali\Jalalian;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
            if (isset($data['date'])) {
                $persianDate = Jalalian::fromCarbon(Carbon::parse($data['date']));
                $data["year"] = $persianDate->getYear();
                $data["month"] = $persianDate->getMonth();
                $data["day"] = $persianDate->getDay();
            }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $persianDate = $data['year'] . '-' . makeDoubleDigit($data['month']) . '-' . makeDoubleDigit($data['day']);

        $data['date'] = Date::convertIntoLatin($persianDate);

        return $data;
    }
}
