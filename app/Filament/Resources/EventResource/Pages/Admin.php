<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    /**
     * @return Textarea
     */
    public static function getTitle(): Textarea
    {
        return Textarea::make('title')
            ->placeholder('In English only *')
            ->required();
    }

    /**
     * @return Textarea
     */
    public static function getDescription(): Textarea
    {
        return Textarea::make('description')
            ->placeholder('In English only *');
    }

    /**
     * @param array $days
     * @return Select
     */
    public static function getDay(array $days): Select
    {
        return Select::make('day')
            ->label('Day')
            ->options($days)
            ->required();
    }

    /**
     * @param array $months
     * @return Select
     */
    public static function getMonth(array $months): Select
    {
        return Select::make('month')
            ->label('Month')
            ->options($months)
            ->required();
    }

    /**
     * @param array $years
     * @return Select
     */
    public static function getYear(array $years): Select
    {
        return Select::make('year')
            ->label('Year')
            ->options($years)
            ->required();
    }


    /**
     * @return TextColumn
     */
    public static function showTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showDescription(): TextColumn
    {
        return TextColumn::make('description')
            ->searchable()
            ->toggleable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(strip_tags(html_entity_decode($record->description)), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->description)));
    }

    /**
     * @return BadgeColumn
     */
    public static function showDate(): BadgeColumn
    {
        return BadgeColumn::make('date')
            ->sortable()
            ->date()
            ->toggleable()
            ->searchable();
    }

}
