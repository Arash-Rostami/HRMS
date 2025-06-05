<?php

namespace App\Filament\Resources\CancellationResource\Pages;

use App\Filament\Resources\CancellationResource;
use App\Filament\Resources\DashboardResource\Model as CancellationModel;
use App\Models\Seat;
use App\Models\Spot;
use App\Services\Date;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCancellation extends EditRecord
{
    protected static string $resource = CancellationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Admin::fetch($data);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['start_date'])) {
            $jalaliStart = Date::convertTimestampToFarsi($data['start_date']);
            $data['start_year'] = $jalaliStart['year'];
            $data['start_month'] = $jalaliStart['month'];
            $data['start_day'] = $jalaliStart['day'];
        }

        if (isset($data['end_date'])) {
            $jalaliEnd = Date::convertTimestampToFarsi($data['end_date']);
            $data['end_year'] = $jalaliEnd['year'];
            $data['end_month'] = $jalaliEnd['month'];
            $data['end_day'] = $jalaliEnd['day'];
        }

        if (isset($data['booking'])) {
            if ($data['booking'] === 'parking') {
                $data['number'] = optional($this->record->spot)->number;
            } elseif ($data['booking'] === 'office') {
                $data['number'] = optional($this->record->seat)->number;
            }
        }

        return $data;
    }


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
