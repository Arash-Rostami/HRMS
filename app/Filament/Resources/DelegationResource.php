<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DelegationResource\Pages;
use App\Filament\Resources\DelegationResource\Pages\Admin;
use App\Filament\Resources\DelegationResource\RelationManagers;
use App\Models\Delegation;
use App\Services\DepartmentDetails;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DelegationResource extends Resource
{
    protected static ?string $model = Delegation::class;

    protected static ?string $title = 'Authorities';

    protected static ?string $navigationLabel = 'Authorities';

    protected static ?string $navigationIcon = 'heroicon-s-adjustments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::getDepartment(),
                    Admin::getPersonResponsible(),
                    Admin::getSubDuty(),
                    Admin::getDuty(),
                    Admin::getExecutionProcedure(),
                    Admin::getRepeatFrequency(),
                    Admin::getImpactScore(),
                    Admin::getProposedDelegation(),
                    Admin::getApprovedDelegation(),
                    Admin::getCoDelegate(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showDepartment(),
                Admin::showPersonResponsible(),
                Admin::showDuty(),
                Admin::showSubDuty(),
                Admin::showExecutionProcedure(),
                Admin::showRepeatFrequency(),
                Admin::showImpactScore(),
                Admin::showProposedDelegation(),
                Admin::showApprovedDelegation(),
                Admin::howCoDelegate(),
            ])
            ->filters([
                Admin::filterBasedOnDepartment(),
                Admin::filterBasedOnSubDuty(),
                Admin::filterBasedOnExecutionProcedure(),
                Admin::filterBasedOnRepeatFrequency(),
                Admin::filterBasedOnImpactScore(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
                ]);
    }

    public static function getRelations(): array
    {
        return [ ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDelegations::route('/'),
            'create' => Pages\CreateDelegation::route('/create'),
            'edit' => Pages\EditDelegation::route('/{record}/edit'),
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
