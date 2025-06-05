<?php

namespace App\Http\Livewire;

use App\Models\Suggestion;
use App\Models\User;
use App\Notifications\NotifyAdminSuggestion;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Notification;


class SuggestionSurvey extends Component
{

    use WithFileUploads;


    public $names;
    public $presenter;
    public $scopes;
    public $title;
    public $suggestion;
    public $advantage;
    public $method;
    public $estimation;
    public $estimate;
    public $photo;


    public $totalSteps;
    public $currentStep;
    public $nextStep;
    public $previousStep;


    protected $messages = [
        'names.min' => "At least 3 characters are needed!",
        'title.min' => "At least 3 characters are needed!",
        'advantage.min' => "At least 3 characters are needed!",
        'method.min' => "At least 3 characters are needed!",
        'suggestion.min' => "At least 100 characters are needed!",
    ];


    public function mount()
    {
        $this->currentStep = 1;
        $this->totalSteps = 9;
    }

    public function render()
    {
        return view('livewire.suggestion-survey');
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'nullable|image|max:6000', // 5.5MB Max
        ]);
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
        $selectingInputs = [
            2 => 'presenter',
            3 => 'scopes',
            8 => 'estimation',
        ];

        $commentInputs = [
            1 => 'names',
            4 => 'title',
            6 => 'advantage',
            7 => 'method',
        ];

        foreach ($commentInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|string|min:3']);
            }
        }

        if ($this->currentStep == 5) {
            $this->validate(['suggestion' => 'required|string|min:100']);
        }

        foreach ($selectingInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|digits:1']);
            }
        }
    }

    public function register()
    {
        if ($this->currentStep == 9) {
            $this->updatedPhoto();
        }


//        $adminHRs = User::showHr();

        $fileName = $this->photo ? (uniqid() . $this->photo->getClientOriginalName()) : '';

        if ($this->photo) {
            $this->photo->storeAs('suggestions', $fileName, 'suggestion_image');
        }


        $adminHRs = User::where('email', 'arashrostami@time-gr.com')
//            ->orWhere('email', 'mirsanjari@persolco.com')
            ->get();

        $estimate = ($this->estimation == 0 or $this->estimation == 2) ? 'N/A' : $this->estimate;


        $inputs = [
            'name' => $this->names,
            'presenter' => $this->presenter,
            'scope' => $this->scopes,
            'title' => $this->title,
            'suggestion' => $this->suggestion,
            'advantage' => $this->advantage,
            'method' => $this->method,
            'estimate' => $estimate,
            'user_id' => auth()->user()->id,
            'photo' => '/img/suggestions/' . $fileName,
        ];

        $suggestion = Suggestion::create($inputs);

        try {
            Notification::send($adminHRs, (new NotifyAdminSuggestion( $inputs)));
            //trigger notification
            showFlash("success", "Your suggestion was successfully sent.");
            $this->reset();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            showFlash("error", "Your suggestion could NOT be sent!");
        }
        return redirect()->route('user.panel');
    }
}
