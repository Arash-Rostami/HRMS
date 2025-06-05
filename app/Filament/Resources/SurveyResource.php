<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\Pages\Admin;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Survey;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class SurveyResource extends Resource
{


    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Orientation';

    protected static ?string $navigationGroup = 'User Panel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::viewDays(),
                    Admin::viewResource(),
                    Admin::viewTeam(),
                    Admin::viewManager(),
                    Admin::viewSatisfaction(),
                    Admin::viewHelpfulness(),
                    Admin::viewBuddy()
                ])->columns(7),
                Card::make()->schema([
                    Admin::viewRole(),
                    Admin::viewChallenge(),
                    Admin::viewStage()
                ])->columns(3),
                Card::make()->schema([
                    Admin::viewImprovement(),
                    Admin::viewSuggestion()
                ])->columns(2),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showName(),
                Admin::showDays(),
                Admin::showResouceRating(),
                Admin::showTeamRating(),
                Admin::showManagerRating(),
                Admin::showCultureRating(),
                Admin::showSatisfactionRating(),
                Admin::showHelpfulnessRating(),
                Admin::showBuddyRating(),
                Admin::showRoleOfBuddy(),
                Admin::showChallengeAchievement(),
                Admin::showStage(),
                Admin::showImprovement(),
                Admin::showSuggestion(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s')
            ->filters([
                Admin::filterDays(),
                Admin::filterPeriod()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSurveys::route('/'),
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
