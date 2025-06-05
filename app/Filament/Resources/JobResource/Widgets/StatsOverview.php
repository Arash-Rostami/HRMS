<?php

namespace App\Filament\Resources\JobResource\Widgets;

use App\Models\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('Active Jobs', Job::countActiveJobs()),
            Card::make('Inactive Jobs', Job::countInactiveJobs()),
            Card::make('Female | Male | Any', $this->getTotalStats()),
        ];
    }

    /**
     * @return string
     */
    private function getTotalStats(): string
    {
        return Job::countFemales() . '--' . Job::countMales() . '--' . Job::countBothGender();
    }
}
