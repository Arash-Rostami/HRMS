<?php

namespace App\Filament\Resources\EnergyTestResource\Pages;

use App\Filament\Resources\EnergyTestResource;
use App\Filament\Resources\EnergyTestResource\Widgets\StatsOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListEnergyTests extends ListRecords
{
    protected static string $resource = EnergyTestResource::class;

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Admin::filterBasedOnUser(),
            Admin::filterBasedOnGregorianMonth(),
            Admin::filterBasedOnPersianMonth(),
            Admin::filterBasedOnCompletionDae(),
            Admin::filterBasedOnHighRisks(),
            Admin::filterBasedOnLowRisks(),
            Admin::filterBasedOnFeelingBetter(),
            Admin::filterBasedOnFeelingWorse(),
            Admin::filterBasedOnSignificantImprovement(),
            Admin::filterBasedOnSignificantDecline(),
            Admin::filterBasedOnWorseThanAverage(),
            Admin::filterBasedOnBetterThanAverage(),
        ];
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 4;
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::Popover;
    }
}
