<?php

namespace App\Filament\Resources\DMSResource\Pages;

use App\Models\User;
use App\Services\DepartmentDetails;
use Closure;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Filament\Forms;
use Filament\Tables;
use Filament\Pages\Page;
use App\Filament\Resources\DMSResource\Pages;


class Admin
{
    /**
     * @return Forms\Components\TextInput
     */
    public static function getTitle(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('title')
            ->required();
    }

    /**
     * @return Forms\Components\TextInput
     */
    public static function getCode(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('code')
            ->required();
    }

    /**
     * @return Forms\Components\TextInput
     */
    public static function getVersion(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('version')
            ->required();
    }

    /**
     * @return Forms\Components\Select
     */
    public static function getStatus(): Forms\Components\Select
    {
        return Forms\Components\Select::make('status')
            ->options([
                'live' => 'Live',
                'under_review' => 'Under Review',
                'obsolete' => 'Obsolete',
            ])->required();
    }


    public static function getOwners(): Forms\Components\Select
    {
        return Forms\Components\Select::make('owners')
            ->label('Owners')
            ->options(array_merge(['ALL' => 'All Departments'], DepartmentDetails::getDepartmentsArray()))
            ->reactive()
            ->afterStateUpdated(fn(Closure $set, $state) => self::showUserNames($state, $set))
            ->multiple()
            ->required();
    }

    public static function getUserNamesField(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('extra.users')
            ->label('Owner\'s name by Department')
            ->disabled()
            ->placeholder('No users found!')
            ->columnSpanFull()
            ->reactive();
    }


