<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParkResource\Pages;
use App\Filament\Resources\ParkResource\Pages\Admin;
use App\Filament\Resources\ParkResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Models\Park;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ParkResource extends Resource
{
    protected static ?string $model = Park::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Reservation Panel';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Admin::getNumber(),
                        Admin::getUser(),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        Admin::getStartYear(),
                        Admin::getStartMonth(),
                        Admin::getStartDay(),
                        Admin::getEndYear(),
                        Admin::getEndMonth(),
                        Admin::getEndDay(),
                    ])->columns(3),
                Card::make()
                    ->schema([
                        Admin::getStartTime(),
                        Admin::getEndTime()
                    ])->columns(2),
                Admin::getState()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Admin::showSpot(),
            Admin::showStartDate(),
            Admin::showEndDate(),
            Admin::showStartHour(),
            Admin::showEndHour(),
            Admin::showState(),
            Admin::showUser(),
        ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->poll('10s')
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
            'index' => Pages\ListParks::route('/'),
            'create' => Pages\CreatePark::route('/create'),
            'edit' => Pages\EditPark::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
