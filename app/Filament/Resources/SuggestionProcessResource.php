<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuggestionProcessResource\Pages;
use App\Filament\Resources\SuggestionProcessResource\Pages\Admin;
use App\Filament\Resources\SuggestionProcessResource\RelationManagers;
use App\Models\Suggestion;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuggestionProcessResource extends Resource
{
    protected static ?string $model = Suggestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $navigationLabel = 'Suggestions';

    protected static ?string $navigationGroup = 'User Panel';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tabs')
                ->columnSpanFull()
                ->tabs([
                    Tabs\Tab::make('Suggestion')
                        ->schema([
                            Admin::viewSuggester(),
                            Admin::viewRules(),
                            Admin::viewPurpose(),
                            Admin::viewBeneficiaries(),
                            Admin::viewTitle(),
                            Admin::viewDescription(),
                        ]),
                    Tabs\Tab::make('Reviews')
                        ->schema([
                            Admin::viewVotes(),
                            Admin::viewComments(),
                        ]),
                    Tabs\Tab::make('Action')
                        ->schema([
                            Admin::viewAction(),
                        ])
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showSuggester(),
                Admin::showTitle(),
                Admin::showDescription(),
                Admin::showAbort(),
                Admin::showSelfFill(),
                Admin::showStage(),
                Admin::showAttachment()
            ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSuggestionProcesses::route('/'),
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
