<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstantMessageResource\Pages;
use App\Filament\Resources\InstantMessageResource\Pages\Admin;
use App\Filament\Resources\InstantMessageResource\RelationManagers;
use App\Models\InstantMessage;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class InstantMessageResource extends Resource
{
    protected static ?string $model = InstantMessage::class;

    protected static ?string $navigationIcon = 'heroicon-s-chat';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $navigationGroup = 'User Panel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::viewSender(),
                    Admin::viewRecipient(),
                    Admin::viewTopic(),
                ])->columns(3),
                Card::make()->schema([
                    Admin::viewContent(),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showNameOfSender(),
                Admin::showNameOfRecipient(),
                Admin::showTopic(),
                Admin::showContent()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Admin::filterPeriod()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstantMessages::route('/'),
        ];
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
