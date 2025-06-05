<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\Pages\Admin;
use App\Filament\Resources\ProfileResource\RelationManagers;
use App\Filament\Resources\ProfileResource\Widgets\StatsOverview;
use App\Models\Profile;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Morilog\Jalali\Jalalian;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {

        list($birthYear, $years, $months, $days) = Admin::getDaysMonthsYears();

        return $form
            ->schema(
                Tabs::make('Heading')
                    ->tabs([
                        Tabs\Tab::make('Employment')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getUser(),
                                    Admin::getPersonnelCode(),
                                    Admin::getEmploymentType(),
                                    Admin::getEmploymentStatus(),
                                    Admin::getDepartment(),
                                    Admin::getPosition(),
                                    Admin::getInsurance(),
                                    Admin::getWorkExperience(),
                                ])->columns(2)
                            ]),
                        Tabs\Tab::make('Personal')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getIdCardNum(),
                                    Admin::getIdBookletNum(),
                                    Admin::getGender(),
                                    Admin::getMaritalStatus(),
                                    Admin::getNumOfChildren(),
                                ])->columns(3),
                                Card::make()->schema([
                                    Admin::getDegree(),
                                    Admin::getField(),
                                ])->columns(2),
                                Card::make()->schema([
                                    Admin::getLandline(),
                                    Admin::getCellphone(),
                                    Admin::getEmergencyPhone(),
                                    Admin::getEmergencyRel(),
                                    Admin::getLicensePlate(),
                                    Admin::getZipCode()
                                ])->columns(3),
                                Card::make()->schema([
                                    Admin::getAddress(),
                                    Admin::getAccessibility()
                                ])->columns(2),

                            ]),
                        Tabs\Tab::make('Extra')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getBirthDay($days),
                                    Admin::getBirthMonth($months),
                                    Admin::getBirthYear($birthYear)
                                ])->columns(3),
                                Card::make()->schema([
                                    Admin::getStartDay($days),
                                    Admin::getStartMonth($months),
                                    Admin::getStartYear($years)
                                ])->columns(3),
                                Card::make()->schema([
                                    Admin::getEndDay($days),
                                    Admin::getEndMonth($months),
                                    Admin::getEndYear($years)
                                ])->columns(3),
                                Card::make()->schema([
                                    Admin::getInterests(),
                                    Admin::getFavColors(),
                                    Admin::getProfileImage()
                                ])->columns(3),

                            ]),
                        Tabs\Tab::make('Documents')
                            ->schema([
                                Card::make()->schema([
                                    Admin::getUploadingFiles()
                                ])->columns(1)
                            ]),
                    ])

            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Admin::showPersonnelCode(),
                Admin::showImage(),
                Admin::showFullName(),
                Admin::showGender(),
                Admin::showIdCardNum(),
                Admin::showIdBookletNum(),
                Admin::showBirthDate(),
                Admin::showEmploymentStatus(),
                Admin::showStartDate(),
                Admin::showEmploymentType(),
                Admin::showDepartment(),
                Admin::showPosition(),
                Admin::showInsurance(),
                Admin::showWorkExperience(),
                Admin::showDegree(),
                Admin::showFieldOfStudy(),
                Admin::showMaritalStatus(),
                Admin::showNumberOfChildren(),
                Admin::showLandlineNum(),
                Admin::showCellphoneNum(),
                Admin::showEmergencyNum(),
                Admin::showEmergencyRelationship(),
                Admin::showLicensePlate(),
                Admin::showZipCode(),
                Admin::showAddress(),
                Admin::showAccessibility(),
                Admin::showInterest(),
                Admin::showFavColors(),
                Admin::showEndDate(),
            ])
            ->poll('10s')
            ->filters([
                Admin::filterDepartment(),
                Admin::filterEmploymentStatus(),
                Admin::filterEmploymentType()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
