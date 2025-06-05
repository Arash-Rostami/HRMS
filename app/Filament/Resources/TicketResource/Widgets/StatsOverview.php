<?php

namespace App\Filament\Resources\TicketResource\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $stats = Ticket::getStatistics();

        return [
            Card::make('Open', $stats->open_count ?? 0)
                ->description('Currently open and active tickets')
                ->icon('heroicon-s-document-text')
                ->color('danger'),

            Card::make('In Progress', $stats->in_progress_count ?? 0)
                ->description('Tickets currently being reviewed or worked on')
                ->icon('heroicon-s-clock')
                ->color('warning'),

            Card::make('Closed', $stats->closed_count ?? 0)
                ->description('Tickets that have been resolved and closed')
                ->icon('heroicon-s-check-circle')
                ->color('success'),

            Card::make('High Priority', $stats->high_priority_count ?? 0)
                ->description('Open tickets marked with high priority')
                ->icon('heroicon-s-exclamation-circle')
                ->color('danger'),

            Card::make('Satisfaction Score', $stats->average_satisfaction_score ?? 0)
                ->description('Average satisfaction score for resolved tickets')
                ->icon('heroicon-s-thumb-up')
                ->color('secondary'),

            Card::make('Average Effectiveness', $stats->average_effectiveness_score ?? 0)
                ->description('Average effectiveness score for actions')
                ->icon('heroicon-s-trending-up')
                ->color('secondary'),

            Card::make('Overdue Tickets', $stats->overdue_count ?? 0)
                ->description('Tickets completed beyond the specified deadline')
                ->icon('heroicon-s-calendar')
                ->color('secondary'),

            Card::make('Request Types', ($stats->support_count . ' -- ' . $stats->access_count) ?? 0)
                ->description('Support | Access')
                ->icon('heroicon-s-chart-pie')
                ->color('secondary'),
        ];
    }
}
