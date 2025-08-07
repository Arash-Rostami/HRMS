<?php

namespace App\Filament\Resources\EnergyTestResource\Widgets;

use App\Models\EnergyTest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Morilog\Jalali\Jalalian;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $stats = $this->compileStats();
        $colorMap = fn($avg) => $avg <= 7 ? 'success' : ($avg >= 12 ? 'danger' : 'warning');

        return [
            Card::make("Bad Mood ({$stats['persianMonthName']})", $stats['criticalCount'])
                ->description("Tests with score > 10 in {$stats['monthName']}")
                ->descriptionIcon('heroicon-s-emoji-sad')
                ->color($stats['criticalCount'] > 0 ? 'danger' : 'success'),

            Card::make("Good Mood ({$stats['persianMonthName']})", $stats['goodMoodCount'])
                ->description("Tests with score < 6 in {$stats['monthName']}")
                ->descriptionIcon('heroicon-s-emoji-happy')
                ->color('success'),

            Card::make("Monthly Average ({$stats['persianMonthName']})", number_format($stats['avgForMonth'], 2))
                ->description("Average score in {$stats['monthName']}")
                ->descriptionIcon('heroicon-s-calendar')
                ->color($colorMap($stats['avgForMonth'])),

            Card::make('Overall Average', number_format($stats['avgOverall'], 2))
                ->description('Average of all employee scores')
                ->descriptionIcon('heroicon-s-sparkles')
                ->color($colorMap($stats['avgOverall'])),

            Card::make('Average Mind Score', number_format($stats['avgMind'], 2))
                ->description('Focus & Clarity Average')
                ->descriptionIcon('heroicon-s-light-bulb'),

            Card::make('Average Emotion Score', number_format($stats['avgEmotion'], 2))
                ->description('Emotional Balance Average')
                ->descriptionIcon('heroicon-s-heart'),

            Card::make('Average Physique Score', number_format($stats['avgPhysique'], 2))
                ->description('Physical Vitality Average')
                ->descriptionIcon('heroicon-s-user'),

            Card::make('Average Soul Score', number_format($stats['avgSoul'], 2))
                ->description('Purpose & Fulfillment Average')
                ->descriptionIcon('heroicon-s-star'),
        ];
    }

    private function compileStats(): array
    {
        $targetDate = Jalalian::fromCarbon(now())->getDay() >= 24 ? now() : now()->subMonth();
        $monthRange = [$targetDate->copy()->startOfMonth(), $targetDate->copy()->endOfMonth()];

        $gregorianMonthName = $targetDate->format('F');
        $persianMonthName = Jalalian::fromCarbon($targetDate)->format('%B');

        $monthlyQuery = EnergyTest::whereBetween('completed_at', $monthRange);

        return [
            'monthName'        => $gregorianMonthName,
            'persianMonthName' => $persianMonthName,
            'criticalCount'    => $monthlyQuery->clone()->where('overall_score', '>', 10)->count(),
            'goodMoodCount'    => $monthlyQuery->clone()->where('overall_score', '<', 6)->count(),
            'avgForMonth'      => $monthlyQuery->clone()->avg('overall_score'),
            'avgOverall'       => EnergyTest::query()->avg('overall_score'),
            'avgMind'          => EnergyTest::query()->avg('mind_score'),
            'avgEmotion'       => EnergyTest::query()->avg('emotion_score'),
            'avgPhysique'      => EnergyTest::query()->avg('physique_score'),
            'avgSoul'          => EnergyTest::query()->avg('soul_score'),
        ];
    }
}
