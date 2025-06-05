<?php

namespace App\Filament\Resources\JobResource\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    /**
     * @return RichEditor
     */
    public static function getPosition(): RichEditor
    {
        return RichEditor::make('position')
            ->required()
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return RichEditor
     */
    public static function getCertificate(): RichEditor
    {
        return RichEditor::make('certificate')
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return RichEditor
     */
    public static function getSkill(): RichEditor
    {
        return RichEditor::make('skill')
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return RichEditor
     */
    public static function getExperience(): RichEditor
    {
        return RichEditor::make('experience')
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return RichEditor
     */
    public static function getLink(): RichEditor
    {
        return RichEditor::make('link')
            ->required()
            ->disableAllToolbarButtons();
    }

    /**
     * @return Select
     */
    public static function getGender(): Select
    {
        return Select::make('gender')
            ->required()
            ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                'Any' => 'Any',
            ]);
    }

    /**
     * @return Toggle
     */
    public static function getActivation(): Toggle
    {
        return Toggle::make('active')
            ->required()
            ->onIcon('heroicon-s-lightning-bolt')
            ->offIcon('heroicon-s-lightning-bolt');
    }

    /**
     * @return TextColumn
     */
    public static function showPosition(): TextColumn
    {
        return TextColumn::make('position')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => mb_substr(strip_tags(html_entity_decode($record->position)), 0, 50) . (mb_strlen($record->position) > 50 ? '...' : ''))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->position)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'] ;
            });
    }

    /**
     * @return TextColumn
     */
    public static function showCertificate(): TextColumn
    {
        return TextColumn::make('certificate')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => mb_substr(strip_tags(html_entity_decode($record->certificate)), 0, 50) . (mb_strlen($record->certificate) > 50 ? '...' : ''))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->certificate)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'] ;
            });
    }

    /**
     * @return TextColumn
     */
    public static function showSkill(): TextColumn
    {
        return TextColumn::make('skill')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => mb_substr(strip_tags(html_entity_decode($record->skill)), 0, 50) . (mb_strlen($record->skill) > 50 ? '...' : ''))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->skill)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'] ;
            });
    }

    /**
     * @return TextColumn
     */
    public static function showExperience(): TextColumn
    {
        return TextColumn::make('experience')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => mb_substr(strip_tags(html_entity_decode($record->experience)), 0, 50) . (mb_strlen($record->experience) > 50 ? '...' : ''))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->experience)))
            ->extraAttributes(function (Model $record) {
                return  ['style' => 'direction:rtl'] ;
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showGender(): BadgeColumn
    {
        return BadgeColumn::make('gender')
            ->colors([
                'warning' => 'Male',
                'success' => 'Any',
                'danger' => 'Female',
            ])
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return ToggleColumn
     */
    public static function showActivation(): ToggleColumn
    {
        return ToggleColumn::make('active')
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return TextColumn
     */
    public static function showLink(): TextColumn
    {
        return TextColumn::make('link')
            ->getStateUsing(fn(Model $record) => mb_substr(strip_tags(html_entity_decode($record->link)), 0, 50) . (mb_strlen($record->link) > 50 ? '...' : ''))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->link)));
    }

}
