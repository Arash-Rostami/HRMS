<?php


namespace App\Filament\Resources\UserResource\Pages;


use App\Models\Desk;
use App\Models\Park;
use App\Services\Date;
use App\Services\Statistics;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Admin
{

    /**
     * @throws \Exception
     */
    public static function deleteUser(): DeleteAction
    {
        return
            DeleteAction::make()->action(function (Model $record) {
                $record->status = 'inactive';
                $record->save();
            })->requiresConfirmation();
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBooking(): SelectFilter
    {
        return SelectFilter::make('booking')
            ->options([
                'all' => 'Both',
                'parking' => 'Parking',
                'office' => 'Office',
            ]);
    }

    public static function filterType(): SelectFilter
    {
        return SelectFilter::make('type')
            ->label('Type')
            ->options([
                'employee' => 'Employee',
                'VIP' => 'VIP',
                'guest' => 'Guest',
            ])
            ->placeholder('All Types');
    }

    public static function filterPresence(): SelectFilter
    {
        return SelectFilter::make('presence')
            ->label('Presence')
            ->options([
                'onsite' => 'On-site',
                'off-site' => 'Off-site',
                'on-leave' => 'On-leave',
            ])
            ->placeholder('All Presence');
    }


    public static function filterStatus(): SelectFilter
    {
        return SelectFilter::make('status')
            ->label('Status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
                'pending' => 'Pending',
            ])
            ->placeholder('All Statuses');
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
                return $query->when(
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
     * @return TextInput
     */
    public static function getForename(): TextInput
    {
        return TextInput::make('forename')->required()
            ->rules([Rule::validateName()])
            ->placeholder('type in English');
    }

    /**
     * @return TextInput
     */
    public static function getSurname(): TextInput
    {
        return TextInput::make('surname')->required()
            ->rules([Rule::validateName()])
            ->placeholder('type in English');
    }

    /**
     * @return TextInput
     */
    public static function getEmail(): TextInput
    {
        return TextInput::make('email')
            ->email()
            ->unique(ignoreRecord: true)
            ->required()
            ->rules([Rule::validateEmail()])
            ->placeholder('end with @persolco.com or @persoreco.com or @bazorg.com');
    }


    /**
     * @return RichEditor
     */
    public static function getDetails(): RichEditor
    {
        return RichEditor::make('details')
            ->toolbarButtons([
                'bold',
                'bulletList',
                'h2',
                'h3',
                'italic',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ]);
    }

    /**
     * @return TextInput
     */
    public static function getPassword(): TextInput
    {
        return TextInput::make('password')
            ->visibleOn('create')
            ->password()
            ->required()
            ->rules([Rule::validatePassword()]);
    }

    /**
     * @return TextInput
     */
    public static function getConfirmationPassword(): TextInput
    {
        return TextInput::make('password_confirmation')
            ->visibleOn('create')
            ->password()
            ->same('password')
            ->required()
            ->placeholder('re-type password');
    }

    /**
     * @return Radio
     */
    public static function getType(): Radio
    {
        return Radio::make('type')
            ->options([
                'guest' => 'Guest',
                'employee' => 'Employee',
                'VIP' => 'VIP',
            ])->columns(3)
            ->required();
    }

    /**
     * @return Select
     */
    public static function getLimit(): Select
    {
        return Select::make('maximum')
            ->label('Limit')
            ->required()
            ->options(array_combine(range(1, 31), range(1, 31)));
    }

    /**
     * @return Radio
     */
    public static function getRole(): Radio
    {
        return Radio::make('role')
            ->options([
                'user' => 'User',
                'admin' => 'Admin',
                'developer' => 'Developer',
            ])->columns(3)
            ->default('user')
            ->hidden(!(auth()->user()->role == 'developer'));
    }

    /**
     * @return Radio
     */
    public static function getStatus(): Radio
    {
        return Radio::make('status')->options([
            'active' => 'Active',
            'suspended' => 'Suspended',
            'inactive' => 'Deleted',
        ])->columns(3)
            ->required();
    }

    /**
     * @return Radio
     */
    public static function getBooking(): Radio
    {
        return Radio::make('booking')->options([
            'office' => 'Office',
            'parking' => 'Parking',
            'all' => 'All',
        ])->columns(3)
            ->required();
    }


    /**
     * @return TextColumn
     */
    public static function showForename(): TextColumn
    {
        return TextColumn::make('forename')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showSurname(): TextColumn
    {
        return TextColumn::make('surname')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showEmail(): TextColumn
    {
        return TextColumn::make('email')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->tooltip(fn(Model $record): string => "created on {$record->created_at}");
    }


    /**
     * @return TextColumn
     */
    public static function showDetails(): TextColumn
    {
        return TextColumn::make('details')
            ->searchable()
            ->size('sm')
            ->color('primary')
            ->toggleable()
            ->html()
            ->getStateUsing(fn(Model $record) => substr($record->details, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->details)));
    }

    /**
     * @return IconColumn
     */
    public static function showType(): IconColumn
    {
        return IconColumn::make('type')
            ->sortable()
            ->options(['heroicon-o-user'])
            ->colors([
                'text-gray-500' => 'employee',
                'warning' => 'guest',
                'danger' => 'VIP',
            ])
            ->toggleable()
            ->searchable()
            ->tooltip(fn(Model $record): string => " {$record->type}");
    }

    /**
     * @return BadgeColumn
     */
    public static function showLimit(): BadgeColumn
    {
        return BadgeColumn::make('maximum')
            ->label('Limit')
            ->sortable()
            ->toggleable()
            ->colors(['secondary']);
    }

    /**
     * @return TextColumn
     */
    public static function showRoles(): TextColumn
    {
        return TextColumn::make('role')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showStatus(): BadgeColumn
    {
        return BadgeColumn::make('status')->sortable()
            ->colors([
                'warning' => 'suspended',
                'danger' => 'inactive',
                'success' => 'active',
            ])
            ->toggleable()
            ->searchable();

    }

    /**
     * @return TextColumn
     */
    public static function showBooking(): TextColumn
    {
        return TextColumn::make('booking')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showTotalBooking(): BadgeColumn
    {
        return BadgeColumn::make('Yearly total')
            ->colors(['text-gray-500'])
            ->formatStateUsing(function (Model $record) {
                $desk = Statistics::countReservations(Desk::class, $record->id);
                $park = Statistics::countReservations(Park::class, $record->id);
                return "parks: {$park} desks: {$desk}";
            })
            ->toggleable()
            ->tooltip(fn() => 'in ' . Date::getFarsiYear());
    }
}
