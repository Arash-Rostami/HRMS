<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class Admin
{
    /**
     * @return TextInput
     */
    public static function getTitle(): TextInput
    {
        return TextInput::make('title')
            ->required()
            ->extraAttributes(['style' => 'direction:rtl']);
    }

    /**
     * @return RichEditor
     */
    public static function getDescription(): RichEditor
    {
        return RichEditor::make('description')
            ->required()
            ->toolbarButtons([
                'bold',
                'h2',
                'h3',
                'direction',
                'italic',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->extraAttributes(['style' => 'direction:rtl']);
    }

    /**
     * @return Select
     */
    public static function getDepartment(): Select
    {
        return Select::make('department')
            ->required()
            ->options([
                'MG' => 'MG',
                'HR' => 'HR',
                'AS' => 'AS',
                'CM' => 'CM',
                'CP' => 'CP',
                'AC' => 'AC',
                'PS' => 'PS',
                'WP' => 'WP',
                'MK' => 'MK',
                'CH' => 'CH',
                'SP' => 'SP',
                'CX' => 'CX',
                'BD' => 'BD',
            ]);
    }

    /**
     * @return FileUpload
     */
    public static function getFilePath(): FileUpload
    {
        return FileUpload::make('file_path')
            ->label('Presentation PDF')
            ->required()
            ->disk('filament')
            ->directory('/docs/presentation')
            ->maxSize(2 * 1024)
            ->enableOpen()
            ->enableDownload()
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                $uniqueName = 'HR-presentation-' . time() . '-' . Str::random(8);
                return (string)Str::of($file->getClientOriginalName())->prepend($uniqueName);
            });
    }

    /**
     * @return Toggle
     */
    public static function getActivator(): Toggle
    {
        return Toggle::make('active')
            ->onIcon('heroicon-s-lightning-bolt')
            ->offIcon('heroicon-s-lightning-bolt');
    }

    /**
     * @return TextColumn
     */
    public static function showTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->toggleable()
            ->size('sm')
            ->extraAttributes(['style' => 'direction:rtl']);
    }

    /**
     * @return TextColumn
     */
    public static function showDescription(): TextColumn
    {
        return TextColumn::make('description')
            ->searchable()
            ->toggleable()
            ->size('sm')
            ->color('secondary')
            ->getStateUsing(fn(Model $record) => showFiftydChar($record->description))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->description)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return ToggleColumn
     */
    public static function showActivator(): ToggleColumn
    {
        return ToggleColumn::make('active')
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showDepartment(): BadgeColumn
    {
        return BadgeColumn::make('department')
            ->sortable()
            ->toggleable()
            ->color('secondary')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showFilePath(): TextColumn
    {
        return TextColumn::make('file_path')
            ->label('File Path')
            ->toggleable()
            ->searchable()
            ->size('sm');
    }
}
