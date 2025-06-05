<?php

namespace App\Filament\Resources\DeskResource\Pages;

use App\Filament\Resources\DashboardResource\Model;
use App\Filament\Resources\DeskResource;
use Filament\Resources\Pages\EditRecord;

class EditDesk extends EditRecord
{
    protected static string $resource = DeskResource::class;

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
