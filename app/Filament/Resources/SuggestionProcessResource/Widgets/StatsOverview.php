<?php

namespace App\Filament\Resources\SuggestionProcessResource\Widgets;

use App\Models\Review;
use App\Models\Suggestion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use phpDocumentor\Reflection\Types\False_;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Accepted | Rejected | Reviewed',
                self::giveDecisionStats())
                ->description('Final CEO decisions')
                ->descriptionIcon('heroicon-o-check-circle'),
            Card::make('Aborted | Self-filled | Attachment',
                self::giveSuggestionStats())
                ->description('Suggester actions')
                ->descriptionIcon('heroicon-o-clipboard-check'),
            Card::make('Pending | Closed',
                self::giveProcessStats())
                ->description('Process evaluation')
                ->descriptionIcon('heroicon-o-trending-down'),
            Card::make('Departments | Management',
                self::giveReviewStats())
                ->description('Total reviews submitted')
                ->descriptionIcon('heroicon-o-users')
        ];

    }

    public static function giveDecisionStats()
    {
        return Suggestion::countStage('accepted') . ' -- ' . Suggestion::countStage('rejected') . ' -- ' . Suggestion::countStage('under_review');
    }

    public static function giveProcessStats()
    {
        return Suggestion::countPending() . ' -- ' . Suggestion::countClosed();
    }

    public static function giveReviewStats()
    {
        return Review::countNonMA() . ' -- ' . Review::countMA();
    }

    public static function giveSuggestionStats()
    {
        return Suggestion::countAborted() . ' -- ' . Suggestion::countSelfFilled() . ' -- ' . Suggestion::countAttachment();
    }
}
