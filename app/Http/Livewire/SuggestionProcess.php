<?php

namespace App\Http\Livewire;

use App\Http\Livewire\suggestion\ReviewSubmission;
use App\Http\Livewire\suggestion\SuggestionData;
use App\Http\Livewire\suggestion\SuggestionNotifier;
use App\Http\Livewire\suggestion\SuggestionSubmission;
use App\Http\Livewire\suggestion\SuggestionValidation;
use App\Models\Review;
use App\Models\Suggestion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class SuggestionProcess extends Component
{
    use WithFileUploads;
    use WithPagination;


    public array $suggestion = [];
    protected array $rules;
    protected array $messages;
    protected SuggestionData $suggestionData;
    protected SuggestionSubmission $suggestionSubmission;
    protected ReviewSubmission $reviewSubmission;


    public function abortSuggestion($id)
    {
        $this->suggestionSubmission->abort($id, $this->suggestion);
    }

    public function boot()
    {
        $this->rules = SuggestionValidation::rules();
        $this->messages = SuggestionValidation::messages();
        $this->suggestionData = new SuggestionData();
        $this->suggestionSubmission = new SuggestionSubmission();
        $this->reviewSubmission = new ReviewSubmission();
    }

    public function editSuggestion()
    {
        $this->suggestionSubmission->edit($this->suggestion);
    }

    public function endProcess($review, $dep)
    {
        $this->suggestion['process']['review'] = $review;
        $this->suggestion['process']['dep'] = $dep;

        $this->reviewSubmission->terminate($this->suggestion);
    }


    public function giveResponseTo($suggestionId)
    {
        $this->suggestionData->showResponseBox($this->suggestion, $suggestionId);
    }


    public function mount(SuggestionData $suggestionData)
    {
        $suggestionData->initialize($this->suggestion);
    }


    public function render()
    {
        $suggestionWithReview = $this->suggestionData->fetch();

        return view('livewire.suggestion-process', compact('suggestionWithReview'));
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
    }


    public function selectReview($id, $private = null)
    {
        $this->suggestion['selectedRecord'] = [];
        $this->suggestion['selectedRecord']['private'] = $private;

        $this->suggestionSubmission->selectRecord($this->suggestion, $id, Review::class);
    }


    public function selectSuggestion($id)
    {
        $this->suggestionSubmission->selectRecord($this->suggestion, $id, Suggestion::class);
    }


    public function showConfirmBox($text = null, $confirmedMethod = null)
    {
        $this->suggestionData->showConfirmationBox($this->suggestion, $text, $confirmedMethod);
    }


    public function submitResponse()
    {

        $validationResult = SuggestionValidation::validateResponse($this, $this->suggestion);

        if ($validationResult) {

            (new ReviewSubmission())->create($this->suggestion);

            $this->suggestionSubmission->updateStage($this->suggestion);

            showFlash("success", "Your feedback was successfully sent.");

            return redirect()->route('user.panel');
        }
    }

    public function submitSuggestion()
    {
        // to remove those departments changed
        $this->suggestionData->unsetExtras($this->suggestion);

        // validate to see if all input are filled
        $this->validate();

        // ensure user submitted without considering other departments
        if ($this->suggestionData->isDepartmentSelected($this->suggestion)) {
            return $this->suggestionData->showConfirmationBox(
                $this->suggestion,
                'آیا مطمئن هستید که می‌خواهید فرم را بدون ذکر نام واحد(های) ذینفع ارسال کنید؟',
                'submitSuggestion'
            );
        }

        // store PDF or JPG files
        $this->suggestionSubmission->storeAttachment($this->suggestion, $this);

        // save suggestion
        list($inputs, $suggestion) = $this->suggestionSubmission->create($this->suggestion);

        // save review if submitted
        $this->reviewSubmission->insert($this->suggestion, $suggestion);

        //save notification
        if (SuggestionNotifier::sendNotification($inputs)) {
            $this->resetForm();
        }

        return redirect()->route('user.panel');
    }


    public function toggleEditing()
    {
        $this->suggestionSubmission->toggle($this->suggestion);
    }

    public function updatedSuggestionAttachment()
    {
        SuggestionValidation::validateAttachment($this);
    }


    public function updatedSuggestionDepartments()
    {
        $this->suggestionSubmission->getViews($this->suggestion);
    }

    public function updatedSuggestionSelfFill()
    {
        $this->suggestionSubmission->getViews($this->suggestion);
    }
}
