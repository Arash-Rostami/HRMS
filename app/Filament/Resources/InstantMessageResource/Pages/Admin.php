<?php

namespace App\Filament\Resources\InstantMessageResource\Pages;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Admin
{
    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterPeriod(): Filter
    {
        return Filter::make('created_at')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showNameOfSender(): BadgeColumn
    {
        return BadgeColumn::make('sender.fullName')
            ->label('Sender')
            ->colors(['primary'])
            ->sortable()
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->tooltip(fn(Model $record): string => "Email: {$record->sender->email}");
    }

    /**
     * @return BadgeColumn
     */
    public static function showNameOfRecipient(): BadgeColumn
    {
        return BadgeColumn::make('recipient.fullName')
            ->label('Recipient')
            ->colors(['success'])
            ->sortable()
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->tooltip(fn(Model $record): string => "Email: {$record->recipient->email}");
    }

    /**
     * @return TextColumn
     */
    public static function showTopic(): TextColumn
    {
        return TextColumn::make('topic')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->topic)));
    }

    /**
     * @return TextColumn
     */
    public static function showContent(): TextColumn
    {
        return TextColumn::make('content')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->content, 0, 80))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->content)));
    }


    /**
     * @return TextInput
     */
    public static function viewSender(): TextInput
    {
        return TextInput::make('sender')
            ->formatStateUsing(function ($state, Model $record) {
                return "{$record->sender['fullName']}";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewRecipient(): TextInput
    {
        return TextInput::make('Recipient')
            ->formatStateUsing(function ($state, Model $record) {
                return "{$record->recipient['fullName']}";
            });
    }

    /**
     * @return TextInput
     */
    public static function viewTopic(): TextInput
    {
        return TextInput::make('topic')
            ->extraAttributes(function ($state, Model $record) {
                return isFarsi($record->topic) ? ['style' => 'direction:rtl'] : [];
            });
    }

    /**
     * @return MarkdownEditor
     */
    public static function viewContent(): MarkdownEditor
    {
        return MarkdownEditor::make('content')
            ->extraAttributes(function ($state, Model $record) {
                return isFarsi($record->content) ? ['style' => 'direction:rtl'] : [];
            });
    }

}
