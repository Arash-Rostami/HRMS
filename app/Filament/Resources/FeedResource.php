<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedResource\Pages;
use App\Filament\Resources\FeedResource\Pages\Admin;
use App\Models\Feed;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FeedResource extends Resource
{
    protected static ?string $model = Feed::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?string $navigationLabel = 'Feeds';
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Feed')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getAuthor(),
                                    Admin::getCategory(),
                                    Admin::getContent(),
                                    Admin::getMediaPaths(),
                                ])->columns(2),
                            ]),
                        Tabs\Tab::make('Comments')
                            ->schema([
                                Repeater::make('comments')
                                    ->relationship('comments', fn($query) => $query->orderBy('created_at', 'desc'))
                                    ->label('💬 Comments')
                                    ->schema([Admin::showCommentAuthor(), Admin::showCommentContent()])
                                    ->disableItemDeletion(false)
                                    ->collapsible()
                                    ->disableItemCreation()
                                    ->disableItemMovement()
                            ])
                            ->badge(fn($record) => $record ? $record->comments()->count() : 0)
                            ->hidden(fn($livewire) => $livewire instanceof Pages\CreateFeed),
                        Tabs\Tab::make('Reactions')
                            ->schema([
                                Repeater::make('reactions')
                                    ->relationship('reactions', fn($query) => $query->orderBy('created_at', 'desc'))
                                    ->label('🎭 Reactions')
                                    ->schema([Admin::showReactionUser(), Admin::showReactionEmoji()])
                                    ->disableItemDeletion(false)
                                    ->collapsible()
                                    ->disableItemCreation()
                                    ->disableItemMovement()
                            ])
                            ->badge(fn($record) => $record ? $record->reactions()->count() : 0)
                            ->hidden(fn($livewire) => $livewire instanceof Pages\CreateFeed),
                    ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeeds::route('/'),
            'create' => Pages\CreateFeed::route('/create'),
            'edit' => Pages\EditFeed::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showMedia(),
                Admin::showMediaCount(),
                Admin::showCategory(),
                Admin::showContent(),
                Admin::showComments(),
                Admin::showReactions(),
                Admin::showCommentsList(),
                Admin::showAuthor(),
                Admin::showTimeStamp(),
            ])
            ->filters(Admin::showFilters())
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
            ])
            ->defaultSort('created_at', 'desc');
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
