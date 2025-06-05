<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Models\Question;
use App\Models\User;
use Closure;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    protected static function getQuestionContent($id)
    {
        return Question::find($id)->first()->content;
    }

    public static function getRespondent($id)
    {
        return User::find($id)->fullName;
    }

    /**
     * @return TextColumn
     */
    public static function showQuestion(): TextColumn
    {
        return TextColumn::make('question_id')
            ->label('Question')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(removeHTMLTags($record->question->content), 0, 80))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->question->content)));
    }

    /**
     * @return ImageColumn
     */
    public static function showUser(): ImageColumn
    {
        return ImageColumn::make('user.profile.image')
            ->label('Respondent')
            ->disk('filament')
            ->searchable(['forename', 'surname'])
            ->tooltip(fn(Model $record): string => $record->user->fullName)
            ->size(75)
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showResponse(): TextColumn
    {
        return TextColumn::make('content')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->content, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->content)));
    }

    /**
     */
    public static function viewRespondent()
    {
        return TextInput::make('user_id')
            ->formatStateUsing(fn(Closure $get) => self::getRespondent($get('user_id')))
            ->label('Respondent');
    }


    /**
     * @return MarkdownEditor
     */
    public static function viewAnswer(): MarkdownEditor
    {
        return MarkdownEditor::make('content')
            ->label('Response')
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }


    /**
     * @return MarkdownEditor
     */
    public static function viewQuestion(): MarkdownEditor
    {
        return MarkdownEditor::make('question_id')
            ->label('Question')
            ->formatStateUsing(fn(Closure $get) => self::getQuestionContent($get('question_id')))
            ->disableAllToolbarButtons()
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

}
