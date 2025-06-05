<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    /**
     * @param $record
     * @return string
     */
    public static function colorRating($record): string
    {
        if ($record >= 4) {
            return 'success';
        } elseif ($record <= 2) {
            return 'danger';
        }
        return 'warning';
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterDays()
    {
        return SelectFilter::make('days')
            ->options([
                '30' => 'After 30',
                '60' => 'After 60',
                '90' => 'After 90',
            ]);
    }

    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterPeriod(): Filter
    {
        return Filter::make('created_at')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            });
    }

    /**
     * @return TextColumn
     */
    public static function showName(): TextColumn
    {
        return TextColumn::make('user.fullName')
            ->sortable()
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->tooltip(fn(Model $record) => "created on {$record->created_at}");
    }

    /**
     * @return BadgeColumn
     */
    public static function showDays(): BadgeColumn
    {
        return BadgeColumn::make('days')
            ->colors([
                'danger' => '30',
                'warning' => '60',
                'success' => '90',
            ])
            ->sortable()
            ->searchable()
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showResouceRating(): TextColumn
    {
        return TextColumn::make('resource')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->resource);
            })
            ->tooltip(fn(Model $record) => $record->resource)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->resource) . str_repeat("☆", 5 - $record->resource));
    }

    /**
     * @return TextColumn
     */
    public static function showTeamRating(): TextColumn
    {
        return TextColumn::make('team')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->team);
            })
            ->tooltip(fn(Model $record) => $record->team)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->team) . str_repeat("☆", 5 - $record->team));
    }

    /**
     * @return TextColumn
     */
    public static function showManagerRating(): TextColumn
    {
        return TextColumn::make('manager')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->manager);
            })
            ->tooltip(fn(Model $record) => $record->manager)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->manager) . str_repeat("☆", 5 - $record->manager));
    }

    /**
     * @return TextColumn
     */
    public static function showCultureRating(): TextColumn
    {
        return TextColumn::make('company')
            ->label('Culture')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->company);
            })
            ->tooltip(fn(Model $record) => $record->company)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->company) . str_repeat("☆", 5 - $record->company));
    }

    /**
     * @return TextColumn
     */
    public static function showSatisfactionRating(): TextColumn
    {
        return TextColumn::make('join')
            ->label('Satisfaction')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->join);
            })
            ->tooltip(fn(Model $record) => $record->join)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->join) . str_repeat("☆", 5 - $record->join));
    }

    /**
     * @return TextColumn
     */
    public static function showHelpfulnessRating(): TextColumn
    {
        return TextColumn::make('newcomer')
            ->label('Helpfulness')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->newcomer);

            })
            ->tooltip(fn(Model $record) => $record->newcomer)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->newcomer) . str_repeat("☆", 5 - $record->newcomer));
    }

    /**
     * @return TextColumn
     */
    public static function showBuddyRating(): TextColumn
    {
        return TextColumn::make('buddy')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->buddy);
            })
            ->tooltip(fn(Model $record) => $record->buddy)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->buddy) . str_repeat("☆", 5 - $record->buddy));
    }

    /**
     * @return TextColumn
     */
    public static function showRoleOfBuddy(): TextColumn
    {
        return TextColumn::make('role')
            ->label('Role of Bud.')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->role, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->role)));
    }

    /**
     * @return TextColumn
     */
    public static function showChallengeAchievement(): TextColumn
    {
        return TextColumn::make('challenge')
            ->label('Chall & Achiev.')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->challenge, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->challenge)));
    }

    /**
     * @return TextColumn
     */
    public static function showStage(): TextColumn
    {
        return TextColumn::make('stage')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->stage, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->stage)));
    }

    /**
     * @return TextColumn
     */
    public static function showImprovement(): TextColumn
    {
        return TextColumn::make('improvement')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->improvement, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->improvement)));
    }

    /**
     * @return TextColumn
     */
    public static function showSuggestion(): TextColumn
    {
        return TextColumn::make('suggestion')
            ->label('Final Suggestion')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->suggestion, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->suggestion)));
    }


    /**
     * @return MarkdownEditor
     */
    public static function viewRole(): MarkdownEditor
    {
        return MarkdownEditor::make('role')
            ->label('Roles of Buddy');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewChallenge(): MarkdownEditor
    {
        return MarkdownEditor::make('challenge')
            ->label('Challenges & Achievements');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewStage(): MarkdownEditor
    {
        return MarkdownEditor::make('stage');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewImprovement(): MarkdownEditor
    {
        return MarkdownEditor::make('improvement');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewSuggestion(): MarkdownEditor
    {
        return MarkdownEditor::make('suggestion');
    }

    /**
     * @return TextInput
     */
    public static function viewDays(): TextInput
    {
        return TextInput::make('days');
    }

    /**
     * @return TextInput
     */
    public static function viewResource(): TextInput
    {
        return TextInput::make('resource')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->resource) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewTeam(): TextInput
    {
        return TextInput::make('team')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->team) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewManager(): TextInput
    {
        return TextInput::make('manager')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->manager) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewSatisfaction(): TextInput
    {
        return TextInput::make('join')
            ->label('Satisfaction')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->join) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewHelpfulness(): TextInput
    {
        return TextInput::make('newcomer')
            ->label('Helpfulness')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->newcomer) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewBuddy(): TextInput
    {
        return TextInput::make('buddy')
            ->label('Buddy')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->buddy) . " ★";
            });
    }

}
