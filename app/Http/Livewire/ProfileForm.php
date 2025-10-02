<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Profile\WithValidation;
use App\Models\Profile;
use App\Services\DepartmentDetails;
use App\Services\StepChecker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;
use Morilog\Jalali\Jalalian;


class ProfileForm extends Component
{
    use WithFileUploads;
    use StepChecker;
    use WithValidation;

    public $personnelId;
    public $email;
    public $image;
    public $gender;
    public $employmentType;
    public $maritalStatus;
    public $numberOfChildren;
    public $employmentStatus;
    public $idCardNumber;
    public $idBookletNumber;
    public $degree;
    public $field;
    public $thisYear;
    public $birthdate;
    public $birthYear;
    public $birthMonth;
    public $birthDay;
    public $landline;
    public $cellphone;
    public $licensePlate;
    public $zipCode;
    public $address;
    public $accessibility;
    public $department;
    public $position;
    public $insurance;
    public $emergencyPhone;
    public $emergencyRelationship;
    public $startDate;
    public $startYear;
    public $startMonth;
    public $startDay;
    public $workExperience;
    public $interests;
    public $favoriteColors;
    public $profile;

    public $showDeleteConfirmation;
    public $departmentsList;


    public function cancelProfile()
    {

        $this->unCache();

        // Redirect to a specific route after canceling the form
        return redirect()->to('/main');
    }

    public function deleteImage()
    {
        // First, check if an image exists before attempting to delete it
        if ($this->image) {

            $imagePath = (auth()->user()->profile->image);

            // Delete the image from storage
            if (file_exists(public_path($imagePath))) {
                $this->updateDatabaseAndDeleteImage($imagePath);

                session()->flash('success', 'Image deleted successfully :)');

                return redirect()->to('/main');
            }
        }
    }

    public function hideDeleteConfirmation()
    {
        $this->showDeleteConfirmation = false;
    }

    public function mount()
    {
        $this->email = auth()->user()->email;

        $this->showDeleteConfirmation = false;

        $this->profile = auth()->user()->profile;

        if ($this->profile) {
            // If the profile exists, populate the form fields with the data
            $this->mountProfileData($this->profile);
        }

        $this->departmentsList = DepartmentDetails::getDepartmentsArray();
        $this->thisYear = Jalalian::now()->getYear();

        $this->checkStepCompletionStatus();
    }

    public function render()
    {
        return view('components.user.profile.form');
    }

    public function saveProfile()
    {
        $this->validate();

        $this->concatenateDates();

        $path = $this->saveImage();

        if ($this->profile) {
            // User already has a profile, update it
            $this->updateProfile($path);
        } else {
            // User doesn't have a profile, create a new one
            Profile::create($this->getProfileData($path) + ['user_id' => auth()->user()->id]);
        }

        $this->unCache();

        session()->flash('success', 'اطلاعات شما بدرستی ثبت شد :)');

        return redirect()->to('/main');
    }

    public function showDeleteConfirmation()
    {
        $this->showDeleteConfirmation = true;
    }

    /**
     * @return void
     */
    public function unCache(): void
    {
        Cache::forget('profile_edit_user_' . auth()->user()->id);
    }

    public function updated()
    {
        $this->checkStepCompletionStatus();
    }

    /**
     * @return void
     */
    private function concatenateDates(): void
    {
        if ($this->startYear && $this->startMonth && $this->startDay) {
            $this->startDate = Jalalian::fromFormat('Y/n/j',
                implode('/', [$this->startYear, $this->startMonth, $this->startDay]))->toCarbon();
        }

        if ($this->birthYear && $this->birthMonth && $this->birthDay) {
            $this->birthdate = Jalalian::fromFormat('Y/n/j',
                implode('/', [$this->birthYear, $this->birthMonth, $this->birthDay]))->toCarbon();
        }
    }

    private function getProfileData($path): array
    {
        return [
            'image' => $path,
            'gender' => $this->gender,
            'number_of_children' => $this->numberOfChildren,
            'id_card_number' => $this->idCardNumber,
            'id_booklet_number' => $this->idBookletNumber,
            'marital_status' => $this->maritalStatus,
            'degree' => $this->degree,
            'field' => $this->field,
            'birthdate' => $this->birthdate,
            'landline' => $this->landline,
            'cellphone' => $this->cellphone,
            'zip_code' => $this->zipCode,
            'license_plate' => $this->licensePlate,
            'address' => $this->address,
            'department' => $this->department,
            'insurance' => $this->insurance,
            'emergency_phone' => $this->emergencyPhone,
            'emergency_relationship' => $this->emergencyRelationship,
            'work_experience' => $this->workExperience,
            'interests' => $this->interests,
            'favorite_colors' => $this->favoriteColors,
            'accessibility' => $this->accessibility,
        ];
    }

    /**
     * @return array|string|string[]
     */
    private function getUserName(): string|array
    {
        return str_replace(' ', '', strtolower(auth()->user()->fullname))
            . '_' . time() . '.' . $this->image->getClientOriginalExtension();
    }

    /**
     * @param $profile
     * @return void
     */
    private function mountProfileData($profile): void
    {
        $dateFields = ['birthdate', 'start_date'];
        $fields = [
            'personnel_id', 'gender', 'employment_type', 'marital_status', 'number_of_children',
            'employment_status', 'id_card_number', 'id_booklet_number', 'degree', 'field',
            'landline', 'cellphone', 'license_plate', 'zip_code', 'address', 'department',
            'position', 'insurance', 'emergency_phone', 'emergency_relationship',
            'work_experience', 'interests', 'favorite_colors', 'image', 'accessibility'
        ];

        foreach ($fields as $field) {
            // Convert snake_case field name to camelCase
            $camelField = lcfirst(str_replace('_', '', ucwords($field, '_')));

            $this->{$camelField} = $profile->$field;
        }

        foreach ($dateFields as $dateField) {
            if ($profile->$dateField) {
                $date = Jalalian::fromCarbon(Carbon::parse($profile->$dateField));
                $propertyName = str_replace(['_date', 'date'], '', $dateField);
                $this->{$propertyName . 'Year'} = $date->getYear();
                $this->{$propertyName . 'Month'} = $date->getMonth();
                $this->{$propertyName . 'Day'} = $date->getDay();
            }
        }
    }

    private function saveImage()
    {
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            // Validate the image if it is uploaded
            $this->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);

            // Generate a custom name for the file (e.g., using the user's name)
            $customFileName = $this->getUserName();

            $path = "img/user/profiles/{$customFileName}";

            // Store the file with the custom name in the /img/user/profiles directory
            $this->image->storeAs('profiles', $customFileName, 'profile_image');

            return $path;
        }

        return $this->profile->image;
    }

    private function updateDatabaseAndDeleteImage($imagePath)
    {
        // Update the database to set 'image' column to null
        auth()->user()->profile->update([
            'image' => null
        ]);

        $this->hideDeleteConfirmation();
    }

    private function updateProfile($path)
    {
        // Prepare profile data to be updated
        $profileData = $this->getProfileData($path);

        // Check if image has changed and update the profile
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            $profileData['image'] = $path;
        }

        $this->profile->update($profileData);
    }
}
