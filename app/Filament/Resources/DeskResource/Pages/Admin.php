<?php


namespace App\Filament\Resources\DeskResource\Pages;


use App\Filament\Resources\DashboardResource\Model as DeskModel;
use App\Models\Seat;
use App\Models\User;
use App\Services\Date;
use Carbon\Carbon;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin
{
    public static function fetch(array $data): array
    {
        $model = new DeskModel($data);
        $data['start_date'] = $model->setStartDate();
        $data['start_hour'] = $model->setStartHour();
        $data['end_date'] = $model->setEndDate();
        $data['end_hour'] = $model->setEndHour();
        $data['seat_id'] = $data['number'];

        return $data;
    }

    /**
     * @return Select
     */
    public static function getNumber(): Select
    {
        return Select::make('number')
            ->disabled(fn(Page $livewire) => $livewire instanceof EditDesk)
            ->label('Seat number')
            ->options(Seat::all()->pluck('number', 'id'))
            ->required(fn(Page $livewire) => $livewire instanceof CreateDesk)
            ->rules([Rule::validateNumber()]);
    }

    /**
     * @return Select
     */
    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->disabled(fn(Page $livewire) => $livewire instanceof EditDesk)
            ->label('Reserver')
            ->options(
                DB::table('users')
                    ->select("*", DB::raw("CONCAT(users.surname,', ',users.forename) AS fullName"))
                    ->orderBy('surname')
                    ->where('status', 'active')
                    ->pluck('fullName', 'id'))
            ->required(fn(Page $livewire) => $livewire instanceof CreateDesk)
            ->rules([Rule::validateUser()]);
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
            ->default(Date::getFarsiDay());
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
     * @return TimePicker
     */
    public static function getStartTime(): TimePicker
    {
        return TimePicker::make('start_hour')
            ->displayFormat('H:i')
            ->withoutSeconds()
            ->default(Date::getFarsiTime());
    }

    /**
     * @return TimePicker
     */
    public static function getEndTime(): TimePicker
    {
        return TimePicker::make('end_hour')
            ->displayFormat('H:i')
            ->withoutSeconds()
            ->default(Date::getFarsiTime());
    }

    /**
     * @return Radio
     */
    public static function getState(): Radio
    {
        return Radio::make('state')->options([
            'active' => 'Active',
            'inactive' => 'Inactive',
        ])->rules([Rule::validateState()])
            ->default('active')
            ->columns(2);
    }


    /**
     * @return TextColumn
     */
    public static function showSeat(): TextColumn
    {
        return TextColumn::make('seat.number')
            ->sortable(['id'])
            ->searchable()
            ->toggleable()
            ->label('Seat number')
            ->tooltip(fn(Model $record): string => "created on {$record->created_at}");
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
    public static function showStartHour(): BadgeColumn
    {
        return BadgeColumn::make('start_hour')
            ->sortable()
            ->toggleable()
            ->formatStateUsing(fn(string $state) => ($state == '00:00:00') ? 'not selected' : $state);
    }

    /**
     * @return BadgeColumn
     */
    public static function showEndHour(): BadgeColumn
    {
        return BadgeColumn::make('end_hour')
            ->sortable()
            ->toggleable()
            ->formatStateUsing(fn(string $state): string => ($state == '00:00:00') ? 'not selected' : $state);
    }

    /**
     * @return BadgeColumn
     */
    public static function showState(): BadgeColumn
    {
        return BadgeColumn::make('state')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->colors(['danger' => 'inactive', 'success' => 'active'])
            ->formatStateUsing(function (string $state, Model $record) {
                return ($record->soft_delete === 'true') ? "$state + cancelled" : $state;
            });
    }

    /**
     * @return TextColumn
     */
    public static function showUser(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->toggleable()
            ->sortable(['forename'])
            ->searchable(['forename', 'surname'])
            ->label('Reserver');
    }
}
