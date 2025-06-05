<?php

namespace App\Filament\Resources\CancellationResource\Pages;

use App\Filament\Resources\CancellationResource\Pages\Rule;
use App\Filament\Resources\DashboardResource\Model as CancellationModel;
use App\Models\Desk;
use App\Models\Park;
use App\Models\Seat;
use App\Models\Spot;
use App\Models\User;
use App\Services\Date;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Admin
{

    public static function fetch(array $data): array
    {
        $data['start_hour'] = '00:00';
        $data['end_hour'] = '23:59';

        $model = new CancellationModel($data);

        $data['start_date'] = $model->setStartDate();
        $data['end_date'] = $model->setEndDate();

        return $data;
    }


    /**
     * @return Select
     */
    public static function getType(): Select
    {
        return Select::make('booking')
            ->disabled(fn(Page $livewire) => $livewire instanceof EditCancellation)
            ->label('Type')
            ->options([
                'office' => 'Office',
                'parking' => 'Parking',
            ])
            ->reactive()
            ->afterStateUpdated(fn(callable $set, $state) => $set('booking', $state))
            ->required(fn(Page $livewire) => $livewire instanceof CreateCancellation);
    }


    /**
     * @return Select
     */
    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->disabled(fn(Page $livewire) => $livewire instanceof EditCancellation)
            ->label('Reserver')
            ->options(function (callable $get, Park $park, Desk $desk) {
                return ($get('booking') == 'parking')
                    ? $park->showCurrentParkUsers()
                    : $desk->showCurrentDeskUsers();
            })
            ->reactive()
            ->afterStateUpdated(fn(callable $set, $state) => $set('user', $state))
            ->required(fn(Page $livewire) => $livewire instanceof CreateCancellation);
    }

    /**
     * @return Select
     */
    public static function getNumber(): Select
    {
        return Select::make('number')
            ->disabled(fn(Page $livewire, callable $get) => $livewire instanceof EditCancellation)
            ->default(fn(callable $get) => $get('number'))
            ->label('Number')
            ->options(function (callable $get, Park $park, Desk $desk) {
                return ($get('booking') == 'parking')
                    ? $park->showCurrentParkNumbers($get('user'))
                    : $desk->showCurrentDeskNumbers($get('user'));
            })
            ->required(fn(Page $livewire) => $livewire instanceof CreateCancellation)
            ->rules([Rule::validateNumber()]);

    }

    /**
     * @return Select
     */
    public static function getStartYear(): Select
    {
        return Select::make('start_year')
            ->label('Start year')
            ->required()
            ->options([
                (Date::getFarsiYear() - 1) => (Date::getFarsiYear() - 1),
                Date::getFarsiYear() => Date::getFarsiYear(),
                (Date::getFarsiYear() + 1) => (Date::getFarsiYear() + 1),
            ])
            ->default(Date::getFarsiYear());
    }

    /**
     * @return Select
     */
    public static function getStartMonth(): Select
    {
        return Select::make('start_month')
            ->label('Start month')
            ->required()
            ->options(array_combine(range(1, 12), range(1, 12)))
            ->default(Date::getFarsiMonth());
    }

    /**
     * @return Select
     */
    public static function getStartDay(): Select
    {
        return Select::make('start_day')
            ->required()
            ->label('Start day')
            ->options(array_combine(range(1, 31), range(1, 31)))
            ->default(Date::getFarsiDay())
            ->rules([Rule::validateStartDay()]);
    }

    /**
     * @return Select
     */
    public static function getEndYear(): Select
    {
        return Select::make('end_year')
            ->label('End year')
            ->required()
            ->options([
                (Date::getFarsiYear() - 1) => (Date::getFarsiYear() - 1),
                Date::getFarsiYear() => Date::getFarsiYear(),
                (Date::getFarsiYear() + 1) => (Date::getFarsiYear() + 1),
            ])
            ->default(Date::getFarsiYear())
            ->rules([Rule::validateYear()]);
    }

    /**
     * @return Select
     */
    public static function getEndMonth(): Select
    {
        return Select::make('end_month')
            ->label('End month')
            ->required()
            ->options(array_combine(range(1, 12), range(01, 12)))
            ->default(Date::getFarsiMonth())
            ->rules([Rule::validateMonth()]);
    }

    /**
     * @return Select
     */
    public static function getEndDay(): Select
    {
        return Select::make('end_day')
            ->label('End date')
            ->required()
            ->options(array_combine(range(1, 31), range(1, 31)))
            ->default(Date::getFarsiDay())
            ->rules([Rule::validateDay()]);
    }


    /**
     * @return TextColumn
     */
    public static function showSpotNumber(): TextColumn
    {
        return TextColumn::make('spot.number')
            ->sortable(['id'])
            ->searchable()
            ->toggleable()
            ->label('Parking #')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->booking === 'parking') ? $state : 'N/A';
            })
            ->tooltip(fn(Model $record): string => ($record->booking === 'parking') ? "created on {$record->created_at}" : '');
    }

    /**
     * @return TextColumn
     */
    public static function showSeatNumber(): TextColumn
    {
        return TextColumn::make('seat.number')
            ->sortable(['id'])
            ->searchable()
            ->toggleable()
            ->label('Office #')
            ->formatStateUsing(function ($state, Model $record) {
                return ($record->booking === 'office') ? $state : 'N/A';
            })
            ->tooltip(fn(Model $record): string => ($record->booking === 'office') ? "created on {$record->created_at}" : '');
    }


    /**
     * @return TextColumn
     */
    public static function showStartDate(): TextColumn
    {
        return TextColumn::make('start_date')
            ->label('Start date')
            ->sortable()
            ->toggleable()
            ->formatStateUsing(function (string $state) {
                return explode(' ', Date::convertTimeStamp($state))[0];
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showEndDate(): BadgeColumn
    {
        return BadgeColumn::make('end_date')
            ->label('End date')
            ->sortable()
            ->toggleable()
            ->colors(['text-gray-600'])
            ->formatStateUsing(function (string $state) {
                return explode(' ', Date::convertTimeStamp($state))[0];
            });
    }


    /**
     * @return BadgeColumn
     */
    public static function showEdit(): BadgeColumn
    {
        return BadgeColumn::make('edit')
            ->label('Edited')
            ->sortable()
            ->toggleable()
            ->colors(['danger' => 0, 'success' => 1])
            ->formatStateUsing(function (string $state, Model $record) {
                return $state = ($record->soft_delete == 1) ? 'on' : 'off';
            });
    }

    /**
     * @return TextColumn
     */
    public static function showUser(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->sortable(['forename'])
            ->toggleable()
            ->searchable(['forename', 'surname'])
            ->label('Reserver');
    }
}
