<?php

namespace App\Filament\Resources\FAQResource\Pages;

use App\Models\FAQ;
use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    /**
     * @return BadgeColumn
     */
    public static function showCategory(): BadgeColumn
    {
        return BadgeColumn::make('category')
            ->color('primary')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->question)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return TextColumn
     */
    public static function showQuestion(): TextColumn
    {
        return TextColumn::make('question')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(strip_tags(html_entity_decode($record->question)), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->question)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return TextColumn
     */
    public static function showAnswer(): TextColumn
    {
        return TextColumn::make('answer')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(strip_tags(html_entity_decode($record->answer)), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->answer)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return Select
     */
    public static function getOldCategory(): Select
    {
        return Select::make('category')
            ->label('Old Category')
            ->options(FAQ::all()->pluck('category', 'category'))
            ->placeholder('New Category')
            ->reactive();
    }

    /**
     * @return TextInput
     */
    public static function getNewCategory(): TextInput
    {
        return TextInput::make('newCategory')
            ->label('New Category')
            ->required(fn(Closure $get) => ($get('category') == null));
    }

    /**
     * @return RichEditor
     */
    public static function getQuestion(): RichEditor
    {
        return RichEditor::make('question')
            ->disableAllToolbarButtons()
            ->extraAttributes(['style' => 'direction: rtl'])
            ->required();
    }

    /**
     * @return RichEditor
     */
    public static function getAnswer(): RichEditor
    {
        return RichEditor::make('answer')
            ->toolbarButtons([
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'direction',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'undo',
            ]);
    }
}
