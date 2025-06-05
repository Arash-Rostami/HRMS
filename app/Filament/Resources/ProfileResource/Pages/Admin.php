<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Services\Date;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Morilog\Jalali\Jalalian;

class Admin
{


    public static function filterEmploymentStatus(): SelectFilter
    {
        return SelectFilter::make('employment_status')
            ->options([
                'probational' => 'Probationary',
                'working' => 'Working',
                'terminated' => 'Terminated',
            ]);
    }

    public static function filterEmploymentType(): SelectFilter
    {
        return SelectFilter::make('employment_type')
            ->options([
                'parttime' => 'Part-time',
                'fulltime' => 'Full-time',
                'contract' => 'Contract',
            ]);
    }

    public static function filterDepartment(): SelectFilter
    {
        return SelectFilter::make('department')
            ->options([
                'MG' => 'MG',
                'HR' => 'HR',
                'MA' => 'MA',
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
                'HC' => 'HC',
                'SO' => 'SO',
                'PERSORE' => 'PERSORE'
            ]);
    }


    /**
     * @return array[]
     */
    public static function getDaysMonthsYears(): array
    {
        $currentYear = Jalalian::now()->getYear();
        $birthYear = [];
        $years = [];
        $months = [];
        $days = [];


        for ($day = 1; $day <= 31; $day++) {
            $days[$day] = (string)$day;
        }

        for ($month = 1; $month <= 12; $month++) {
            $months[$month] = (string)$month;
        }

        for ($year = 1330; $year <= $currentYear; $year++) {
            $birthYear[$year] = (string)$year;
        }

        for ($year = 1375; $year <= $currentYear; $year++) {
            $years[$year] = (string)$year;
        }
        return array($birthYear, $years, $months, $days);
    }

