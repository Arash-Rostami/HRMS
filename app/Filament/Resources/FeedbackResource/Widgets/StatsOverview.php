<?php

namespace App\Filament\Resources\FeedbackResource\Widgets;

use App\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Usefulness', Feedback::getAvg('usefulness')),
            Card::make('Length', Feedback::getAvg('length')),
            Card::make('Staff Info.', Feedback::getAvg('staff_insight')),
            Card::make('Product Info.', Feedback::getAvg('product_insight')),
            Card::make('Payroll Info.', Feedback::getAvg('info_insight')),
            Card::make('IT Info.', Feedback::getAvg('it_insight')),
            Card::make('Staff Inter.', Feedback::getAvg('interaction')),
            Card::make('Culture', Feedback::getAvg('culture')),
            Card::make('Meeting', Feedback::getAvg('experience')),
            Card::make('Recommendation', Feedback::getAvg('recommendation')),
        ];
    }
}
