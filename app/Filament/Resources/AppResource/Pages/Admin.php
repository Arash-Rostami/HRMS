<?php

namespace App\Filament\Resources\AppResource\Pages;

use App\Models\App;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;


class Admin
{
    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterByAppName(): SelectFilter
    {
        return SelectFilter::make('app_name')
            ->label('App Name')
            ->multiple()
            ->options(fn() => App::query()
                ->distinct()
                ->orderBy('app_name')
                ->pluck('app_name', 'app_name')
            )
            ->searchable();
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterByUser(): SelectFilter
    {
        return SelectFilter::make('user_id')
            ->label('User')
            ->multiple()
            ->options(function () {
                return User::query()
                    ->where('status', 'active')
                    ->where('forename', 'not like', 'guest%')
                    ->where('surname', 'not like', 'guest%')
                    ->orderBy('forename')
                    ->orderBy('surname')
                    ->get()
                    ->pluck('full_name', 'id');
            })
            ->searchable();
    }

    public static function getAppName()
    {
        return TextInput::make('app_name')
            ->label('App Name')
            ->required();
    }

    /**
     * @return TextInput
     */
    public static function getLink(): TextInput
    {
        return TextInput::make('link')
            ->label('Link')
            ->columnSpanFull()
            ->url()
            ->nullable();
    }

    /**
     * @return Textarea
     */
    public static function getNote(): Textarea
    {
        return Textarea::make('note')
            ->label('Note')
            ->hint('⚠️')
            ->placeholder('In Farsi only')
            ->columnSpanFull()
            ->nullable();
    }

    /**
     * @return TextInput
     */
    public static function getPassword(): TextInput
    {
        return TextInput::make('password')
            ->label('Password')
            ->required()
            ->password()
            ->suffix(fn() => new HtmlString('<span class="whitespace-nowrap text-gray-400"><button type="button" onclick="(function(b){const i=b.closest(\'.filament-forms-text-input-component\').querySelector(\'input\');const p=i.type===\'password\';i.type=p?\'text\':\'password\';b.textContent=p?\'Hide\':\'Show\'})(this)">Show</button></span>'));
    }

    /**
     * @return Select
     */
    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->label('User')
            ->relationship('user', 'full_name', function ($query) {
                return $query
                    ->where('forename', 'not like', 'guest%')
                    ->where('status', 'active')
                    ->orderBy('forename')
                    ->orderBy('surname');
            })
            ->searchable(['forename', 'surname'])
            ->getOptionLabelFromRecordUsing(fn($record) => $record->full_name)
            ->required();
    }

    /**
     * @return TextInput
     */
    public static function getUserName(): TextInput
    {
        return TextInput::make('username')
            ->label('Username')
            ->required();
    }

    /**
     * @return TextColumn
     */
    public static function showAppName(): TextColumn
    {
        return TextColumn::make('app_name')
            ->label('App Name')
            ->sortable()
            ->searchable()
            ->wrap();
    }

    /**
     * @return TextColumn
     */
    public static function showLink(): TextColumn
    {
        return TextColumn::make('link')
            ->label('Link')
            ->url(fn($record) => $record->link)
            ->openUrlInNewTab()
            ->wrap();
    }

    /**
     * @return TextColumn
     */
    public static function showNote(): TextColumn
    {
        return TextColumn::make('note')
            ->label('Note')
            ->placeholder('In Farsi ONLY')
            ->limit(50)
            ->wrap();
    }

    /**
     * @return TextColumn
     */
    public static function showUser(): TextColumn
    {
        return TextColumn::make('user.fullname')
            ->label('Name')
            ->sortable(['forename'])
            ->searchable(['forename', 'surname'])
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showUserName(): TextColumn
    {
        return TextColumn::make('username')
            ->label('Username')
            ->sortable()
            ->searchable();
    }
}
