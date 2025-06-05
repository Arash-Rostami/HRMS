<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserChartResource\Widgets\UserChart;
use App\Filament\Resources\UserChartResource\Widgets\UserPie;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\StatusOverview;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;


    protected function mutateFormDataBeforeFill(array $data)
    {
        return !((auth()->user()->email == 'arashrostami@time-gr.com'));
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            StatusOverview::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatusOverview::class,
        ];
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }

}
