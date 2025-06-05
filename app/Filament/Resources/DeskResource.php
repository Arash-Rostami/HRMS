<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeskResource\Pages;
use App\Filament\Resources\DeskResource\Pages\Admin;
use App\Filament\Resources\DeskResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Models\Desk;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DeskResource extends Resource
{
    protected static ?string $model = Desk::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Reservation Panel';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Admin::getNumber(),
                        Admin::getUser()])
                    ->columns(2),
                Card::make()
                    ->schema([
                        Admin::getStartYear(),
                        Admin::getStartMonth(),
                        Admin::getStartDay(),
                        Admin::getEndYear(),
                        Admin::getEndMonth(),
                        Admin::getEndDay()
                    ])
                    ->columns(3),
                Card::make()
                    ->schema([
                        Admin::getStartTime(),
                        Admin::getEndTime(),
                    ])
                    ->columns(2),
                Admin::getState(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Admin::showSeat(),
            Admin::showStartDate(),
            Admin::showEndDate(),
            Admin::showStartHour(),
            Admin::showEndHour(),
            Admin::showState(),
            Admin::showUser()
        ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesks::route('/'),
            'create' => Pages\CreateDesk::route('/create'),
            'edit' => Pages\EditDesk::route('/{record}/edit'),
        ];
    }
}
