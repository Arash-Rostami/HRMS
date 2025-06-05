<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Models\Ticket;
use App\Models\User;
use App\Services\DepartmentDetails;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class Admin
{

    /**
     * @return Select
     */
    public static function getRequester(): Select
    {
        return Select::make('requester_id')
            ->label('Requester')
            ->searchable()
            ->getSearchResultsUsing(fn(string $search) => User::where(function ($query) use ($search) {
                $query->where('forename', 'like', "%{$search}%")
                    ->where('forename', 'not like', '%Guest%')->where('surname', 'not like', '%Guest%')->where('status', 'active');
            })->orWhere(function ($query) use ($search) {
                $query->where('surname', 'like', "%{$search}%")
                    ->where('forename', 'not like', '%Guest%')->where('surname', 'not like', '%Guest%')->where('status', 'active');
            })->limit(10)->selectRaw("CONCAT(forename, ' ', surname) as name, id")->pluck('name', 'id'))
            ->getOptionLabelUsing(fn($value) => $value ? User::find($value)?->fullName ?? 'Unknown User' : '')
            ->reactive()
//            ->relationship('requester',
//                'surname',
//                fn(Builder $query) => $query->where('status', 'active')
//                    ->where('forename', 'not like', '%Guest%')
//                    ->where('surname', 'not like', '%Guest%')
//                    ->orderByRaw('CONCAT(forename, " ", surname)'))
//            ->disabled(fn($livewire) => $livewire instanceof EditTicket)
//            ->getOptionLabelFromRecordUsing(fn($record) => $record->fullName)
            ->afterStateUpdated(fn(callable $set, $state) => $set('extra.department', $state ? User::find($state)?->profile?->department : 'N/A'))
            ->required();
    }

    /**
     * @return TextInput
     */
    public static function getDepartment(): TextInput
    {
        return TextInput::make('extra.department')
            ->label('Department')
            ->disabled()
            ->afterStateHydrated(function (TextInput $component, $state, $record) {
                if ($record && $record->requester_id) {
                    $user = User::with('profile')->find($record->requester_id);
                    $departmentName = $user && $user->profile && $user->profile->department
                        ? $user->profile->department
                        : 'N/A';
                    $component->state($departmentName);
                } else {
                    $component->state('N/A');
                }
            });
    }

    /**
     * @return Select
     */
    public static function getType(): Select
    {
        return Select::make('request_type')
            ->label('Request Type')
            ->options(Ticket::$requestTypeOptions)
            ->required()
            ->reactive()
            ->afterStateUpdated(fn($state, callable $set) => $set('request_area', null));
    }

    /**
     * @return Select
     */
    public static function getArea(): Select
    {
        return Select::make('request_area')
            ->label('Request Area')
            ->options(function (callable $get) {
                $type = $get('request_type');
                $options = $type ? Ticket::$requestAreaOptions[$type] : [];

                array_shift($options);
                return $options;
            })
            ->required();
    }

    /**
     * @return Select
     */
    public static function getPriority(): Select
    {
        return Select::make('priority')
            ->options([
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
            ])
            ->disabled(fn($livewire) => $livewire instanceof EditTicket)
            ->label('Priority')
            ->default('low');
    }

    /**
     * @return Select
     */
    public static function getAssignee(): Select
    {
        return Select::make('assigned_to')
            ->label('Assignee')
            ->disabled(fn($livewire) => $livewire instanceof CreateTicket)
            ->required(fn($livewire) => $livewire instanceof EditTicket)
            ->relationship('assignee',
                'surname',
                fn(Builder $query) => $query->where('status', 'active')
                    ->where('forename', 'not like', '%Guest%')
                    ->where('surname', 'not like', '%Guest%')
                    ->whereHas('profile', fn(Builder $q) => $q->where('department', 'PS'))
                    ->orderByRaw('CONCAT(forename, " ", surname)'))
            ->getOptionLabelFromRecordUsing(fn($record) => $record->full_name);
    }

    public static function getSubject(): TextInput
    {
        return TextInput::make('request_subject')
            ->label('Subject')
            ->columnSpanFull()
            ->disabled(fn($livewire) => $livewire instanceof EditTicket)
            ->required()
            ->extraAttributes(fn($record) => $record && preg_match('/[\x{0600}-\x{06FF}]/u', $record->request_subject)
                ? [
                    'style' => 'text-align: right;', 'dir' => 'rtl',
                ]
                : [
                    'style' => 'text-align: left;', 'dir' => 'ltr',
                ]
            );
    }

    /**
     * @return Textarea
     */
    public static function getDescription(): Textarea
    {
        return Textarea::make('description')
            ->label('Description')
            ->columnSpanFull()
            ->disabled(fn($livewire) => $livewire instanceof EditTicket)
            ->required()
            ->extraAttributes(fn($record) => $record && preg_match('/[\x{0600}-\x{06FF}]/u', $record->description)
                ? [
                    'style' => 'text-align: right;', 'dir' => 'rtl',
                ]
                : [
                    'style' => 'text-align: left;', 'dir' => 'ltr',
                ]
            );
    }

    /**
     * @return Repeater
     */
    public static function getRequesterFiles(): Repeater
    {
        return Repeater::make('requester_files')
            ->label('Requester Files')
            ->schema([
                FileUpload::make('file')
                    ->label('File')
                    ->disk('filament')
                    ->directory('files/ths/requester')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/bmp',
                        'image/svg+xml',
                        'image/webp',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.oasis.opendocument.spreadsheet',
                        'application/vnd.oasis.opendocument.text',
                    ])
                    ->maxSize(4000)
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => self::forgeNameOfFile($file))
                    ->disabled(fn($livewire) => $livewire instanceof EditTicket)
                    ->enableOpen()
                    ->enableDownload(),
            ])
            ->disabled(fn($livewire) => $livewire instanceof EditTicket)
            ->columnSpanFull()
            ->maxItems(10);
    }

    /**
     * @return Radio
     */
    public static function getStatus(): Radio
    {
        return Radio::make('status')
            ->label('Status')
            ->options([
                'open' => '📑 Open',
                'in-progress' => '🕒 In Progress',
                'closed' => '✅ Closed',
            ])
            ->columns(3)
            ->columnSpanFull()
            ->reactive()
            ->afterStateUpdated(function (callable $set, $state) {
                if ($state === 'closed') {
                    $set('completion_date', now());
                } else {
                    $set('completion_date', null);
                }
            });
    }

    /**
     * @return DateTimePicker
     */
    public static function getDeadline(): DateTimePicker
    {
        return DateTimePicker::make('completion_deadline')
            ->label('Completion Deadline')
            ->nullable();
    }

    /**
     * @return DateTimePicker
     */
    public static function getCompletionDate(): DateTimePicker
    {
        return DateTimePicker::make('completion_date')
            ->label('Completion Date')
            ->disabled()
            ->default(fn($get) => $get('status') === 'closed' ? now() : null)
            ->nullable();
    }

    /**
     * @return TextInput
     */
    public static function getSatisfactionScore(): TextInput
    {
        return TextInput::make('satisfaction_score')
            ->label('Satisfaction Score')
            ->disabled()
            ->numeric()
            ->step(0.1);
    }


    /**
     * @return Select
     */
    public static function getEffectivenessSore(): Select
    {
        return Select::make('effectiveness')
            ->label('Impact Assessment')
            ->options([
                '5' => 'Very Effective',
                '4' => 'Effective',
                '3' => 'Neutral',
                '2' => 'Ineffective',
                '1' => 'Very Ineffective',
            ]);
    }

    /**
     * @return Textarea
     */
    public static function getAction(): Textarea
    {
        return Textarea::make('action_result')
            ->label('Action Result')
            ->columnSpanFull()
            ->nullable();
    }

    /**
     * @return Textarea
     */
    public static function getAdditionalNotes(): Textarea
    {
        return Textarea::make('additional_notes')
            ->label('Additional Notes')
            ->columnSpanFull()
            ->nullable();
    }

    /**
     * @return Repeater
     */
    public static function getAssigneeFiles(): Repeater
    {
        return Repeater::make('assignee_files')
            ->label('Files')
            ->schema([
                FileUpload::make('file')
                    ->label('File')
                    ->disk('filament')
                    ->directory('files/ths/assignee')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/bmp',
                        'image/svg+xml',
                        'image/webp',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.oasis.opendocument.spreadsheet',
                        'application/vnd.oasis.opendocument.text',
                    ])
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file) => self::forgeNameOfFile($file))
                    ->enableOpen()
                    ->enableDownload(),
            ])
            ->columnSpanFull()
            ->maxItems(10);
    }

    /**
     * @return Repeater
     */
    public static function getExtraInfo(): Repeater
    {
        return Repeater::make('extra')
            ->label('Additional Information')
            ->schema([
                TextInput::make('key')
                    ->label('Key')
                    ->required(),

                TextInput::make('value')
                    ->label('Value')
                    ->required(),
            ])
            ->columnSpanFull()
            ->default([])
            ->dehydrateStateUsing(fn($state) => collect($state)->pluck('value', 'key')->toArray());
    }

    /**
     * @param TemporaryUploadedFile $file
     * @return string
     */
    public static function forgeNameOfFile(TemporaryUploadedFile $file): string
    {
        $prefix = 'PS-THS';
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


    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnPriority(): SelectFilter
    {
        return SelectFilter::make('priority')
            ->options([
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
            ]);
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnStatus(): SelectFilter
    {
        return SelectFilter::make('status')
            ->options([
                'open' => 'Open',
                'in-progress' => 'In Progress',
                'open_or_in_progress' => 'Open or In Progress',
                'closed' => 'Closed',
            ])
            ->query(function (Builder $query, array $data) {
                if (!empty($data['value'])) {
                    if ($data['value'] === 'open_or_in_progress') {
                        $query->whereIn('status', ['open', 'in-progress']);
                    } else {
                        $query->where('status', $data['value']);
                    }
                }
            });
    }

    public static function filterBasedOnAssignee(): SelectFilter
    {
        return SelectFilter::make('assigned_to')
            ->label('Assignee')
            ->relationship('assignee',
                'surname',
                fn(Builder $query) => $query->where('status', 'active')
                    ->where('forename', 'not like', '%Guest%')
                    ->where('surname', 'not like', '%Guest%')
                    ->whereHas('profile', fn(Builder $q) => $q->where('department', 'PS'))
                    ->orderByRaw('CONCAT(forename, " ", surname)'))
            ->query(function (Builder $query, array $data) {
                if (!empty($data['value'])) {
                    $query->where('assigned_to', $data['value']);
                }
            });
    }

    public static function filterBasedOnDepartment(): SelectFilter
    {
        return SelectFilter::make('department')
            ->label('Department')
            ->options(fn() => DepartmentDetails::getDepartmentsArray())
            ->query(function (Builder $query, array $data) {
                if (!empty($data['value'])) {
                    $query->whereJsonContains('extra->department', $data['value']);
                }
            });
    }

    /**
     * @return SelectFilter
     * @throws \Exception
     */
    public static function filterBasedOnType(): SelectFilter
    {
        return SelectFilter::make('request_type')
            ->label('Request Type')
            ->options(Ticket::$requestTypeOptions)
            ->searchable()
            ->multiple(false);
    }

    /**
     * @return Filter
     * @throws \Exception
     */
    public static function filterBasedOnOverDue(): Filter
    {
        return Filter::make('deadline_overdue')
            ->label('Overdue Deadlines')
            ->query(fn(Builder $query) => $query->where('completion_deadline', '<', now()));
    }


    /**
     * @return TextColumn
     */
    public static function showTimeStamp(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label('Creation | Update')
            ->dateTime('M d, Y H:i')
            ->tooltip(fn($record) => $record ? 'Updated at ⏱️ ' . $record->updated_at->format('M d, Y H:i') : 'N/A')
            ->sortable()
            ->toggleable()
            ->color('gray');
    }

    /**
     * @return TextColumn
     */
    public static function showSatisfaction(): TextColumn
    {
        return TextColumn::make('satisfaction_score')
            ->label('Satisfaction')
            ->sortable()
            ->toggleable()
            ->tooltip(function ($record) {
                if ($record) {
                    return isset($record->extra['satisfaction_comment']) ? $record->extra['satisfaction_comment'] : 'No comment';
                } else {
                    return $record->satisfaction_score;
                }
            })
            ->formatStateUsing(fn($record) => str_repeat('✮', number_format($record->satisfaction_score, 0)))
            ->color(fn($record) => $record->satisfaction_score >= 4 ? 'success' : ($record->satisfaction_score >= 2 ? 'warning' : 'danger'));
    }

    /**
     * @return TextColumn
     */
    public static function showEffectiveness(): TextColumn
    {
        return TextColumn::make('effectiveness')
            ->label('Impact')
            ->sortable()
            ->toggleable()
            ->tooltip(fn($record) => $record ? $record->effectiveness : 'N/A')
            ->formatStateUsing(fn($record) => str_repeat('✮', number_format($record->effectiveness, 0)))
            ->color(fn($record) => $record && $record->effectiveness >= 4 ? 'success' : ($record->effectiveness >= 2 ? 'warning' : 'danger'));
    }


    /**
     * @return BadgeColumn
     */
    public static function showCompletionDate(): BadgeColumn
    {
        return BadgeColumn::make('completion_date')
            ->label('Completion Date')
            ->sortable()
            ->dateTime('M d, Y H:i')
            ->toggleable()
            ->tooltip(fn($record) => $record->status === 'closed' && isset($record->extra['timeToCloseInSeconds'])
                ? 'Time to close: ' . gmdate("H:i:s", $record->extra['timeToCloseInSeconds'])
                : null
            )
            ->color(fn($record) => $record && $record->completion_date < now() ? 'danger' : 'success');
    }

    /**
     * @return BadgeColumn
     */
    public static function showCompletionDeadline(): BadgeColumn
    {
        return BadgeColumn::make('completion_deadline')
            ->label('Deadline')
            ->sortable()
            ->dateTime('M d, Y H:i')
            ->toggleable()
            ->tooltip(fn($record) => self::calculateDeadlineDelta($record))
            ->color(fn($record) => self::calculateDeadlineColoring($record))
            ->icon('heroicon-o-calendar');
    }


    /**
     * @return TextColumn
     */
    public static function showAssigneeName(): TextColumn
    {
        return TextColumn::make('assignee.full_name')
            ->label('Assignee')
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->limit(50)
            ->tooltip(fn($record) => $record && $record->assignee ? $record->assignee->full_name : 'Not Assigned!')
            ->color('secondary');
    }

    /**
     * @return BadgeColumn
     */
    public static function showStatus(): BadgeColumn
    {
        return BadgeColumn::make('status')
            ->label('Status')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->colors(['success' => 'open', 'warning' => 'in-progress', 'danger' => 'closed'])
            ->icon('heroicon-o-status-online');
    }

    /**
     * @return BadgeColumn
     */
    public static function showSubject(): BadgeColumn
    {
        return BadgeColumn::make('request_subject')
            ->label('Subject')
            ->sortable()
            ->searchable()
            ->toggleable()
            ->limit(50)
            ->tooltip(fn($record) => $record->request_subject);
    }

    /**
     * @return TextColumn
     */
    public static function showArea(): TextColumn
    {
        return TextColumn::make('request_area')
            ->label('Request Area')
            ->sortable()
            ->toggleable()
            ->tooltip(fn($record) => $record ? $record->request_type : 'N/A')
            ->formatStateUsing(fn($record) => $record ? Ticket::$requestAreaOptions[$record->request_type][$record->request_area] ?? 'Other' : 'N/A')            ->searchable()
            ->color('info');
    }

    /**
     * @return TextColumn
     */
    public static function showRequesterName(): TextColumn
    {
        return TextColumn::make('requester.fullName')
            ->label('Requester')
            ->searchable(['forename', 'surname'])
            ->toggleable()
            ->limit(50)
            ->tooltip(fn($record) => $record->requester->fullName)
            ->color('secondary');
    }

    /**
     * @return TextColumn
     */
    public static function showDepartment(): TextColumn
    {
        return TextColumn::make('extra.department')
            ->label('Department')
            ->formatStateUsing(fn(Model $record) => $record && isset($record->extra['department'])
                ? (array_key_exists($record->extra['department'], DepartmentDetails::$departments)
                    ? DepartmentDetails::getName($record->extra['department'])
                    : $record->extra['department'])
                : 'N/A'
            )
            ->toggleable()
            ->searchable('extra->department')
            ->color('warning');
    }


    /**
     * @return BadgeColumn
     */
    public static function showPriorityLevel(): BadgeColumn
    {
        return BadgeColumn::make('priority')
            ->label('Priority')
            ->colors([
                'success' => 'low',
                'warning' => 'medium',
                'danger' => 'high',
            ])
            ->toggleable()
            ->sortable()
            ->searchable()
            ->icon('heroicon-o-exclamation-circle');
    }

    /**
     * @return TextColumn
     */
    public static function showTicketId(): TextColumn
    {
        return TextColumn::make('id')
            ->label('Ticket ID')
            ->color(fn($record) => ($record->completion_deadline && $record->completion_date && $record->completion_date > $record->completion_deadline)
                ? 'danger'
                : 'secondary'
            )
            ->size('sm')
            ->copyable()
            ->copyableState(fn(string $state, $record): string => "PS-T-" . $record->created_at->format('Y-m') . "-" . str_pad($state, 4, '0', STR_PAD_LEFT)
            )
            ->sortable()
            ->searchable()
            ->toggleable()
            ->tooltip('Click to copy Ticket ID')
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query->whereRaw("CONCAT('PS-T-', DATE_FORMAT(created_at, '%Y-%m'), '-', LPAD(id, 4, '0')) LIKE ?", ["%{$search}%"]);
            })
            ->formatStateUsing(function ($record) {
                return "PS-T-" . $record->created_at->format('Y-m') . "-" . str_pad($record->id, 4, '0', STR_PAD_LEFT);
            });
    }

    /**
     * @param $record
     * @return string|null
     */
    public static function calculateDeadlineDelta($record): ?string
    {
        if ($record && $record->completion_deadline) {
            if ($record->completion_date) {
                $comparison = $record->completion_date->diff($record->completion_deadline);
                return $record->completion_date->gt($record->completion_deadline) ? "Overdue by {$comparison->days} days, {$comparison->h} hours, {$comparison->i} minutes" : "Completed early by {$comparison->days} days, {$comparison->h} hours, {$comparison->i} minutes";
            } else {
                $comparison = now()->diff($record->completion_deadline);
                return now()->gt($record->completion_deadline) ? "Overdue by {$comparison->days} days, {$comparison->h} hours, {$comparison->i} minutes" : "Due in {$comparison->days} days, {$comparison->h} hours, {$comparison->i} minutes";
            }
        }
        return null;
    }

    /**
     * @param $record
     * @return string
     */
    public static function calculateDeadlineColoring($record): string
    {
        if ($record && $record->completion_deadline) {
            if ($record->completion_date) {
                return $record->completion_date->gt($record->completion_deadline) ? 'danger' : 'success';
            } else {
                return now()->gt($record->completion_deadline) ? 'danger' : 'primary';
            }
        }
        return 'secondary';
    }
}
