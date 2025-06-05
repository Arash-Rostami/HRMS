<?php
//
//namespace App\Filament\Resources;
//
//use App\Filament\Resources\SuggestionResource\Pages;
//use App\Filament\Resources\SuggestionResource\Pages\Admin;
//use App\Filament\Resources\SuggestionResource\RelationManagers;
//use App\Models\Suggestion;
//use Filament\Forms;
//use Filament\Forms\Components\Card;
//use Filament\Resources\Form;
//use Filament\Resources\Resource;
//use Filament\Resources\Table;
//use Filament\Tables;
//use Filament\Tables\Columns\Column;
//use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
//
//class SuggestionResource extends Resource
//{
//    protected static ?string $model = Suggestion::class;
//
//    protected static ?string $navigationIcon = 'heroicon-o-pencil';
//
//    protected static ?string $navigationLabel = 'Suggestions';
//
//    protected static ?string $navigationGroup = 'User Panel';
//
//
//    public static function form(Form $form): Form
//    {
//        return $form
//            ->schema([
//                Card::make()->schema([
//                    Admin::viewName(),
//                    Admin::viewTitle(),
//                    Admin::viewPresenter(),
//                    Admin::viewScope(),
//                    Admin::viewEstimate()
//                ])->columns(5),
//                Card::make()->schema([
//                    Admin::viewSuggestion()
//                ])->columns(1),
//                Card::make()->schema([
//                    Admin::viewAdvantage(),
//                    Admin::viewMethod(),
//                ])->columns(2),
//            ]);
//    }
//
//    public static function table(Table $table): Table
//    {
//        return $table
//            ->columns([
//                Admin::showName(),
//                Admin::showTable(),
//                Admin::showPresenter(),
//                Admin::showScope(),
//                Admin::showSuggestion(),
//                Admin::showAdvantage(),
//                Admin::showMethod(),
//                Admin::showEstimate(),
//                Admin::showPicture()
//            ])
//            ->defaultSort('created_at', 'desc')
//            ->poll('10s')
//            ->filters([
//                Admin::filterPresenter(),
//                Admin::filterScope(),
//                Admin::filterName(),
//                Admin::filterSuggestion(),
//                Admin::filterPeriod(),
//            ])
//            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\DeleteAction::make(),
//            ])
//            ->bulkActions([
//                ExportBulkAction::make(),
//                Tables\Actions\DeleteBulkAction::make(),
//            ]);
//    }
//
//    public static function getPages(): array
//    {
//        return [
//            'index' => Pages\ManageSuggestions::route('/'),
//        ];
//    }
//
//    protected static function getNavigationBadge(): ?string
//    {
//        return static::getModel()::count();
//    }
//
//    protected static function getNavigationBadgeColor(): ?string
//    {
//        return 'success';
//    }
//}
