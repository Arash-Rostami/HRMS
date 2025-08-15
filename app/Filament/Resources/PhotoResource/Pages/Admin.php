<?php

namespace App\Filament\Resources\PhotoResource\Pages;

use App\Services\DepartmentDetails;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\TemporaryUploadedFile;


class Admin
{
    public static function getDepartment(): Select
    {
        return Select::make('department')
            ->options(DepartmentDetails::getDepartmentsDescriptions())
            ->columnSpanFull()
            ->searchable();
    }

    /**
     * @return RichEditor
     */
    public static function getDescription(): RichEditor
    {
        return RichEditor::make('description')
            ->toolbarButtons([
                'bold',
                'bulletList',
                'h2',
                'h3',
                'italic',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->columnSpanFull();
    }

    /**
     * @return DatePicker
     */
    public static function getEventDate(): DatePicker
    {
        return DatePicker::make('event_date')
            ->required()
            ->columnSpanFull()
            ->label('Event Date');
    }

    /**
     * @return FileUpload
     */
    public static function getImagePath(): FileUpload
    {
        return FileUpload::make('path')
            ->label('Gallery Images')
            ->columnSpanFull()
            ->multiple()
            ->disk('filament')
            ->directory('/img/user/gallery/')
            ->maxSize(3120)
            ->enableOpen()
            ->enableDownload()
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                $fileExtension = $file->getClientOriginalExtension();
                $currentTimestamp = time();
                $uniqueIdentifier = uniqid();

                $baseName = 'HR-gallery';
                return "{$baseName}--{$uniqueIdentifier}-{$currentTimestamp}.{$fileExtension}";
            });
    }

    /**
     * @return TextInput
     */
    public static function getTitle(): TextInput
    {
        return TextInput::make('title')
            ->required()
            ->columnSpanFull()
            ->maxLength(255);
    }

    /**
     * @return TextColumn
     */
    public static function showDepartment(): TextColumn
    {
        return TextColumn::make('department')
            ->formatStateUsing(fn($state) => $state ? DepartmentDetails::getDescription($state) : '')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * @return TextColumn
     */
    public static function showDescription(): TextColumn
    {
        return TextColumn::make('description')
            ->searchable()
            ->html()
            ->limit(50)
            ->toggleable(isToggledHiddenByDefault: true)
            ->tooltip(fn(Model $record): string => strip_tags($record->description));
    }

    /**
     * @return TextColumn
     */
    public static function showEventDate(): TextColumn
    {
        return TextColumn::make('event_date')
            ->date()
            ->sortable();
    }

    /**
     * @return array
     */
    public static function showFilters(): array
    {
        return [
            SelectFilter::make('department')
                ->options(DepartmentDetails::getDepartmentsDescriptions())
                ->searchable(),
            Filter::make('event_date')
                ->form([
                    DatePicker::make('event_from'),
                    DatePicker::make('event_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['event_from'],
                            fn(Builder $query, $date): Builder => $query->whereDate('event_date', '>=', $date),
                        )
                        ->when(
                            $data['event_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('event_date', '<=', $date),
                        );
                }),
        ];
    }

    /**
     * @return ImageColumn
     */
    public static function showImage(): ImageColumn
    {
        return ImageColumn::make('path')
            ->label('Photo')
            ->square()
            ->disk('filament')
            ->getStateUsing(function ($record) {
                if (is_array($record->path) && count($record->path) > 0) {
                    return $record->path[0];
                }
                return null;
            });
    }

    public static function showImageCount(): TextColumn
    {
        return TextColumn::make('count')
            ->label('#')
            ->formatStateUsing(fn($record) => is_array($record->path) ? count($record->path) . ' photos' : '0 photos')
            ->color('success');
    }

    /**
     * @return TextColumn
     */
    public static function showTimeStamp(): TextColumn
    {
        return TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * @return TextColumn
     */
    public static function showTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->sortable();
    }
}
