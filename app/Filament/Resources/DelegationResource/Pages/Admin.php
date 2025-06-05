<?php

namespace App\Filament\Resources\DelegationResource\Pages;

use App\Models\User;
use App\Services\DepartmentDetails;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class Admin
{


    /**
     * @return Select
     */
    public static function getDepartment(): Select
    {
        return Select::make('dept')
            ->label('Department')
            ->options(DepartmentDetails::getDepartmentsArray())
            ->required()
            ->rule('in:' . implode(',', array_keys(DepartmentDetails::$departments)));
    }

    /**
     * @return Select
     */
    public static function getPersonResponsible(): Select
    {
        return Select::make('user_id')
            ->label('Responsible Person')
            ->options(User::getActiveNonGuestUsers())
            ->rules('required', 'exists:users,id');

    }

    /**
     * @return Toggle|string|null
     */
    public static function getSubDuty(): Toggle
    {
        return Toggle::make('sub_duty')
            ->label('Is related to subordinates?')
            ->rules('boolean');
    }

    /**
     * @return Textarea
     */
    public static function getDuty(): Textarea
    {
        return Textarea::make('details.duty')
            ->label('Duty Description')
            ->placeholder('***شرح وظیفه به فارسی نوشته شود***')
            ->extraAttributes(['style' => 'direction:rtl'])
            ->columnSpanFull()
            ->required();

    }

    /**
     * @return Select
     */
    public static function getExecutionProcedure(): Select
    {
        return Select::make('details.execution_procedure')
            ->label('Execution Procedure')
            ->options(['yes' => 'Yes', 'no' => 'No', 'pending' => 'In approval process'])
            ->rule('in:yes,no,pending');

    }

    /**
     * @return Select
     */
    public static function getRepeatFrequency(): Select
    {
        return Select::make('details.repeat_frequency')
            ->label('Repeat Frequency')
            ->options([
                'yearly' => '1 time a year',
                'biyearly' => '2 times a year',
                '5_times_a_year' => '5 times a year',
                'quarterly' => '4 times a year',
                'frequent' => 'More than 4 times a month',
                'regular' => '1 to 4 times a month',
                'occasional' => 'Less than 1 time a month'
            ]);
    }

    /**
     * @return Select
     */
    public static function getImpactScore(): Select
    {
        return Select::make('details.impact_score')
            ->label('Impact Score')
            ->options([
                'very_high' => 'Very High',
                'high' => 'High',
                'medium' => 'Medium',
                'low' => 'Low'
            ])
            ->rule('in:very_high,high,medium,low');

    }

    /**
     * @return Select
     */
    public static function getProposedDelegation(): Select
    {
        return Select::make('details.proposed_delegation')
            ->label('Proposed Delegation')
            ->options([
                'decision_implementation' => 'Decision Making and Implementation',
                'review_proposal' => 'Review and Proposal',
                'review_reporting' => 'Review and Reporting',
                'decision_reporting' => 'Decision Making and Reporting'
            ])
            ->rule('in:decision_implementation,review_proposal,review_reporting,decision_reporting');

    }

    /**
     * @return Select
     */
    public static function getApprovedDelegation(): Select
    {
        return Select::make('details.approved_delegation')
            ->label('Approved Delegation')
            ->options([
                'decision_implementation' => 'Decision Making and Implementation',
                'review_proposal' => 'Review and Proposal',
                'review_reporting' => 'Review and Reporting',
                'decision_reporting' => 'Decision Making and Reporting'
            ])
            ->required()
            ->rule('in:decision_implementation,review_proposal,review_reporting,decision_reporting');
    }

    /**
     * @return TextInput
     */
    public static function getCoDelegate(): TextInput
    {
        return TextInput::make('details.co_delegate')
            ->label('Co Delegate')
            ->placeholder(' به فارسی نوشته شود')
            ->extraAttributes(['style' => 'direction:rtl']);
    }

    /**
     * @return TextColumn
     */
    public static function showDepartment(): TextColumn
    {
        return BadgeColumn::make('dept')
            ->label('Department')
            ->searchable()
            ->color('text-primary-500')
            ->tooltip(function (TextColumn $column): ?string {
                $state = $column->getState();
                return DepartmentDetails::getDescription($state) ?: $state;
            });
    }

    /**
     * @return TextColumn
     */
    public static function showPersonResponsible(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->searchable(['forename', 'surname'])
            ->label('Responsible Person');
    }

    /**
     * @return TextColumn
     */
    public static function showDuty(): TextColumn
    {
        return TextColumn::make('details.duty')
            ->label('Duty Description')
            ->formatStateUsing(fn($state) => $state ?? 'N/A');
    }

    /**
     * @return ToggleColumn |string|null
     */
    public static function showSubDuty(): ToggleColumn
    {
        return ToggleColumn::make('sub_duty')
            ->label('Related to Subordinates');
    }

    /**
     * @return IconColumn
     */
    public static function showExecutionProcedure(): IconColumn
    {
        return IconColumn::make('details.execution_procedure')
            ->label('Execution Procedure')
            ->options([
                'heroicon-o-x-circle' => 'no',
                'heroicon-o-clock' => 'pending',
                'heroicon-o-check-circle' => 'yes',
            ])
            ->colors([
                'danger' => 'no',
                'warning' => 'pending',
                'success' => 'yes',
            ]);
    }

    /**
     * @return BadgeColumn
     */
    public static function showRepeatFrequency(): BadgeColumn
    {
        return BadgeColumn::make('details.repeat_frequency')
            ->label('Monthly Repeat Frequency')
            ->color('primary')
            ->formatStateUsing(function ($state) {
                return match ($state) {
                    'yearly' => 'یک بار در سال',
                    'biyearly' => 'دو بار در سال',
                    'quarterly' => 'فصلی',
                    '5_times_a_year' => 'پنج بار در سال',
                    'frequent' => 'بیشتر از 4 بار',
                    'regular' => 'بین 1 تا 4 بار',
                    'occasional' => 'کمتر از یکبار',
                    default => 'N/A',
                };
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showImpactScore(): BadgeColumn
    {
        return BadgeColumn::make('details.impact_score')
            ->label('Impact Score')
            ->colors([
                'danger' => 'very_high',
                'warning' => 'high',
                'success' => 'medium',
                'text-gray-500' => 'low',
            ])
            ->formatStateUsing(function ($state) {
                return match ($state) {
                    'very_high' => 'خیلی زیاد',
                    'high' => 'زیاد',
                    'medium' => 'متوسط',
                    'low' => 'کم',
                    default => 'N/A',
                };
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showProposedDelegation(): BadgeColumn
    {
        return BadgeColumn::make('details.proposed_delegation')
            ->label('Proposed Delegation')
            ->color('text-gray-500')
            ->formatStateUsing(function ($state) {
                return match ($state) {
                    'decision_implementation' => 'تصمیم گیری و اجرا',
                    'review_proposal' => 'بررسی و پیشنهاد',
                    'review_reporting' => 'بررسی و گزارش',
                    'decision_reporting' => 'تصمیم گیری و گزارش',
                    default => 'N/A',
                };
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showApprovedDelegation(): BadgeColumn
    {
        return BadgeColumn::make('details.approved_delegation')
            ->label('Approved Delegation')
            ->color('text-gray-500')
            ->formatStateUsing(function ($state) {
                return match ($state) {
                    'decision_implementation' => 'تصمیم گیری و اجرا',
                    'review_proposal' => 'بررسی و پیشنهاد',
                    'review_reporting' => 'بررسی و گزارش',
                    'decision_reporting' => 'تصمیم گیری و گزارش',
                    default => 'N/A',
                };
            });
    }

    /**
     * @return TextColumn
     */
    public static function howCoDelegate(): TextColumn
    {
        return BadgeColumn::make('details.co_delegate')
            ->label('Co-Delegate')
            ->color('text-gray-500')
            ->formatStateUsing(fn($state) => $state ?? 'N/A');
    }


    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnDepartment(): SelectFilter
    {
        return SelectFilter::make('dept')
            ->options(function () {
                $options = [];
                foreach (array_keys(DepartmentDetails::$departments) as $code) {
                    $options[$code] = DepartmentDetails::getName($code);
                }
                asort($options);

                return $options;
            });
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnSubDuty(): SelectFilter
    {
        return SelectFilter::make('sub_duty')
            ->label('Subordinate Duty')
            ->options([
                '1' => 'Yes',
                '0' => 'No',
            ]);
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnExecutionProcedure(): SelectFilter
    {
        return SelectFilter::make('details->execution_procedure')
            ->label('Execution Procedure')
            ->options([
                'yes' => 'Yes',
                'no' => 'No',
                'pending' => 'In approval process',
            ]);
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnRepeatFrequency(): SelectFilter
    {
        return SelectFilter::make('details->repeat_frequency')
            ->label('Repeat Frequency')
            ->options([
                'yearly' => '1 time a year',
                'biyearly' => '2 times a year',
                'quarterly' => '4 times a year',
                '5_times_a_year' => '5 times a year',
                'frequent' => 'More than 4 times a month',
                'regular' => '1 to 4 times a month',
                'occasional' => 'Less than once a month'
            ]);
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnImpactScore(): SelectFilter
    {
        return SelectFilter::make('details->impact_score')
            ->label('Impact Score')
            ->options([
                'very_high' => 'Very High',
                'high' => 'High',
                'medium' => 'Medium',
                'low' => 'Low',
            ]);
    }
}
