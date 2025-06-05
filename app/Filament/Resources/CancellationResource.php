<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CancellationResource\Pages;
use App\Filament\Resources\CancellationResource\RelationManagers;
use App\Filament\Resources\CancellationResource\Pages\Admin;
use App\Models\Cancellation;
use App\Services\Date;
use App\Models\Spot;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CancellationResource extends Resource
{
    protected static ?string $model = Cancellation::class;

    protected static ?string $navigationIcon = 'heroicon-s-minus-circle';

    protected static ?string $navigationGroup = 'Reservation Panel';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::getType(),
                    Admin::getUser(),
                    Admin::getNumber(),
                ])->columns(3),
                Card::make()->schema([
                    Admin::getStartYear(),
                    Admin::getStartMonth(),
                    Admin::getStartDay(),
                    Admin::getEndYear(),
                    Admin::getEndMonth(),
                    Admin::getEndDay(),
                ])->columns(3),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showSpotNumber(),
                Admin::showSeatNumber(),
                Admin::showStartDate(),
                Admin::showEndDate(),
                Admin::showEdit(),
                Admin::showUser(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
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
            'index' => Pages\ListCancellations::route('/'),
            'create' => Pages\CreateCancellation::route('/create'),
            'edit' => Pages\EditCancellation::route('/{record}/edit'),
        ];
    }


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
