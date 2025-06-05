<?php

namespace App\Http\Livewire;

use App\Models\Feedback;
use App\Models\User;
use App\Notifications\NotifyAdminFeedback;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;


class RecruitSurvey extends Component
{

    public $names;
    public $usefulness;
    public $length;
    public $staffInsight;
    public $productInsight;
    public $infoInsight;
    public $itInsight;
    public $interaction;
    public $culture;
    public $experience;
    public $recommendation;
    public $mostFav;
    public $leastFav;
    public $addition;
    public $suggestion;

    public $totalSteps;
    public $currentStep;
    public $nextStep;
    public $previousStep;

    public function mount()
    {
        $this->currentStep = 1;
        $this->totalSteps = 15;
    }

    public function render()
    {
        return view('livewire.recruit-survey');
    }


    public function increase()
    {
//        $this->resetErrorBag();
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
//        $this->resetErrorBag();
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
            2 => 'usefulness',
            3 => 'length',
            4 => 'staffInsight',
            5 => 'productInsight',
            6 => 'infoInsight',
            7 => 'itInsight',
            8 => 'interaction',
            9 => 'culture',
            10 => 'experience',
            11 => 'recommendation'
        ];

        $commentInputs = [
            1 => 'names',
            12 => 'mostFav',
            13 => 'leastFav',
            14 => 'addition',
        ];

        foreach ($commentInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|string|min:3']);
            }
        }

        foreach ($ratingInputs as $key => $val) {
            if ($this->currentStep == $key) {
                $this->validate([$val => 'required|digits:1']);
            }
        }
    }

    public function register()
    {
        if ($this->currentStep == 15) {
            $this->validate(['suggestion' => 'required|string|min:3']);
        }

        $adminHRs = User::showHR();
//        $adminHRs = User::where('email', 'a.rostami@persolco.com')->get();

        $inputs = [
            'name' => $this->names,
            'user_id' => auth()->user()->id,
            'usefulness' => $this->usefulness,
            'length' => $this->length,
            'staff_insight' => $this->staffInsight,
            'product_insight' => $this->productInsight,
            'info_insight' => $this->infoInsight,
            'it_insight' => $this->itInsight,
            'interaction' => $this->interaction,
            'culture' => $this->culture,
            'experience' => $this->experience,
            'recommendation' => $this->recommendation,
            'most_fav' => $this->mostFav,
            'least_fav' => $this->leastFav,
            'addition' => $this->addition,
            'suggestion' => $this->suggestion
        ];

        $feedback = Feedback::create($inputs);


        try {
            Notification::send($adminHRs, (new NotifyAdminFeedback($inputs)));
            //trigger notification
            showFlash("success", "Feedback was successfully sent.");
            $this->reset();
            $this->resetErrorBag();
        } catch (\Exception $e) {
            showFlash("error", "Survey could NOT be sent!");
        }
        return redirect()->route('user.panel');
    }

}
