<?php

namespace App\Filament\Resources\FeedResource\Pages;

use App\Filament\Resources\FeedResource\Pages;
use App\Models\User;
use App\Services\ContentSanitizer;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;


class Admin
{
    private const CATEGORIES = [
        'General' => 'General',
        'Event' => 'Event',
        'Birthday' => 'Birthday',
        'Work Anniversary' => 'Work Anniversary',
        'Poll' => 'Poll',
    ];

    public static function getAuthor(): Select
    {
        return Select::make('user_id')
            ->label('Author')
            ->disabled(fn($livewire) => $livewire instanceof Pages\CreateFeed)
            ->options(
                User::where('forename', 'not like', 'Guest%')
                    ->where('status', 'active')
                    ->orderBy('surname')
                    ->orderBy('forename')
                    ->get()
                    ->mapWithKeys(fn($user) => [$user->id => "{$user->surname}, {$user->forename}"])
            )
            ->default(auth()->id())
            ->required();
    }


    public static function getCategory(): Select
    {
        return Select::make('category')
            ->options(self::CATEGORIES)
            ->required()
            ->reactive();
    }

    public static function getContent(): RichEditor
    {
        return RichEditor::make('content')
            ->toolbarButtons([
                'bulletList',
                'h2',
                'h3',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->dehydrateStateUsing(fn($state) => ContentSanitizer::clean((string)$state))
            ->columnSpanFull();
    }

    public static function getMediaPaths(): FileUpload
    {
        return FileUpload::make('media_paths')
            ->label('Images & Videos')
            ->multiple()
            ->disk('filament')
            ->directory('img/user/feed')
            ->maxSize(10240)
            ->maxFiles(4)
            ->acceptedFileTypes(['image/*', 'video/*'])
            ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => Str::random(10) . '-' . time() . '.' . $file->getClientOriginalExtension())
            ->columnSpanFull();
    }

    public static function showAuthor(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->label('Author')
            ->sortable(['forename', 'surname'])
            ->searchable(['forename', 'surname'])
            ->size('sm')
            ->tooltip(fn(Model $record): string => $record->user->email)
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function showCategory(): TextColumn
    {
        return TextColumn::make('category')
            ->searchable()
            ->tooltip(fn(Model $record): ?string => strip_tags($record->content))
            ->sortable();
    }

    public static function showCommentAuthor()
    {
        return TextInput::make('user_id')
            ->formatStateUsing(fn($state, $record) => $record && $record->user
                ? $record->user->full_name . ' 🕒 ' . Carbon::parse($record->created_at)->format('M d, Y H:i') : '')
            ->disabled()
            ->dehydrated(false)
            ->label('Commenter');
    }

    public static function showCommentContent()
    {
        return MarkdownEditor::make('content')
            ->label('Comment')
            ->disabled()
            ->extraAttributes(fn($record) => $record && preg_match('/[\x{0600}-\x{06FF}]/u', $record->content)
                ? ['style' => 'text-align: right;', 'dir' => 'rtl']
                : ['style' => 'text-align: left;', 'dir' => 'ltr']
            );
    }

    public static function showComments(): TextColumn
    {
        return TextColumn::make('comments_count')
            ->label('Comment #')
            ->counts('comments')
            ->tooltip('Number of Comments Received')
            ->color('primary')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: false);
    }

    public static function showCommentsList(): TextColumn
    {
        return TextColumn::make('comments')
            ->label('Comments List')
            ->html()
            ->getStateUsing(function ($record): ?string {
                if ($record->comments->isEmpty()) return null;

                return $record->comments->map(function ($comment) {
                    $author = e($comment->user->full_name ?? 'Unknown');
                    $content = e($comment->content);
                    return "<strong>{$author}:</strong> {$content}";
                })->implode('<br>');
            })
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function showContent(): TextColumn
    {
        return TextColumn::make('content')
            ->searchable()
            ->html()
            ->limit(60)
            ->toggleable(isToggledHiddenByDefault: true)
            ->tooltip(fn(Model $record): string => strip_tags($record->content));
    }

    public static function showFilters(): array
    {
        return [
            SelectFilter::make('category')->options(self::CATEGORIES),
            SelectFilter::make('user_id')
                ->label('Author')
                ->options(
                    User::where('forename', 'not like', 'Guest%')
                        ->where('status', 'active')
                        ->orderBy('surname')
                        ->orderBy('forename')
                        ->get()
                        ->mapWithKeys(fn($user) => [$user->id => "{$user->surname}, {$user->forename}"])
                )
                ->searchable()
        ];
    }

    public static function showMedia(): ImageColumn
    {
        return ImageColumn::make('media_paths')
            ->label('Media')
            ->square()
            ->size(40)
            ->getStateUsing(function ($record): ?string {
                if (!$record->media_paths) return null;

                $firstImage = collect($record->media_paths)
                    ->filter(fn($path) => $path && Str::contains($path, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                    ->first();

                return $firstImage ? asset($firstImage) : null;
            });
    }

    public static function showMediaCount(): TextColumn
    {
        return TextColumn::make('count')
            ->label('#')
            ->color('success')
            ->formatStateUsing(function ($record): string {
                if (!$record) return '0 files';

                $count = count($record->media_paths ?? []);
                return $count . ' ' . Str::plural('file', $count);
            });
    }

    public static function showReactionEmoji()
    {
        return TextInput::make('emoji')
            ->label('Emoji')
            ->disabled();
    }

    public static function showReactionUser()
    {
        return TextInput::make('user_id')
            ->formatStateUsing(fn($state, $record) => $record && $record->user
                ? $record->user->full_name . ' 🕒 ' . Carbon::parse($record->created_at)->format('M d, Y H:i')
                : 'Unknown')
            ->disabled()
            ->dehydrated(false)
            ->label('User');
    }

    public static function showReactions(): TextColumn
    {
        return TextColumn::make('reactions_count')
            ->label('Reaction #')
            ->counts('reactions')
            ->sortable()
            ->color('primary')
            ->toggleable(isToggledHiddenByDefault: true);
    }


    public static function showTimeStamp(): TextColumn
    {
        return TextColumn::make('created_at')
            ->dateTime()
            ->sortable();
    }
}
