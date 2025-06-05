<?php

namespace App\Http\Livewire\suggestion;

use App\Models\Suggestion;
use App\Models\User;
use App\Notifications\NotifySuggester;
use Illuminate\Support\Facades\Notification;

class SuggestionSubmission
{

    public $suggestion;

    public function __construct()
    {
        $this->suggestion = new Suggestion();
    }


    public function abort($id, &$suggestion)
    {
        $toBeCancelled = SuggestionData::formatAbortInput($id, $this->suggestion, $suggestion);

        if ($toBeCancelled && $toBeCancelled->abort === 'no') {
            $toBeCancelled->update(['abort' => 'yes']);

            $managerEmails = SuggestionNotifier::getManagerEmails($suggestion);
//            $managerEmails = [auth()->user()->email];


            if (!empty($managerEmails)) {
                Notification::route('mail', $managerEmails)
                    ->notify(new NotifySuggester('abortion', $suggestion));
            }
        }
    }

    public function collect()
    {
        return $this->suggestion->where('user_id', auth()->id())
            ->where('stage', 'under_review')
            ->get();
    }

    public static function countCompletedSuggestion()
    {
        if (isManager()) {
            return Suggestion::where('stage', 'awaiting_decision')->where('abort', 'no')->count();
        }
    }

    public function create(&$suggestion)
    {
        $inputs = (new SuggestionData())->formatSuggestionInputs($suggestion);
        $newSuggestion = Suggestion::create($inputs);

        return [$inputs, $newSuggestion];
    }

    public function edit(&$suggestion)
    {
        $selectedSuggestion = $this->collect()->find($suggestion['editableRecord']);

        if ($selectedSuggestion) {
            $suggestion['isEditing'] = !$suggestion['isEditing'];
            $suggestion['title'] = $selectedSuggestion->title;
            $suggestion['description']['self'] = $selectedSuggestion->description;
            $suggestion['rule'] = $selectedSuggestion->rule;
            $suggestion['purpose'] = $selectedSuggestion->purpose;
        }
    }

    public static function finalizeStage($processedSuggestion, $referredDepartments): void
    {
        $stage = ($processedSuggestion->reviews()
            ->whereIn('department', json_decode($referredDepartments))
            ->where('complete', 'no')
            ->exists()) ? 'accepted' : 'closed';

        // Update suggestion stage
        $processedSuggestion->update(['stage' => $stage]);
    }

    public function getViews(&$suggestion)
    {
        $suggestion['feedback']['team'] = '';
        $suggestion['description']['team'] = '';

        if (!empty($suggestion['departments'])) {
            foreach ($suggestion['departments'] as $dep) {
                $suggestion['feedback'][$dep] = '';
                $suggestion['description'][$dep] = '';
            }
        }
    }

    public function selectRecord(&$suggestion, $id, $model)
    {
        $suggestion['selected'] = true;
        $record = $model::find($id);

        /*to show management referral message, not main message for suggester*/
        if ($suggestion['selectedRecord']['private'] ?? false) {
            $record->comments = $record->actions;
        }

        $suggestion['selectedRecord'] = $record;

        if ($model === Suggestion::class) {
            $suggestion['selectedRecord']['dep'] = $record->dep;
        }
    }

    public function storeAttachment(&$suggestion, &$suggestionProcess)
    {
        if (!empty($suggestion['attachment'])) {

            SuggestionValidation::validateAttachment($suggestionProcess);

            $suggestion['fileName'] = uniqid() . $suggestion['attachment']->getClientOriginalName();
            $suggestion['attachment']->storeAs('suggestions', $suggestion['fileName'], 'suggestion_image');
        }
    }


    public function toggle(&$suggestion)
    {
        if (!$suggestion['isEditable']) {
            $suggestion['review'] = $this->collect();
        } else {
            $suggestion['title'] = '';
            $suggestion['rule'] = [];
            $suggestion['purpose'] = [];
            $suggestion['description']['self'] = '';
            $suggestion['editableRecord'] = '';
            $suggestion['isEditing'] = false;
        }

        return $suggestion['isEditable'] = !$suggestion['isEditable'];
    }


    public function updateStage($suggestion)
    {
        list($currentStage, $newStage, $departments) = SuggestionData::formatNotificationInputs($suggestion);

        $this->suggestion->find($suggestion['suggestion_id'])->update(['stage' => $newStage,]);

        SuggestionNotifier::sendUpdateStageNotification($newStage, $currentStage, $suggestion, $departments);
    }
}
