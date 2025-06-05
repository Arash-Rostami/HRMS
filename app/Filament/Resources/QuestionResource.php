<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\Pages\Admin;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Question')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getStartDate(),
                                    Admin::getEndDate(),
                                    Admin::getContent(),
                                ])->columns(2),
                                Card::make()->schema([
                                    Admin::getStatus(),
                                    Admin::getImage()
                                ])->columns(2),
                            ])->visible(fn(Page $livewire) => ($livewire instanceof Pages\CreateQuestion) or ($livewire instanceof Pages\EditQuestion)),
                        Tabs\Tab::make('Results')
                            ->schema([
                                Repeater::make('responses')
                                    ->relationship('uniqueResponses', function ($query) {
                                        $query->orderBy('created_at', 'desc');
                                    })
                                    ->label('📝 Responses')
                                    ->schema([Admin::showRespondent(), Admin::showResponse()])
                                    ->disabled()
                                    ->collapsible()
                                    ->disableItemCreation()
                                    ->disableItemDeletion()
                                    ->disableItemMovement()
                            ])
                            ->badge(fn($record) => $record ? Admin::countNumberOfUniqRes($record) : 0)
                            ->hidden(fn(Page $livewire) => ($livewire instanceof Pages\CreateQuestion))
                    ])
                    ->activeTab(fn() => request('tab') === 'results' ? 2 : 1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showContent(),
                Admin::showStatus(),
                Admin::numberOfResponse(),
                Admin::showStartDate(),
                Admin::showEndDate(),
                Admin::showImage()
            ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->filters([Admin::filterPeriod()])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View responses')
                    ->modalHeading('View Responses')
                    ->extraAttributes([

                    ]),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
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
