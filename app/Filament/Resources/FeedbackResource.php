<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\Pages\Admin;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
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
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Onboarding';


    protected static ?string $navigationGroup = 'User Panel';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Admin::viewUsefulness(),
                    Admin::viewLength(),
                    Admin::viewStaff(),
                    Admin::viewProduct(),
                    Admin::viewInfo(),
                    Admin::viewIt(),
                    Admin::viewStaff(),
                    Admin::viewCulture(),
                    Admin::viewExperience(),
                    Admin::viewRecommendation(),
                ])->columns(7),
                Card::make()->schema([
                    Admin::viewMostFav(),
                    Admin::viewLeastFav(),
                ])->columns(2),
                Card::make()->schema([
                    Admin::viewAddition(),
                    Admin::viewSuggestion()
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showName(),
                Admin::showUsefulnessRating(),
                Admin::showLengthRating(),
                Admin::showStaffInsightRating(),
                Admin::showProductInsightRating(),
                Admin::showInfoInsightRating(),
                Admin::showItInsightRating(),
                Admin::showInteractionRating(),
                Admin::showCultureRating(),
                Admin::showMeetingRating(),
                Admin::showRecommendationRating(),
                Admin::showMostFav(),
                Admin::showLeastFav(),
                Admin::showAddition(),
                Admin::showSuggestion()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
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
            'index' => Pages\ListFeedback::route('/'),
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
