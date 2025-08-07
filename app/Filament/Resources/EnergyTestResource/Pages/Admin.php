<?php

namespace App\Filament\Resources\EnergyTestResource\Pages;

use App\Models\EnergyTest;
use App\Models\User;
use App\Services\Date;
use Carbon\Carbon;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Admin
{
    /**
     * @return TextColumn
     */
    public static function showRespondent(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->label('Employee')
            ->searchable(
                true,
                query: function (Builder $query, string $search): Builder {
                    return $query->orWhereHas('user', function (Builder $q) use ($search) {
                        $q->where(DB::raw("CONCAT(forename, ' ', surname)"), 'like', "%{$search}%");
                    });
                }
            )->sortable(query: function (Builder $query, string $direction): Builder {
                return $query
                    ->join('users', 'energy_tests.user_id', '=', 'users.id')
                    ->orderBy(DB::raw("CONCAT(users.forename, ' ', users.surname)"), $direction)
                    ->select('energy_tests.*');
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showOverallScore(): BadgeColumn
    {
        return BadgeColumn::make('overall_score')
            ->label('Overall Energy')
            ->sortable()
            ->colors([
                'success' => static fn($state): bool => $state <= 8,
                'warning' => static fn($state): bool => $state > 8 && $state <= 11,
                'danger' => static fn($state): bool => $state > 12,
            ])
            ->tooltip('This is the sum of all category scores.');
    }

    /**
     * @return TextColumn
     */
    public static function showMindScore(): TextColumn
    {
        return TextColumn::make('mind_score')
            ->label('Mind')
            ->sortable()
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showEmotionScore(): TextColumn
    {
        return TextColumn::make('emotion_score')
            ->label('Emotion')
            ->sortable()
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showPhysiqueScore(): TextColumn
    {
        return TextColumn::make('physique_score')
            ->label('Physique')
            ->sortable()
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showSoulScore(): TextColumn
    {
        return TextColumn::make('soul_score')
            ->label('Soul')
            ->sortable()
            ->toggleable();
    }

    /**
     * @return IconColumn
     */
    public static function showCreatedAt(): IconColumn
    {
        return IconColumn::make('created_at')
            ->label('Recent')
            ->boolean()
            ->trueIcon('heroicon-o-check-circle')
            ->falseIcon('heroicon-o-clock')
            ->trueColor('success')
            ->falseColor('warning')
            ->tooltip(fn(EnergyTest $record): string => $record->completed_at->greaterThan(now()->subDays(25)) ? 'Completed recently' : 'Completed more than 25 days ago');
    }

    /**
     * @return TextColumn
     */
    public static function showCompletedAt(): TextColumn
    {
        return TextColumn::make('completed_at')
            ->label('Date Completed')
            ->formatStateUsing(fn(EnergyTest $record): string => toJalali($record->completed_at) . ' - ' . $record->completed_at->diffForHumans())
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * @return SelectFilter
     * @throws Exception
     */
    public static function filterBasedOnUser()
    {
        return SelectFilter::make('user_id')
            ->label('Filter by Employee')
            ->multiple()
            ->searchable()
            ->options(fn () => User::orderBy('forename')
                ->get()
                ->pluck('full_name', 'id')
                ->toArray()
            );
    }

    /**
     * @return SelectFilter
     * @throws Exception
     */
    public static function filterBasedOnGregorianMonth()
    {
        return SelectFilter::make('month')
            ->label('Filter by Gregorian Month')
            ->multiple()
            ->options(
                collect(range(1, 12))
                    ->mapWithKeys(fn($m) => [
                        $m => Carbon::create()->month($m)->format('F'),
                    ])
                    ->toArray()
            )
            ->query(function (Builder $query, array $data) {
                if (isset($data['values']) && is_array($data['values']) && !empty($data['values'])) {
                    return $query->whereIn(DB::raw('MONTH(completed_at)'), $data['values']);
                }
                return $query;
            });
    }

    /**
     * @return SelectFilter
     * @throws Exception
     */
    public static function filterBasedOnPersianMonth()
    {
        return SelectFilter::make('persian_month')
            ->label('Filter by Persian Month')
            ->multiple()
            ->options([
                1 => 'فروردین',
                2 => 'اردیبهشت',
                3 => 'خرداد',
                4 => 'تیر',
                5 => 'مرداد',
                6 => 'شهریور',
                7 => 'مهر',
                8 => 'آبان',
                9 => 'آذر',
                10 => 'دی',
                11 => 'بهمن',
                12 => 'اسفند',
            ])
            ->query(function (Builder $query, array $data) {
                if (isset($data['values']) && is_array($data['values']) && !empty($data['values'])) {
                    return $query->where(function ($q) use ($data) {
                        foreach ($data['values'] as $persianMonth) {
                            $q->orWhere(function ($subQuery) use ($persianMonth) {
                                $currentPersianYear = Date::getFarsiYear();

                                for ($year = $currentPersianYear - 1; $year <= $currentPersianYear + 1; $year++) {
                                    $monthDays = (new Jalalian($year, $persianMonth, 1))->getMonthDays();

                                    // Convert to Gregorian dates
                                    $startGregorian = CalendarUtils::toGregorian($year, $persianMonth, 1);
                                    $endGregorian = CalendarUtils::toGregorian($year, $persianMonth, $monthDays);

                                    $startDate = implode('-', $startGregorian) . ' 00:00:00';
                                    $endDate = implode('-', $endGregorian) . ' 23:59:59';

                                    $subQuery->orWhereBetween('completed_at', [$startDate, $endDate]);
                                }
                            });
                        }
                    });
                }
                return $query;
            });
    }

    /**
     * @return Filter
     * @throws Exception
     */
    public static function filterBasedOnCompletionDae()
    {
        return Filter::make('completed_at')
            ->form([
                DatePicker::make('completed_from')->label('Submitted From'),
                DatePicker::make('completed_until')->label('Submitted Until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['completed_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('completed_at', '>=', $date),
                    )
                    ->when(
                        $data['completed_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('completed_at', '<=', $date),
                    );
            });
    }

    /**
     * @return Filter
     * @throws Exception
     */
    public static function filterBasedOnHighRisks()
    {
        return Filter::make('high_risk_overall')
            ->toggle()
            ->label('😔 Overall Energy (> 10)')
            ->query(fn(Builder $query): Builder => $query->where('overall_score', '>', 10));
    }

    /**
     * @return Filter
     * @throws Exception
     */
    public static function filterBasedOnLowRisks()
    {
        return Filter::make('low_risk_overall')
            ->toggle()
            ->label('😊 Overall Energy (< 6)')
            ->query(fn(Builder $query): Builder => $query->where('overall_score', '<', 6));
    }

    public static function filterBasedOnFeelingWorse()
    {
        return Filter::make('feeling_worse')
            ->toggle()
            ->label('📉 Mood Worsened')
            ->query(function (Builder $query): Builder {
                return $query->whereRaw(
                    'overall_score > (SELECT overall_score FROM energy_tests as previous_tests WHERE previous_tests.user_id = energy_tests.user_id AND previous_tests.completed_at < energy_tests.completed_at ORDER BY completed_at DESC LIMIT 1)'
                );
            });
    }

    public static function filterBasedOnFeelingBetter()
    {
        return Filter::make('feeling_better')
            ->toggle()
            ->label('📈 Mood Improved')
            ->query(function (Builder $query): Builder {
                return $query->whereRaw(
                    'overall_score < (SELECT overall_score FROM energy_tests as previous_tests WHERE previous_tests.user_id = energy_tests.user_id AND previous_tests.completed_at < energy_tests.completed_at ORDER BY completed_at DESC LIMIT 1)'
                );
            });
    }

    public static function filterBasedOnSignificantDecline(): Filter
    {
        return Filter::make('significant_decline')
            ->label('📉 Dramatic  Decline (>4)')
            ->query(function (Builder $query): Builder {
                return $query->whereRaw(
                    'overall_score - (SELECT overall_score FROM energy_tests as previous_tests WHERE previous_tests.user_id = energy_tests.user_id AND previous_tests.completed_at < energy_tests.completed_at ORDER BY completed_at DESC LIMIT 1) > 4'
                );
            });
    }

    public static function filterBasedOnSignificantImprovement(): Filter
    {
        return Filter::make('significant_improvement')
            ->label('📈 Strong Rebound (>4)')
            ->query(function (Builder $query): Builder {
                return $query->whereRaw(
                    '(SELECT overall_score FROM energy_tests as previous_tests WHERE previous_tests.user_id = energy_tests.user_id AND previous_tests.completed_at < energy_tests.completed_at ORDER BY completed_at DESC LIMIT 1) - overall_score > 4'
                );
            });
    }

    public static function filterBasedOnWorseThanAverage(): Filter
    {
        return Filter::make('worse_than_average')
            ->label('🚨 Worse than Avg. (>3)')
            ->query(function (Builder $query): Builder {
                $companyAverage = EnergyTest::query()->avg('overall_score');

                if (is_null($companyAverage)) {
                    return $query->whereRaw('1=0');
                }

                return $query->where('overall_score', '>', $companyAverage + 3);
            });
    }

    public static function filterBasedOnBetterThanAverage(): Filter
    {
        return Filter::make('better_than_average')
            ->label('✅ Better than Avg. (>3)')
            ->query(function (Builder $query): Builder {
                $companyAverage = EnergyTest::query()->avg('overall_score');

                if (is_null($companyAverage)) {
                    return $query->whereRaw('1=0');
                }

                return $query->where('overall_score', '<', $companyAverage - 3);
            });
    }
}
