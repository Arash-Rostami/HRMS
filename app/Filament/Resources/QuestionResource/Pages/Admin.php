<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Models\User;
use App\Services\Date;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class Admin
{

    public static function countNumberOfRes($record)
    {
        return $record->responses()->count();
    }

    public static function countNumberOfUniqRes($record)
    {
        return $record->uniqueResponses()->count();
    }


    public static function getRespondent($id)
    {
        if (isset($id)) {
            return User::find($id)->fullName;
        }
    }

    /**
     * @return RichEditor
     */
    public static function getContent(): RichEditor
    {
        return RichEditor::make('content')
            ->required()
            ->columnSpanFull()
            ->toolbarButtons([
                'blockquote',
                'bold',
                'bulletList',
                'h2',
                'h3',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->extraAttributes(function ($state) {
                return ['style' => 'direction:rtl'];
            });
    }

    /**
     * @return DatePicker
     */
    public static function getStartDate()
    {
        return DatePicker::make('start_date')
//            ->helperText(fn(Model $record): string => isset($record->start_date) && !is_null($record->start_date) ? Date::convertToFarsiWithoutTime($record->start_date) : '')
            ->required();
    }

    /**
     * @return DatePicker
     */
    public static function getEndDate()
    {
        return DatePicker::make('end_date')
//            ->helperText(fn(Model $record): string => isset($record->end_date) && !is_null($record->end_date) ? Date::convertToFarsiWithoutTime($record->end_date) : '')
            ->required();
    }

    /**
     * @return Toggle
     */
    public static function getStatus(): Toggle
    {
        return Toggle::make('active')
            ->onIcon('heroicon-s-lightning-bolt')
            ->offIcon('heroicon-s-lightning-bolt');
    }

    /**
     * @return FileUpload
     */
    public static function getImage(): FileUpload
    {
        return FileUpload::make('image')
            ->disk('filament')
            ->directory('img/questions')
            ->maxSize(2500)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string)Str::of($file->getClientOriginalName())->prepend('CEO-QoM-image-');
            });
    }

    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterPeriod(): Filter
    {
        return Filter::make('start_date')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('end_date', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                    );
            });
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
            ->getStateUsing(fn(Model $record) => substr(removeHTMLTags($record->content), 0, 100))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->content)));
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
                    'class' => 'pointer rounded',
                    'title' => 'Right click to enlarge'
                ];
            })->size(75)
            ->toggleable();
    }

    /**
     * @return ToggleColumn|string|null
     */
    public static function showStatus(): ToggleColumn
    {
        return ToggleColumn::make('active')
            ->label('De- | Activate ');
    }

    /**
     * @return BadgeColumn
     */
    public static function showStartDate(): BadgeColumn
    {
        return BadgeColumn::make('start_date')
            ->color('success')
            ->toggleable()
            ->tooltip(fn(Model $record): string => !is_null($record->start_date) ? Date::convertToFarsiWithoutTime($record->start_date) : '');
    }

    /**
     * @return BadgeColumn
     */
    public static function showEndDate(): BadgeColumn
    {
        return BadgeColumn::make('end_date')
            ->color('danger')
            ->toggleable()
            ->tooltip(fn(Model $record): string => !is_null($record->end_date) ? Date::convertToFarsiWithoutTime($record->end_date) : '');
    }

    /**
     * @return TextInput|string|null
     */
    public static function showRespondent(): TextInput
    {
        return TextInput::make('user_id')
//            ->disabled(fn(Page $livewire) => $livewire instanceof Pages\EditQuestion)
            ->formatStateUsing(fn(Closure $get, $record) => $record
                ? self::getRespondent($get('user_id')) . ' 🕒 ' . $record->created_at
                : '')
            ->label('Made by');
    }

    /**
     * @return MarkdownEditor
     */
    public static function showResponse(): MarkdownEditor
    {
        return MarkdownEditor::make('content')
//           ->disabled(fn(Page $livewire) => $livewire instanceof Pages\EditQuestion)
            ->extraAttributes(fn ($record) => $record && preg_match('/[\x{0600}-\x{06FF}]/u', $record->content)
                ? [
                    'style' => 'text-align: right;',
                    'dir' => 'rtl',
                ]
                : [
                    'style' => 'text-align: left;',
                    'dir' => 'ltr',
                ]
            );
    }


    /**
     * @return BadgeColumn
     */
    public static function numberOfResponse(): BadgeColumn
    {
        return BadgeColumn::make('responses')
            ->toggleable()
            ->icon(fn(Model $record) => self::countNumberOfRes($record) == 0 ? '' : 'heroicon-s-mail')
            ->iconPosition('after')
            ->getStateUsing(fn(Model $record) => self::countNumberOfUniqRes($record))
            ->tooltip(fn(): string => 'The total number of responses received so far')
            ->action(ViewAction::make())
            ->color(fn(Model $record) => self::countNumberOfUniqRes($record) == 0 ? 'secondary' : 'primary');
    }
}
