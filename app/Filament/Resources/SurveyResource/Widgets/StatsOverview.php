<?php

namespace App\Filament\Resources\SurveyResource\Widgets;

use App\Models\Survey;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Resource', Survey::getAvg('resource')),
            Card::make('Team', Survey::getAvg('team')),
            Card::make('Manager', Survey::getAvg('manager')),
            Card::make('Culture', Survey::getAvg('company')),
            Card::make('Satisfaction', Survey::getAvgJoin()),
            Card::make('Helpfulness', Survey::getAvg('newcomer')),
            Card::make('Buddy', Survey::getAvg('buddy')),
        ];
    }
}
