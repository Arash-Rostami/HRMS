<?php

namespace App\Filament\Resources\LinkResource\Pages;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class Admin
{

    /**
     * @return TextInput
     */
    public static function getUrl(): TextInput
    {
        return TextInput::make('url')
            ->label('URL')
            ->required()
            ->rules([
                function () {
                    return function (string $attribute, $value, Closure $fail) {
                        if (!str_contains($value, '/')) {
                            $fail("The URL is invalid!");
                        }
                    };
                },
            ]);
    }

    /**
     * @return TextInput
     */
    public static function getUrlTitle(): TextInput
    {
        return TextInput::make('url_title')
            ->label('URL Title')
            ->placeholder('In English only *')
            ->required();
    }

    /**
     * @return Textarea|string|null
     */
    public static function getUrlDescription(): Textarea
    {
        return Textarea::make('url_description')
            ->placeholder('In English only *')
            ->label('URL Description');
    }

    /**
     * @return FileUpload
     */
    public static function getFileImage(): FileUpload
    {
        return FileUpload::make('image')
            ->disk('filament')
            ->directory('img/user/links')
            ->maxSize(1024)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string)Str::of($file->getClientOriginalName())->prepend('HR-links-image-');
            })
            ->required();
    }

    /**
     * @return Textarea|string|null
     */
    public static function getImageDescription(): Textarea
    {
        return Textarea::make('image_description')
            ->placeholder('In English only *')
            ->label('Image Description');
    }

    /**
     * @return FileUpload
     */
    public static function getFileIcon(): FileUpload
    {
        return FileUpload::make('icon')
            ->disk('filament')
            ->directory('img/user/links/icon')
            ->maxSize(1024)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string)Str::of($file->getClientOriginalName())->prepend('HR-links-icon-');
            })
            ->required();
    }

    /**
     * @return Textarea|string|null
     */
    public static function getIconDescription(): Textarea
    {
        return Textarea::make('icon_description')
            ->placeholder('In English only *')
            ->label('Icon Description');
    }

    /**
     * @return Radio
     */
    public static function getLinkType(): Radio
    {
        return Radio::make('link')
            ->options([
                'internal' => 'Internal',
                'external' => 'External',
            ])
            ->label('Link Type')
            ->required();
    }

    /**
     * @return TextInput
     */
    public static function getSequenceType(): TextInput
    {
        return TextInput::make('sequence')
            ->label('Order')
            ->required();
    }

    /**
     * @return TextInput
     */
    public static function getInternalUrl(): TextInput
    {
        return TextInput::make('internal_url')
            ->label('Internal URL')
            ->rules([
                function () {
                    return function (string $attribute, $value, Closure $fail) {
                        if (empty($value)) return;
                        if (!str_contains($value, '/')) {
                            $fail("The URL is invalid!");
                        }
                    };
                },
            ]);
    }


    /**
     * @return IconColumn
     */
    public static function showLink(): IconColumn
    {
        return IconColumn::make('link')
            ->options([
                'heroicon-o-cloud-download' => 'internal',
                'heroicon-o-cloud-upload' => 'external',
            ])
            ->color(static fn($state) => ($state === 'internal') ? 'success' : 'danger')
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return TextColumn
     */
    public static function showInternalUrl(): TextColumn
    {
        return TextColumn::make('internal_url')
            ->color('secondary')
            ->label('internal URL')
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showUrl(): BadgeColumn
    {
        return BadgeColumn::make('url')
            ->color('secondary')
            ->label('URL')
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    /**
     * @return TextColumn
     */
    public static function showUrlTitle(): TextColumn
    {
        return TextColumn::make('url_title')
            ->searchable()
            ->toggleable()
            ->label('Title');
    }

    /**
     * @return BadgeColumn
     */
    public static function showSequence(): BadgeColumn
    {
        return BadgeColumn::make('sequence')
            ->label('Order')
            ->searchable()
            ->toggleable()
            ->sortable()
            ->color(static fn($state, $record) => ($record->link === 'internal') ? 'success' : 'danger');
    }
}
