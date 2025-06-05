<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DMSResource\Pages;
use App\Filament\Resources\DMSResource\Pages\Admin;
use App\Filament\Resources\DMSResource\RelationManagers;
use App\Models\DMS;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class DMSResource extends Resource
{
    protected static ?string $model = DMS::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationLabel = 'DMS';

    protected static ?string $label = 'Document Management Service';
    protected static ?string $pluralModelLabel = 'Document Management Service';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('File Details')
                    ->schema([
                        Admin::getTitle(),
                        Admin::getCode(),
                        Admin::getVersion(),
                        Admin::getStatus(),
                    ])->columns(2),

                Forms\Components\Section::make('File and Ownership')
                    ->schema([
                        Admin::getOwners(),
                        Admin::getFiles(),
                        Admin::getUserNamesField(),
                        Admin::getRevision(),
                    ])->columns(2),
                Forms\Components\Section::make('Owners Who Have Read This File')
                    ->schema([
                        Admin::getReadersCount(),
                    ])->columnSpanFull(),
                Admin::getAdditionalInfo(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showTitle(),
                Admin::showCode(),
                Admin::showVersion(),
                Admin::showStatus(),
                Admin::showOwners(),
                Admin::showReadCounts(),
                Admin::showTimeStamp(),
            ])
            ->filters([
                Admin::filterBasedOnOwners(),
                Admin::filterBasedOnStatus(),
                Admin::filterBasedOnCreationTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('readAndConfirm')
                    ->label('Test Confirmation')
                    ->action(function ($record) {
                        if ($record) {
                            $readRecord = $record->reads()->firstOrCreate(
                                ['user_id' => auth()->id()],
                                ['read_count' => 0]
                            );

                            $readRecord->increment('read_count');
                            $readRecord->read = true;
                            $readRecord->save();

                            $record->increment('combined_read_count');
                        }
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check')
                    ->button()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDMS::route('/'),
            'create' => Pages\CreateDMS::route('/create'),
            'edit' => Pages\EditDMS::route('/{record}/edit'),
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
