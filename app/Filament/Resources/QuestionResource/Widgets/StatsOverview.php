<?php

namespace App\Filament\Resources\QuestionResource\Widgets;

use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Active Qs', Question::where('active', 1)->count())
                ->icon('heroicon-s-check-circle'),

            Card::make('Inactive Qs',  Question::where('active', 0)->count())
                ->icon('heroicon-s-ban')
        ];
    }
}
