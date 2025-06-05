<?php

namespace App\Filament\Resources\SuggestionResource\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;


class Admin
{

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterPresenter(): SelectFilter
    {
        return SelectFilter::make('presenter')
            ->options([
                '1' => 'One person',
                '2' => 'More than one',
            ]);
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterScope(): SelectFilter
    {
        return SelectFilter::make('scope')
            ->options([
                '1' => 'For a few',
                '2' => 'For everyone',
            ]);
    }

    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterName(): Filter
    {
        return Filter::make('name')
            ->form([
                TextInput::make('name'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['name'],
                        fn(Builder $query, $data): Builder => $query->where('name', 'LIKE', '%' . $data . '%'),
                    );

            });
    }

    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterSuggestion(): Filter
    {
        return Filter::make('suggestion')
            ->form([
                TextInput::make('suggestion'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['suggestion'],
                        fn(Builder $query, $data): Builder => $query->where('suggestion', 'LIKE', '%' . $data . '%'),
                    );

            });
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


    public static function showName()
    {
        return TextColumn::make('name')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->tooltip(fn(Model $record): string => "created on {$record->created_at}");
    }


    public static function showTable()
    {
        return TextColumn::make('title')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return IconColumn
     */
    public static function showPresenter(): IconColumn
    {
        return IconColumn::make('presenter')
            ->sortable()
            ->searchable()
            ->options(['heroicon-o-user'])
            ->colors([
                'text-gray-500' => 1,
                'warning' => 2,
            ])
            ->toggleable()
            ->tooltip(fn(Model $record) => $record->presenter == 1 ? 'One' : 'Group');
    }

    /**
     * @return IconColumn
     */
    public static function showScope(): IconColumn
    {
        return IconColumn::make('scope')
            ->sortable()
            ->searchable()
            ->options(['heroicon-o-users'])
            ->colors([
                'text-gray-500' => 1,
                'success' => 2,
            ])
            ->toggleable()
            ->tooltip(fn(Model $record) => $record->scope == 1 ? 'One person' : 'All staff');
    }


    public static function showSuggestion()
    {
        return TextColumn::make('suggestion')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->suggestion, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->suggestion)));
    }


    public static function showAdvantage()
    {
        return TextColumn::make('advantage')
            ->searchable()
            ->size('sm')
            ->color('success')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->advantage, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->advantage)));
    }


    public static function showMethod()
    {
        return TextColumn::make('method')
            ->searchable()
            ->size('sm')
            ->color('secondary')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->method, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->method)));
    }

    /**
     * @return BadgeColumn
     */
    public static function showEstimate(): BadgeColumn
    {
        return BadgeColumn::make('estimate')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->label('Estimate')
            ->colors(['secondary']);
    }


    public static function showPicture()
    {
        return ImageColumn::make('photo')
            ->disk('filament')
            ->extraImgAttributes(function (Model $record) {
                return [
                    'oncontextmenu' => 'showImage("' . $record->photo . '", "_blank")',
                    'class' => 'pointer',
                    'title' => 'Right click to enlarge'
                ];
            })->size(100)
            ->toggleable();
    }

    /**
     * @return TextInput
     */
    public static function viewName(): TextInput
    {
        return TextInput::make('name');
    }


    /**
     * @return TextInput
     */
    public static function viewTitle(): TextInput
    {
        return TextInput::make('title');
    }


    /**
     * @return TextInput
     */
    public static function viewScope(): TextInput
    {
        return TextInput::make('scope')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->scope == '1') ? 'For a few' : 'For everyone';
            });
    }

    /**
     * @return TextInput
     */
    public static function viewPresenter(): TextInput
    {
        return TextInput::make('presenter')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->presenter == '1') ? 'One Person' : 'More than one';
            });
    }

    /**
     * @return TextInput
     */
    public static function viewEstimate(): TextInput
    {
        return TextInput::make('estimate')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->estimate == '0') ? 'N/A' : $record->estimate;
            });
    }


    /**
     * @return MarkdownEditor
     */
    public static function viewSuggestion(): MarkdownEditor
    {
        return MarkdownEditor::make('suggestion');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewAdvantage(): MarkdownEditor
    {
        return MarkdownEditor::make('advantage');
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewMethod(): MarkdownEditor
    {
        return MarkdownEditor::make('method');
    }
}
