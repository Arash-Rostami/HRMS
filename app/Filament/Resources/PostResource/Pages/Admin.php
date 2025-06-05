<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Str;


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
     * @return Select
     */
    public static function getAuthor(): Select
    {
        return Select::make('user_id')
            ->label('Author')
            ->required()
            ->options(User::all()
                ->where('forename', '!=', 'Guest')
                ->where('role', '!=', 'user')
                ->sortBy('forename')->pluck('fullName', 'id'));
    }

    /**
     * @return RichEditor
     */
    public static function getTitle(): RichEditor
    {
        return RichEditor::make('title')
            ->disableAllToolbarButtons()
            ->extraAttributes(['style' => 'direction: rtl']);
    }

    /**
     * @return RichEditor
     */
    public static function getContent(): RichEditor
    {
        return RichEditor::make('body')
            ->label('Content')
            ->toolbarButtons([
                'blockquote',
                'bold',
                'bulletList',
                'h2',
                'h3',
                'direction',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->enableToolbarButtons([
                'underline',
            ])->extraAttributes(['style' => 'direction:rtl']);
    }

    /**
     * @return Toggle
     */
    public static function getMainImage(): Toggle
    {
        return Toggle::make('pinned')
            ->label('Main Image')
            ->onIcon('heroicon-s-lightning-bolt');
    }

    /**
     * @return FileUpload
     */
    public static function getFile(): FileUpload
    {
        return FileUpload::make('image')
            ->disk('filament')
            ->directory('img/posts')
            ->maxSize(1024)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string)Str::of($file->getClientOriginalName())->prepend('HR-posts-image-');
            });
    }

    /**
     * @return BadgeColumn
     */
    public static function showAuthor(): BadgeColumn
    {
        return BadgeColumn::make('user.fullName')
            ->label('Author')
            ->color('secondary')
            ->sortable()
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->tooltip(fn(Model $record) => "authored on {$record->created_at}");
    }

    /**
     * @return TextColumn
     */
    public static function showTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(strip_tags(html_entity_decode($record->title)), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->title)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return TextColumn
     */
    public static function showContent(): TextColumn
    {
        return TextColumn::make('body')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr(strip_tags(html_entity_decode($record->body)), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->body)))
            ->extraAttributes(function (Model $record) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return ToggleColumn|string|null
     */
    public static function showMainImage(): ToggleColumn
    {
        return ToggleColumn::make('pinned')
            ->label('Main Image');
    }

    /**
     * @return ImageColumn
     */
    public static function showImage(): ImageColumn
    {
        return ImageColumn::make('image')
            ->disk('filament')
            ->extraImgAttributes(function (Model $record) {
                return [
                    //local config
                    'oncontextmenu' => 'showImage("/' . $record->image . '", "_blank")',
                    //server config
                    // 'oncontextmenu' => 'showImage("' . url('/' . $record->image) . '", "_blank")',
                    'class' => 'pointer',
                    'title' => 'Right click to enlarge'
                ];
            })->size(100)
            ->toggleable();
    }

    private function changeDirection($data)
    {
        return preg_replace('/<(?!br)(.*?)>/', '<$1 style="direction: rtl;">', $data);
    }
}
