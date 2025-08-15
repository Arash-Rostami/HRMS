<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoResource\Pages\Admin;
use App\Filament\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    protected static ?string $navigationLabel = 'Gallery';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::getEventDate(),
                    Admin::getDepartment(),
                    Admin::getTitle(),
                    Admin::getDescription(),
                    Admin::getImagePath(),
                ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhoto::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [ ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showImage(),
                Admin::showImageCount(),
                Admin::showTitle(),
                Admin::showDepartment(),
                Admin::showDescription(),
                Admin::showEventDate(),
                Admin::showTimeStamp(),
            ])
            ->filters(Admin::showFilters())
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('event_date', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
            ]);
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