    /**
     * @return Forms\Components\FileUpload
     */
    public static function getFiles(): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make('file')
            ->label('Document File')
            ->enableOpen()
            ->enableDownload()
            ->disk('filament')
            ->directory('files/dms')
            ->maxSize(4000)
            ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => self::forgeNameOfFile($file))
            ->required();
    }

    /**
     * @return Forms\Components\Textarea
     */
    public static function getRevision(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('revision')
            ->label('Comments')
            ->placeholder('You may add any extra description if you wish ...')
            ->columnSpanFull();
    }

    /**
     * @return Forms\Components\KeyValue
     */
    public static function getAdditionalInfo(): Forms\Components\KeyValue
    {
        return Forms\Components\KeyValue::make('extra')->label('Addition Information (ⓘ optional)')
            ->keyLabel('Field Name')
            ->valueLabel('Value');
    }

    /**
     * @return Tables\Columns\TextColumn
     */
    public static function showTitle(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('title')
            ->sortable()
            ->searchable();
    }

    /**
     * @return Tables\Columns\TextColumn
     */
    public static function showCode(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('code')
            ->sortable()
            ->searchable();
    }

    /**
     * @return Tables\Columns\TextColumn
     */
    public static function showVersion(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('version')
            ->sortable()
            ->searchable();
    }

    /**
     * @return Tables\Columns\BadgeColumn
     */
    public static function showStatus(): Tables\Columns\BadgeColumn
    {
        return Tables\Columns\BadgeColumn::make('status')
            ->enum([
                'live' => 'Live',
                'under_review' => 'Under Review',
                'obsolete' => 'Obsolete',
            ])
            ->colors([
                'success' => 'live',
                'warning' => 'under_review',
                'danger' => 'obsolete',
            ])
            ->sortable()
            ->searchable();
    }

    /**
     * @return Tables\Columns\BadgeColumn
     */
    public static function showOwners(): Tables\Columns\BadgeColumn
    {
        return Tables\Columns\BadgeColumn::make('owners')
            ->label('Owners')
            ->color('primary')
            ->tooltip(fn($record) => in_array('ALL', $record->owners ?? [])
                ? 'all'
                : implode(', ', array_map(fn($code) => DepartmentDetails::getName($code), $record->owners ?? []))
            )
            ->sortable();
    }

    /**
     * @return Tables\Columns\BadgeColumn
     */
    public static function showReadCounts(): Tables\Columns\BadgeColumn
    {
        return Tables\Columns\BadgeColumn::make('combined_read_count')
            ->counts('reads')
            ->default('None')
            ->label('Total Reads');
    }

    /**
     * @return Tables\Columns\BadgeColumn
     */
    public static function showTimeStamp(): Tables\Columns\BadgeColumn
    {
        return Tables\Columns\BadgeColumn::make('created_at')
            ->sortable()
            ->searchable()
            ->dateTime();
    }

    /**
     * @return Forms\Components\Repeater
     */
    public static function getReadersCount(): Forms\Components\Repeater
    {
        return Forms\Components\Repeater::make('reads')
            ->relationship('reads')
            ->schema([
                Forms\Components\TextInput::make('user_and_read_count')
                    ->label(' ')
                    ->formatStateUsing(function ($record) {
                        if ($record) {
                            $userFullName = $record->user ? $record->user->forename . ' ' . $record->user->surname : 'N/A';
                            return "✅ $userFullName 📅 $record->created_at  📖 {$record->read_count}";
                        }
                        return 'None yet';
                    })
                    ->disabled(),
            ])
            ->label(new HtmlString('✅ Confirmation From <br> 📅 Date & Time of Confirmation <br>📖 Read Count'))
            ->disableItemCreation()
            ->disableItemDeletion()
            ->visible(fn(Page $livewire) => ($livewire instanceof Pages\EditDMS))
            ->disableItemMovement();
    }

    /**
     * @return Tables\Filters\Filter
     * @throws \Exception
     */
    public static function filterBasedOnOwners(): Tables\Filters\Filter
    {
        return Tables\Filters\Filter::make('owners')
            ->form([
                Forms\Components\Select::make('owners_input')
                    ->label('Owners')
                    ->options(DepartmentDetails::getDepartmentsArray())
                    ->multiple(),
            ])
            ->query(function ($query, array $data) {
                return $query->when($data['owners_input'], function ($q, $owners) {
                    $q->where(function ($query) use ($owners) {
                        foreach ($owners as $owner) {
                            $query->orWhereJsonContains('owners', $owner);
                        }
                    });
                });
            })
            ->label('Owners');
    }


    /**
     * @return Tables\Filters\SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnStatus(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('status')
            ->options([
                'live' => 'Live',
                'under_review' => 'Under Review',
                'obsolete' => 'Obsolete',
            ]);
    }

    /**
     * @return Tables\Filters\Filter
     * @throws \Exception
     */
    public static function filterBasedOnCreationTime(): Tables\Filters\Filter
    {
        return Tables\Filters\Filter::make('created_at')
            ->form([
                Forms\Components\DatePicker::make('created_from')->label('Created From'),
                Forms\Components\DatePicker::make('created_until')->label('Created Until'),
            ])
            ->query(function ($query, array $data) {
                return $query
                    ->when($data['created_from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                    ->when($data['created_until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
            });
    }


    public static function showUserNames($state, Closure $set): void
    {
        if (isset($state) && in_array('ALL', $state)) {
            $set('extra.users', 'Everyone');
            return;
        }

        $selectedDepartments = $state ?? [];
        if (empty($selectedDepartments)) {
            $set('extra.users', []);
            return;
        }

        $usersByDepartment = User::query()
            ->select('profiles.department', 'users.forename', 'users.surname')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->whereIn('profiles.department', $selectedDepartments)
            ->where('users.status', 'active')
            ->get()
            ->groupBy('department')
            ->filter(fn($users, $departmentCode) => array_key_exists($departmentCode, DepartmentDetails::$departments))
            ->map(fn($users, $departmentCode) => DepartmentDetails::getName($departmentCode) . ": " . $users->map(fn($user) => $user->forename . ' ' . $user->surname)->implode(' ┆ '))
            ->values()
            ->implode("\n\n");


        $set('extra.users', $usersByDepartment);
    }

    /**
     * @param TemporaryUploadedFile $file
     * @return string
     */
    public static function forgeNameOfFile(TemporaryUploadedFile $file): string
    {
        $prefix = 'PS-DMS-procedure';
        $date = now()->format('Ymd');
        $uniqueId = uniqid();
        $extension = $file->getClientOriginalExtension();

        $originalName = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            ->ascii()
            ->replaceMatches('/[^A-Za-z0-9]/', '')
            ->replace(' ', '')
            ->replace('_', '-')
            ->kebab();

        return (string)"{$prefix}-{$date}-{$uniqueId}-{$originalName}.{$extension}";
    }
}
