<?php

namespace App\Filament\Resources\ParkResource\Pages;

use App\Filament\Resources\DashboardResource\Model;
use App\Filament\Resources\ParkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPark extends EditRecord
{
    protected static string $resource = ParkResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $model = new Model($data);

        $data['start_year'] = $model->getStartYear();
        $data['start_month'] = $model->getStartMonth();
        $data['start_day'] = $model->getStartDay();
        $data['end_year'] = $model->getEndYear();
        $data['end_month'] = $model->getEndMonth();
        $data['end_day'] = $model->getEndDay();

        return $data;
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Admin::fetch($data);
    }
}
