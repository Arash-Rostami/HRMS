<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\Admin;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'surname';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'User Panel';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::getForename(),
                    Admin::getSurname(),
                    Admin::getEmail(),
                    Admin::getDetails(),
                    Admin::getPassword(),
                    Admin::getConfirmationPassword(),
                ])->columns(1),
                Card::make()->schema([
                    Admin::getLimit(),
                    Admin::getType(),
                    Admin::getRole(),
                    Admin::getBooking(),
                    Admin::getStatus()
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showForename(),
                Admin::showSurname(),
                Admin::showEmail(),
                Admin::showDetails(),
                Admin::showType(),
                Admin::showLimit(),
                Admin::showRoles(),
                Admin::showStatus(),
                Admin::showBooking(),
                Admin::showTotalBooking(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s')
            ->filters([
                Admin::filterBooking(),
                Admin::filterType(),
                Admin::filterPresence(),
                Admin::filterStatus(),
                Admin::filterPeriod(),
            ])
            ->poll('10s')
            ->actions([
                EditAction::make(),
                Admin::deleteUser(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->surname . ', ' . $record->forename;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['forename', 'surname', 'email'];
    }


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
