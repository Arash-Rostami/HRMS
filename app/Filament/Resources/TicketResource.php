<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\Pages\Admin;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;

use Filament\Forms\Components\Tabs;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationLabel = 'THS';

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('THS')
                    ->tabs([
                        Tabs\Tab::make('Request')
                            ->schema([
                                Admin::getRequester(),
                                Admin::getDepartment(),
                                Admin::getType(),
                                Admin::getArea(),
                                Admin::getPriority(),
                                Admin::getAssignee(),
                                Admin::getSubject(),
                                Admin::getDescription(),
                                Admin::getRequesterFiles(),
                            ])->columns(2),
                        Tabs\Tab::make('Response')
                            ->schema([
                                Admin::getDeadline(),
                                Admin::getCompletionDate(),
                                Admin::getEffectivenessSore(),
                                Admin::getSatisfactionScore(),
                                Admin::getStatus(),
                                Admin::getAction(),
                                Admin::getAdditionalNotes(),
                                Admin::getAssigneeFiles(),
//                                Admin::getExtraInfo()
                            ])->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Admin::showTicketId(),
                Admin::showStatus(),
                Admin::showDepartment(),
                Admin::showRequesterName(),
                Admin::showPriorityLevel(),
                Admin::showArea(),
                Admin::showSubject(),
                Admin::showAssigneeName(),
                Admin::showCompletionDeadline(),
                Admin::showCompletionDate(),
                Admin::showSatisfaction(),
                Admin::showEffectiveness(),
                Admin::showTimeStamp(),
            ])
            ->filters([
                Admin::filterBasedOnPriority(),
                Admin::filterBasedOnStatus(),
                Admin::filterBasedOnDepartment(),
                Admin::filterBasedOnAssignee(),
                Admin::filterBasedOnType(),
                Admin::filterBasedOnOverDue(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        $openCount = static::getModel()::where('status', 'open')->count();
        return $openCount > 0 ? $openCount ." New" : static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        $openCount = static::getModel()::where('status', 'open')->count();
        return $openCount > 0 ? 'danger' : 'success';
    }
}
