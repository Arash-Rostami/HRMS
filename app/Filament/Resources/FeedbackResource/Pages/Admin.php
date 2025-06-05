<?php

namespace App\Filament\Resources\FeedbackResource\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
            ->tooltip(fn(Model $record) => "given on {$record->created_at}");
    }

    /**
     * @return TextColumn
     */
    public static function showUsefulnessRating(): TextColumn
    {
        $admin = self::class;
        return TextColumn::make('usefulness')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->usefulness);
            })
            ->tooltip(fn(Model $record) => $record->usefulness)
            ->formatStateUsing(fn(Model $record) => str_repeat("★", $record->usefulness) . str_repeat("☆", 5 - $record->usefulness));
    }

    /**
     * @return TextColumn
     */
    public static function showLengthRating(): TextColumn
    {
        return TextColumn::make('length')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->length);
            })
            ->tooltip(fn(Model $record) => $record->length)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->length) . str_repeat("☆", 5 - $record->length));
    }

    /**
     * @return TextColumn
     */
    public static function showStaffInsightRating(): TextColumn
    {
        return TextColumn::make('staff_insight')
            ->label('Staff Info')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->staff_insight);
            })
            ->tooltip(fn(Model $record) => $record->staff_insight)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->staff_insight) . str_repeat("☆", 5 - $record->staff_insight));
    }

    /**
     * @return TextColumn
     */
    public static function showProductInsightRating(): TextColumn
    {
        return TextColumn::make('product_insight')
            ->label('Product Info')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->product_insight);
            })
            ->tooltip(fn(Model $record) => $record->product_insight)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->product_insight) . str_repeat("☆", 5 - $record->product_insight));
    }

    /**
     * @return TextColumn
     */
    public static function showInfoInsightRating(): TextColumn
    {
        return TextColumn::make('info_insight')
            ->label('Payroll Info')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->info_insight);
            })
            ->tooltip(fn(Model $record) => $record->info_insight)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->info_insight) . str_repeat("☆", 5 - $record->info_insight));
    }

    /**
     * @return TextColumn
     */
    public static function showItInsightRating(): TextColumn
    {
        return TextColumn::make('it_insight')
            ->label('IT Info')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->it_insight);
            })
            ->tooltip(fn(Model $record) => $record->it_insight)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->it_insight) . str_repeat("☆", 5 - $record->it_insight));
    }

    /**
     * @return TextColumn
     */
    public static function showInteractionRating(): TextColumn
    {
        return TextColumn::make('interaction')
            ->label('Staff Inter.')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->interaction);
            })
            ->tooltip(fn(Model $record) => $record->interaction)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->interaction) . str_repeat("☆", 5 - $record->interaction));
    }

    /**
     * @return TextColumn
     */
    public static function showCultureRating(): TextColumn
    {
        return TextColumn::make('culture')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->color(function (Model $record) {
                return self::colorRating($record->culture);
            })
            ->tooltip(fn(Model $record) => $record->culture)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->culture) . str_repeat("☆", 5 - $record->culture));
    }

    /**
     * @return TextColumn
     */
    public static function showMeetingRating(): TextColumn
    {
        return TextColumn::make('experience')
            ->label('Meeting')
            ->searchable()
            ->size('sm')
            ->html()
            ->color(function (Model $record) {
                return self::colorRating($record->experience);
            })
            ->tooltip(fn(Model $record) => $record->experience)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->experience) . str_repeat("☆", 5 - $record->experience));
    }

    /**
     * @return TextColumn
     */
    public static function showRecommendationRating(): TextColumn
    {
        return TextColumn::make('recommendation')
            ->searchable()
            ->size('sm')
            ->html()
            ->color(function (Model $record) {
                return self::colorRating($record->recommendation);
            })
            ->tooltip(fn(Model $record) => $record->recommendation)
            ->getStateUsing(fn(Model $record) => str_repeat("★", $record->recommendation) . str_repeat("☆", 5 - $record->recommendation));
    }

    /**
     * @return TextColumn
     */
    public static function showMostFav(): TextColumn
    {
        return TextColumn::make('most_fav')
            ->label('Most Fav')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->most_fav, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->most_fav)));
    }


    /**
     * @return TextColumn
     */
    public static function showLeastFav(): TextColumn
    {
        return TextColumn::make('least_fav')
            ->label('Least Fav.')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->least_fav, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->least_fav)));
    }

    /**
     * @return TextColumn
     */
    public static function showAddition(): TextColumn
    {
        return TextColumn::make('addition')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->addition, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->addition)));
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
    public static function viewLeastFav(): MarkdownEditor
    {
        return MarkdownEditor::make('least_fav')
            ->label('The least fav.');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewMostFav(): MarkdownEditor
    {
        return MarkdownEditor::make('most_fav')
            ->label('The most fav.');

    }

    /**
     * @return MarkdownEditor
     */
    public static function viewAddition(): MarkdownEditor
    {
        return MarkdownEditor::make('addition');
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
    public static function viewUsefulness(): TextInput
    {
        return TextInput::make('usefulness')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->usefulness) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewLength(): TextInput
    {
        return TextInput::make('length')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->length) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewStaff(): TextInput
    {
        return TextInput::make('staff_insight')
            ->label('Staff Info.')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->staff_insight) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewProduct(): TextInput
    {
        return TextInput::make('product_insight')
            ->label('Product Info.')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->product_insight) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewInfo(): TextInput
    {
        return TextInput::make('info_insight')
            ->label('Payroll Info.')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->info_insight) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewIt(): TextInput
    {
        return TextInput::make('it_insight')
            ->label('IT Info.')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->it_insight) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewInteraction(): TextInput
    {
        return TextInput::make('interaction')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->interaction) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewCulture(): TextInput
    {
        return TextInput::make('culture')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->culture) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewExperience(): TextInput
    {
        return TextInput::make('experience')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->experience) . " ★";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewRecommendation(): TextInput
    {
        return TextInput::make('recommendation')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->recommendation) . " ★";
            });
    }
}