    /**
     * @return Select
     */
    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->label('User')
            ->required()
            ->autofocus()
            ->relationship('user', 'id', fn(Builder $query) => $query->where('forename', 'not like', 'Guest%')->where('status', 'active')->orderBy('surname')->orderBy('forename'))
            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->surname}, {$record->forename} ");
    }

    /**
     * @return TextInput
     */
    public static function getPersonnelCode(): TextInput
    {
        return TextInput::make('personnel_id')
            ->label('Personnel ID')
            ->required()
            ->numeric()
            ->placeholder('type in English');
    }

    /**
     * @return Select
     */
    public static function getEmploymentType(): Select
    {
        return Select::make('employment_type')
            ->label('Employment Type')
            ->required()
            ->options([
                'fulltime' => 'Full-time',
                'parttime' => 'Part-time',
                'contract' => 'Contract',
            ]);
    }

    /**
     * @return Select
     */
    public static function getEmploymentStatus(): Select
    {
        return Select::make('employment_status')
            ->label('Employment Status')
            ->required()
            ->options([
                'probational' => 'Probational',
                'working' => 'Working',
                'terminated' => 'Terminated',
            ]);
    }

    /**
     * @return Select
     */
    public static function getDepartment(): Select
    {
        return Select::make('department')
            ->required()
            ->options([
                'MG' => 'MG - 🚫 deprecated',
                'HR' => 'HR - Human Resources',
                'MA' => 'MA - Management',
                'AS' => 'AS - Administration & Support',
                'CM' => 'CM - Commercial Import Operation',
                'CP' => 'CP - Celluloid Products',
                'AC' => 'AC - Accounting',
                'PS' => 'PS - Planning & System',
                'WP' => 'WP - Wood Products',
                'MK' => 'MK - Marketing',
                'CH' => 'CH - Chemical & Polymer Products',
                'SP' => 'SP - Sales Platform',
                'CX' => 'CX - Commercial Export Operation',
                'BD' => 'BD - Business Development',
                'HC' => 'HC - Human Capital',
                'SO' => 'SO - Solar Panel',
                'PERSORE' => 'PERSORE - Mining Department'
            ]);
    }

    /**
     * @return Select
     */
    public static function getPosition(): Select
    {
        return Select::make('position')
            ->required()
            ->options([
                'manager' => 'Manager',
                'supervisor' => 'Supervisor',
                'senior' => 'Senior',
                'expert' => 'Expert',
                'employee' => 'Employee',
            ]);
    }

    /**
     * @return TextInput
     */
    public static function getInsurance(): TextInput
    {
        return TextInput::make('insurance')
            ->numeric()
            ->placeholder('# of years');
    }

    /**
     * @return TextInput
     */
    public static function getWorkExperience(): TextInput
    {
        return TextInput::make('work_experience')
            ->label('Work Experience')
            ->placeholder('# of years');
    }

    /**
     * @return TextInput
     */
    public static function getIdCardNum(): TextInput
    {
        return TextInput::make('id_card_number')
            ->label('ID Card Number')
            ->autofocus()
            ->numeric()
            ->placeholder('شماره کارت ملی');
    }

    /**
     * @return TextInput
     */
    public static function getIdBookletNum(): TextInput
    {
        return TextInput::make('id_booklet_number')
            ->label('ID Booklet Number')
            ->numeric()
            ->placeholder('شماره شناسنامه');
    }

    /**
     * @return Select
     */
    public static function getGender(): Select
    {
        return Select::make('gender')
            ->options([
                'female' => 'Female',
                'male' => 'Male'
            ]);
    }

    /**
     * @return Select
     */
    public static function getMaritalStatus(): Select
    {
        return Select::make('marital_status')
            ->label('Marital Status')
            ->options([
                'single' => 'Single',
                'married' => 'Married',
            ]);
    }

    /**
     * @return TextInput
     */
    public static function getNumOfChildren(): TextInput
    {
        return TextInput::make('number_of_children')
            ->numeric()
            ->placeholder('#');
    }

    /**
     * @return Select
     */
    public static function getDegree(): Select
    {
        return Select::make('degree')
            ->options([
                'undergraduate' => 'Undergraduate',
                'graduate' => 'Graduate',
                'postgraduate' => 'Postgraduate',
            ]);
    }

    /**
     * @return TextInput
     */
    public static function getField(): TextInput
    {
        return TextInput::make('field')
            ->placeholder('of study');
    }

    /**
     * @return TextInput
     */
    public static function getLandline(): TextInput
    {
        return TextInput::make('landline')
            ->autofocus()
            ->tel()
            ->placeholder('#');
    }

    /**
     * @return TextInput
     */
    public static function getCellphone(): TextInput
    {
        return TextInput::make('cellphone')
            ->tel()
            ->placeholder('#');
    }

    /**
     * @return TextInput
     */
    public static function getEmergencyPhone(): TextInput
    {
        return TextInput::make('emergency_phone')
            ->tel()
            ->placeholder('#');
    }

    /**
     * @return TextInput
     */
    public static function getEmergencyRel(): TextInput
    {
        return TextInput::make('emergency_relationship');
    }

    /**
     * @return TextInput
     */
    public static function getLicensePlate(): TextInput
    {
        return TextInput::make('license_plate');
    }

    /**
     * @return TextInput
     */
    public static function getZipCode(): TextInput
    {
        return TextInput::make('zip_code')
            ->placeholder('#');
    }

    /**
     * @return MarkdownEditor
     */
    public static function getAddress(): MarkdownEditor
    {
        return MarkdownEditor::make('address')
            ->disableAllToolbarButtons();
    }

    /**
     * @return MarkdownEditor
     */
    public static function getAccessibility(): MarkdownEditor
    {
        return MarkdownEditor::make('accessibility')
            ->disableAllToolbarButtons();
    }

    /**
     * @param array $days
     * @return Select
     */
    public static function getBirthDay(array $days): Select
    {
        return Select::make('birthDay')
            ->label('Birth Day')
            ->autofocus()
            ->options($days);
    }

    /**
     * @param array $months
     * @return Select
     */
    public static function getBirthMonth(array $months): Select
    {
        return Select::make('birthMonth')
            ->label('Birth Month')
            ->options($months);
    }

    /**
     * @param array $birthYear
     * @return Select
     */
    public static function getBirthYear(array $birthYear): Select
    {
        return Select::make('birthYear')
            ->label('Birth Year')
            ->options($birthYear);
    }

    /**
     * @param array $days
     * @return Select
     */
    public static function getStartDay(array $days): Select
    {
        return Select::make('startDay')
            ->label('Start Day')
            ->required()
            ->options($days);
    }

    /**
     * @param array $months
     * @return Select
     */
    public static function getStartMonth(array $months): Select
    {
        return Select::make('startMonth')
            ->label('Start Month')
            ->required()
            ->options($months);
    }

    /**
     * @param array $years
     * @return Select
     */
    public static function getStartYear(array $years): Select
    {
        return Select::make('startYear')
            ->label('Start Year')
            ->required()
            ->options($years);
    }

    /**
     * @param array $days
     * @return Select
     */
    public static function getEndDay(array $days): Select
    {
        return Select::make('endDay')
            ->label('End Day')
            ->options($days);
    }

    /**
     * @param array $months
     * @return Select
     */
    public static function getEndMonth(array $months): Select
    {
        return Select::make('endMonth')
            ->label('End Month')
            ->options($months);
    }

    /**
     * @param array $years
     * @return Select
     */
    public static function getEndYear(array $years): Select
    {
        return Select::make('endYear')
            ->label('End Year')
            ->options($years);
    }

    /**
     * @return MarkdownEditor
     */
    public static function getInterests(): MarkdownEditor
    {
        return MarkdownEditor::make('interests')
            ->disableAllToolbarButtons();
    }

    /**
     * @return MarkdownEditor
     */
    public static function getFavColors(): MarkdownEditor
    {
        return MarkdownEditor::make('favorite_colors')
            ->label('Fav Colors')
            ->disableAllToolbarButtons();
    }

    /**
     * @return FileUpload
     */
    public static function getProfileImage(): FileUpload
    {
        return FileUpload::make('image')
            ->image()
            ->disk('filament')
            ->directory('/img/user/profiles/')
            ->maxSize(1024 / 4)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])
            ->enableOpen()
            ->enableDownload()
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string)Str::of($file->getClientOriginalName())->prepend('HR-profile-image-');
            });
    }

    /**
     * @return FileUpload
     */
    public static function getUploadingFiles(): FileUpload
    {
        return FileUpload::make('attachments')
            ->label('Uploading Files')
            ->multiple()
            ->disk('filament')
            ->directory('/docs/profile/')
            ->maxSize(1024)
            ->enableOpen()
            ->enableDownload()
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                $uniqueName = 'HR-profile-doc-' . time() . '-' . Str::random(8);
                return (string)Str::of($file->getClientOriginalName())->prepend($uniqueName);
            });
    }


    /**
     * @return BadgeColumn
     */
    public static function showPersonnelCode(): BadgeColumn
    {
        return BadgeColumn::make('personnel_id')
            ->sortable()
            ->label('Personnel #')
            ->color('primary')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showFullName(): TextColumn
    {
        return TextColumn::make('user.fullname')
            ->sortable(['forename', 'surname'])
            ->label('Name')
            ->searchable(['forename', 'surname'])
            ->size('sm')
            ->tooltip(fn(Model $record): string => $record->user->email);
    }

    /**
     * @return IconColumn
     */
    public static function showGender(): IconColumn
    {
        return IconColumn::make('gender')
            ->sortable()
            ->options(['heroicon-o-user'])
            ->colors([
                'success' => 'male',
                'danger' => 'female',
            ])
            ->toggleable()
            ->searchable()
            ->tooltip(fn(Model $record): string => " {$record->gender}");
    }

    /**
     * @return ImageColumn
     */
    public static function showImage(): ImageColumn
    {
        return ImageColumn::make('image')
            ->label('Photo')
            ->disk('filament')
            ->extraImgAttributes(function (Model $record) {
                return [
                    'oncontextmenu' => 'showImage("' . $record->image . '", "_blank")',
                    'class' => 'pointer',
                    'title' => 'Right click to enlarge'
                ];
            })
            ->square()
            ->toggleable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showIdCardNum(): BadgeColumn
    {
        return BadgeColumn::make('id_card_number')
            ->label('ID Card #')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm')
            ->tooltip(fn(Model $record): string => "کارت ملی");
    }

    /**
     * @return BadgeColumn
     */
    public static function showIdBookletNum(): BadgeColumn
    {
        return BadgeColumn::make('id_booklet_number')
            ->label('ID Booklet #')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm')
            ->tooltip(fn(Model $record): string => "شناسنامه");
    }

    /**
     * @return BadgeColumn
     */
    public static function showBirthDate(): BadgeColumn
    {
        return BadgeColumn::make('birthdate')
            ->sortable()
            ->searchable()
            ->getStateUsing(fn(Model $record) => !is_null($record->birthdate) ? Date::convertToFarsiWithoutTime($record->birthdate) : '')
            ->tooltip(fn(Model $record) => !is_null($record->birthdate) ? Carbon::parse($record->birthdate)->format('Y-m-d') : '');
    }

    /**
     * @return BadgeColumn
     */
    public static function showEmploymentStatus(): BadgeColumn
    {
        return BadgeColumn::make('employment_status')
            ->label('Employment Status')
            ->sortable()
            ->enum([
                'probational' => 'Probationary',
                'working' => 'Working',
                'terminated' => 'Terminated',
            ])
            ->colors([
                'warning' => 'probational',
                'success' => 'working',
                'danger' => 'terminated'
            ])
            ->searchable()
            ->size('sm');
    }

    /**
     * @return BadgeColumn
     */
    public static function showStartDate(): BadgeColumn
    {
        return BadgeColumn::make('start_date')
            ->sortable()
            ->label('Start Date')
            ->searchable()
            ->getStateUsing(fn(Model $record) => Date::convertToFarsiWithoutTime($record->start_date))
            ->tooltip(fn(Model $record) => Carbon::parse($record->start_date)->diffInDays() . " days ago");
    }

    /**
     * @return BadgeColumn
     */
    public static function showEmploymentType(): BadgeColumn
    {
        return BadgeColumn::make('employment_type')
            ->label('Employment Type')
            ->sortable()
            ->enum([
                'parttime' => 'Part-time',
                'fulltime' => 'Full-time',
                'contract' => 'Contract',
            ])
            ->colors([
                'warning' => 'parttime',
                'success' => 'fulltime',
                'danger' => 'contract',
            ])
            ->searchable()
            ->size('sm');
    }

    /**
     * @return BadgeColumn
     */
    public static function showDepartment(): BadgeColumn
    {
        return BadgeColumn::make('department')
            ->sortable()
            ->color('secondary')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return BadgeColumn
     */
    public static function showPosition(): BadgeColumn
    {
        return BadgeColumn::make('position')
            ->sortable()
            ->color('secondary')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showInsurance(): TextColumn
    {
        return TextColumn::make('insurance')
            ->toggleable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showWorkExperience(): TextColumn
    {
        return TextColumn::make('work_experience')
            ->sortable()
            ->toggleable()
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showDegree(): BadgeColumn
    {
        return BadgeColumn::make('degree')
            ->sortable()
            ->enum([
                'undergraduate' => 'Under-graduate',
                'graduate' => 'Graduate',
                'postgraduat    e' => 'Post-graduate',
            ])
            ->color('secondary')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showFieldOfStudy(): TextColumn
    {
        return TextColumn::make('field')
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showMaritalStatus(): BadgeColumn
    {
        return BadgeColumn::make('marital_status')
            ->sortable()
            ->enum([
                'single' => 'Single',
                'married' => 'Married',
            ])
            ->colors([
                'warning' => 'married',
                'success' => 'single',
            ])
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showNumberOfChildren(): TextColumn
    {
        return TextColumn::make('number_of_children')
            ->sortable()
            ->label('Child(ren)')
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showLandlineNum(): BadgeColumn
    {
        return BadgeColumn::make('landline')
            ->label('Landline #')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return BadgeColumn
     */
    public static function showCellphoneNum(): BadgeColumn
    {
        return BadgeColumn::make('cellphone')
            ->label('Cellphone #')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return BadgeColumn
     */
    public static function showEmergencyNum(): BadgeColumn
    {
        return BadgeColumn::make('emergency_phone')
            ->label('Emergency phone #')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showEmergencyRelationship(): TextColumn
    {
        return TextColumn::make('emergency_relationship')
            ->toggleable()
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showLicensePlate(): BadgeColumn
    {
        return BadgeColumn::make('license_plate')
            ->color('text-gray-500')
            ->searchable()
            ->size('sm');
    }

    /**
     * @return TextColumn
     */
    public static function showZipCode(): TextColumn
    {
        return TextColumn::make('zip_code')
            ->sortable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showAddress(): TextColumn
    {
        return TextColumn::make('address')
            ->toggleable();
    }

    /**
     * @return TextColumn
     */
    public static function showAccessibility(): TextColumn
    {
        return TextColumn::make('accessibility')
            ->toggleable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showInterest(): TextColumn
    {
        return TextColumn::make('interests')
            ->toggleable()
            ->searchable();
    }

    /**
     * @return TextColumn
     */
    public static function showFavColors(): TextColumn
    {
        return TextColumn::make('favorite_colors')
            ->toggleable()
            ->searchable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showEndDate(): BadgeColumn
    {
        return BadgeColumn::make('end_date')
            ->sortable()
            ->label('End Date')
            ->date()
            ->toggleable()
            ->searchable()
            ->formatStateUsing(fn(Model $record) => !is_null($record->end_date) ? Date::convertToFarsiWithoutTime($record->end_date) : '')
            ->tooltip(fn(Model $record) => Carbon::parse($record->end_date)->diffInDays() . " days ago");
    }
}
