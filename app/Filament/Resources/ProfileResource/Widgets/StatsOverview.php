<?php

namespace App\Filament\Resources\ProfileResource\Widgets;

use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    public function getCards(): array
    {
        return [
            Card::make('Probation. | Working | Ended',
                $this->employmentStatusStats())
                ->description('Employment Status')
                ->descriptionIcon('heroicon-o-badge-check'),
            Card::make('Full- | Part- | Contractual',
                $this->employmentTypeStats())
                ->description('Employment Type')
                ->descriptionIcon('heroicon-s-clock'),
            Card::make('Female | Male',
                $this->genderDistributionStats())
                ->description('Gender Distribution')
                ->descriptionIcon('heroicon-s-users'),
            Card::make('Married | Single',
                $this->maritalStatusStats())
                ->description('Marital Status')
                ->descriptionIcon('heroicon-o-heart'),
        ];
    }

    private static function employmentStatusStats(): string
    {
        return Profile::countProbational() . ' -- ' . Profile::countWorking() . ' -- ' . Profile::countTerminated();
    }

    private static function employmentTypeStats(): string
    {
        return Profile::countFullTime() . ' -- ' . Profile::countPartTime() . ' -- ' . Profile::countContract();
    }

    private static function genderDistributionStats(): string
    {
        return Profile::countFemale() . ' -- ' . Profile::countMale();
    }

    private static function maritalStatusStats(): string
    {
        return Profile::countMarried() . ' -- ' . Profile::countSingle();
    }
}
