<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppResource\Pages;
use App\Filament\Resources\AppResource\Pages\Admin;
use App\Models\App;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;


class AppResource extends Resource
{
    protected static ?string $model = App::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationLabel = 'Apps';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Card::make()->schema([
                        Admin::getUser(),
                        Admin::getAppName(),
                    ])->columnSpan(1),
                    Card::make()->schema([
                        Admin::getUserName(),
                        Admin::getPassword(),
                    ])->columnSpan(1),
                ]),
                Card::make()
                    ->schema([
                        Admin::getLink(),
                        Admin::getNote(),
                    ])
                    ->columns(2),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showUser(),
                Admin::showAppName(),
                Admin::showUserName(),
                Admin::showLink(),
                Admin::showNote(),
            ])
            ->filters([
                Admin::filterByUser(),
                Admin::filterByAppName(),
            ])
            ->defaultSort('app_name')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApps::route('/'),
            'create' => Pages\CreateApp::route('/create'),
            'edit' => Pages\EditApp::route('/{record}/edit'),
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
