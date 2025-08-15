<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnergyTestResource\Pages;
use App\Filament\Resources\EnergyTestResource\Pages\Admin;
use App\Filament\Resources\EnergyTestResource\RelationManagers;
use App\Filament\Resources\EnergyTestResource\Widgets\StatsOverview;
use App\Models\EnergyTest;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class EnergyTestResource extends Resource
{
    protected static ?string $model = EnergyTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $recordTitleAttribute = 'id';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnergyTests::route('/'),
            'view' => Pages\ViewEnergyTest::route('/{record}'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showRespondent(),
                Admin::showPersonalCode(),
                Admin::showOverallScore(),
                Admin::showMindScore(),
                Admin::showEmotionScore(),
                Admin::showPhysiqueScore(),
                Admin::showSoulScore(),
                Admin::showCreatedAt(),
                Admin::showCompletedAt(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
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
