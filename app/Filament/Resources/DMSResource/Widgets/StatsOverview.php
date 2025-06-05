<?php

namespace App\Filament\Resources\DMSResource\Widgets;

use App\Models\DMS;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    protected function getCards(): array
    {
        $counts = DMS::getDocumentCounts();

        return [
            Card::make('Live', $counts->live_count ?? 0)
                ->description('Live documents in the system')
                ->icon('heroicon-s-document-text'),

            Card::make('Under Review', $counts->under_review_count ?? 0)
                ->description('Documents currently under review')
                ->icon('heroicon-s-clock'),

            Card::make('Archived', $counts->archived_count ?? 0)
                ->description('Obsolete or archived documents')
                ->icon('heroicon-s-archive'),
        ];
    }

}
