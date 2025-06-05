<?php

namespace App\Http\Livewire;

use App\Models\Survey;
use App\Models\User;
use App\Notifications\NotifyAdminSurvey;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;


class OnboardingSurvey extends Component
{

    public $names;
    public $days;
    public $resource;
    public $team;
    public $manager;
    public $company;
    public $join;
    public $newcomer;
    public $buddy;
    public $roleOfBuddy;
    public $challenge;
    public $stage;
    public $improvement;
    public $suggestion;

    public $totalSteps;
    public $currentStep;
    public $nextStep;
    public $previousStep;


    protected $messages = [
        'names.min' => "At least 3 characters are needed!",
        'resource.required' => "You need to choose a rating first!",
        'team.required' => "You need to choose a rating first!",
        'manager.required' => "You need to choose a rating first!",
        'company.required' => "You need to choose a rating first!",
        'join.required' => "You need to choose a rating first!",
        'newcomer.required' => "You need to choose a rating first!",
        'buddy.required' => "You need to choose a rating first!",
        'roleOfBuddy.min' => "At least 3 characters are needed!",
        'challenge.min' => "At least 3 characters are needed!",
        'stage.min' => "At least 3 characters are needed!",
        'improvement.min' => "At least 3 characters are needed!",
        'suggestion.min' => "At least 3 characters are needed!",
    ];


    public function mount()
    {
        $this->currentStep = 1;
        $this->totalSteps = 14;
    }

    public function render()
    {
        return view('livewire.onboarding-survey');
    }


    public function increase()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;

        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
        $this->nextStep = $this->currentStep + 1;
        $this->previousStep = $this->currentStep - 1;
    }

    public function decrease()
    {
        $this->resetErrorBag();
        $this->currentStep--;

        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
        $this->nextStep = $this->currentStep + 1;
        $this->previousStep = $this->currentStep - 1;
    }

    public function validateData()
    {
        $ratingInputs = [
            3 => 'resource',
            4 => 'team',
            5 => 'manager',
            6 => 'company',
            7 => 'join',
            8 => 'newcomer',
            9 => 'buddy'
        ];

        $commentInputs = [
            1 => 'names',
            10 => 'roleOfBuddy',
            11 => 'challenge',
            12 => 'stage',
            13 => 'improvement',
        ];

        foreach ($commentInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|string|min:3']);
            }
        }

        if ($this->currentStep == 2) {
            $this->validate(['days' => 'required|digits:2']);
        }

        foreach ($ratingInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|digits:1']);
            }
        }
    }

    public function register()
    {
        if ($this->currentStep == 14) {
            $this->validate(['suggestion' => 'required|string|min:3']);
        }

        $adminHRs = User::showHR();
//        $adminHRs = User::where('email', 'a.rostami@persolco.com')->get();

        $inputs = [
            'name' => $this->names,
            'user_id' => auth()->user()->id,
            'days' => $this->days,
            'resource' => $this->resource,
            'team' => $this->team,
            'manager' => $this->manager,
            'company' => $this->company,
            'join' => $this->join,
            'newcomer' => $this->newcomer,
            'buddy' => $this->buddy,
            'roleOfBuddy' => $this->roleOfBuddy,
            'role' => $this->roleOfBuddy,
            'challenge' => $this->challenge,
            'stage' => $this->stage,
            'improvement' => $this->improvement,
            'suggestion' => $this->suggestion
        ];

        $survey = Survey::create($inputs);


        try {
            Notification::send($adminHRs, (new NotifyAdminSurvey($inputs)));
            //trigger notification
            showFlash("success", "Survey was successfully sent.");
            $this->reset();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            showFlash("error", "Survey could NOT be sent!");
        }
        return redirect()->route('user.panel');
    }

}


