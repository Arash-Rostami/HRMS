<?php

namespace App\Http\Livewire\suggestion;

use App\Models\Profile;
use App\Models\Suggestion;
use App\Models\Review;
use App\Services\UserStatistics;
use Illuminate\Support\Facades\DB;

class SuggestionData
{

    public static function changeStage($review)
    {
        $suggestionId = $review['suggestion_id'];
        $ceo = $review['feedback']['ceo'] ?? null;
        $manager = $review['feedback']['nonceo'] ?? null;
        $manager = $review['feedback']['nonceo'] ?? null;

        return isset($ceo)
            ? ($ceo == 'agree' ? 'accepted' : ($ceo == 'disagree' ? 'rejected' : 'under_review'))
            : (isset($manager) ? self::getAllDepartmentsReviewed($suggestionId) : 'pending');
    }

    public static function formatAbortInput($id, $suggestionModel, &$suggestion)
    {
        $toBeCancelled = $suggestionModel->where('id', $id)->with('user')->first();

        $suggestion['confirmBox'] = false;
        $suggestion['suggester'] = $toBeCancelled->user->forename;
        $suggestion['department'] = $toBeCancelled->department;
        $suggestion['title'] = $toBeCancelled->title;
        return $toBeCancelled;
    }

    public static function formatNotificationInputs(&$suggestion): array
    {
        $suggestion['main'] = Suggestion::where('id', $suggestion['suggestion_id'])->with('user')->first();
        $suggestion['suggester'] = $suggestion['main']->user->forename;
        $suggestion['title'] = $suggestion['main']->title;
        $suggestion['department'] = $suggestion['reviewData']['referral'];

        return [
            $suggestion['main']->stage,
            SuggestionData::changeStage($suggestion),
            $suggestion['reviewData']['referral'] ?? null
        ];
    }


    public function formatReviewInputs(&$suggestion, $record): array
    {
        $mergedData = [];

        foreach ($suggestion['feedback'] as $dep => $feedback) {
            if (!empty($suggestion['description'][$dep])) {
                $mergedData[] = [
                    'user_id' => auth()->id(),
                    'suggestion_id' => $record->id,
                    'department' => ($dep === 'team') ? auth()->user()->profile->department : $dep,
                    'comments' => $suggestion['description'][$dep],
                    'feedback' => $feedback ?? 'unknown',
                ];
            }
        }
        return $mergedData;
    }

    public function formatSuggestionInputs(&$suggestion)
    {
        $userDep = [auth()->user()->profile->department];
        $suggestion['departments'] = empty($suggestion['departments']) ? $userDep : array_merge($userDep, $suggestion['departments']);

        return [
            'title' => $suggestion['title'],
            'description' => $suggestion['description']['self'],
            'department' => json_encode($suggestion['departments']),
            'purpose' => json_encode($suggestion['purpose']),
            'rule' => json_encode($suggestion['rule']),
            'self_fill' => $suggestion['selfFill'],
            'stage' => $suggestion['selfFill'] ? 'awaiting_decision' : 'pending',
            'attachment' => empty($suggestion['fileName']) ? null : asset("img/suggestions/{$suggestion['fileName']}"),
            'user_id' => auth()->id(),
            'comments' => $suggestion['editableRecord'] ?? null,
            'ownDep' => implode(",", $userDep),
            'suggester' => auth()->user()->forename
        ];
    }

    public static function formatProcessData($process): array
    {
        $referredDepartments = data_get($process, 'review.referral');
        $processedSuggestion = optional(Suggestion::find(data_get($process, 'review.suggestion_id')));
        $currentDepartment = data_get($process, 'dep');

        return [$referredDepartments, $processedSuggestion, $currentDepartment];
    }


    public function fetch(): \Illuminate\Contracts\Pagination\Paginator
    {
        $userDepartment = auth()->user()->profile->department;


        $query = Suggestion::with([
            /*all reviews*/
            'reviews' => function ($query) use ($userDepartment) {
                $query->orderByRaw('department = ? DESC', [$userDepartment]);
            },
            /*review referred for action by CEO*/
            'inProcessReviews' => function ($query) use ($userDepartment) {
                $query->where('department', 'MA')->whereNotNull('referral');
            }]);
        /*filter aborted suggestions for other users*/
//            ->whereRaw('IF(user_id <> ?, abort = "no", 1)', [auth()->id()])

        /*specifically for other deps*/
        if ($userDepartment !== 'MA') {
            $query->where(function ($query) use ($userDepartment) {
                $query->where('user_id', auth()->id())
                    ->orWhere(function ($query) use ($userDepartment) {
                        $query->whereJsonContains('department', $userDepartment)
                            ->orWhere('department', 'MA');
                    });
            });
        }

        if ($userDepartment === 'MA') {
            $query->whereIn('stage', ['accepted', 'rejected', 'awaiting_decision', 'under_review']);
            $query->orderByRaw("
            CASE
                WHEN stage = 'awaiting_decision' THEN 1
                WHEN stage = 'under_review' THEN 2
                WHEN stage = 'accepted' THEN 3
                WHEN stage = 'rejected' THEN 4
                WHEN stage = 'closed' THEN 5
                ELSE 6
            END ASC,
            created_at DESC
        ");
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->simplePaginate(3);
    }

    public static function getAllDepartmentsReviewed($suggestionId)
    {
        $selectedDepartments = Suggestion::find($suggestionId)->department;
        $reviewedDepartments = Review::where('suggestion_id', $suggestionId)->get()->pluck('pureDepartment')->toArray();

        $pendingDepartments = array_diff(json_decode($selectedDepartments, true), $reviewedDepartments);

        if (in_array(auth()->user()->profile->department, $pendingDepartments)) {
            return 'team_remarks';
        }

        if (count($pendingDepartments) > 0) {
            return 'dept_remarks';
        }

        return 'awaiting_decision';
    }

    public static function isSuggestionAborted($record)
    {
        return $record->abort == 'yes';
    }

    public static function isSuggestionAwaitingDecision($record)
    {
        return $record->stage == 'awaiting_decision';
    }

    public static function isSuggestionCompleted($records)
    {
        if (isManager()) {
            $suggestionIds = $records->pluck('id')->toArray();

            $count = DB::table('reviews as r')
                ->join('suggestions as s', 'r.suggestion_id', '=', 's.id')
                ->whereIn('s.id', $suggestionIds)
                ->whereRaw('JSON_CONTAINS(s.department, JSON_QUOTE(r.department), "$")')
                ->count();

            if ($count < count($suggestionIds)) {
                return false;
            }
        }

        return true;
    }

    public static function getMissingReviewsCount()
    {
        $userDepartment = auth()->user()->profile->department;
        $userPosition = auth()->user()->profile->position;
        $excludedStages = ['accepted', 'rejected', 'under_review', 'closed'];


        $missingReviewsCount = Suggestion::where('abort', 'no')
            ->whereNotIn('stage', $excludedStages)
            ->whereRaw("JSON_CONTAINS(department, ?)", [json_encode($userDepartment)])
            ->whereDoesntHave('reviews', function ($query) use ($userDepartment) {
                $query->where('department', $userDepartment);
            })->count();


        // Determine the presence of a manager or supervisor for the department
        list($managerPresent, $supervisorPresent) = self::getNumberOfManagerSupervisor($userDepartment);

        // Return the missing review count based on the user's position and the presence of a manager or supervisor
        if (($managerPresent || $supervisorPresent) && $missingReviewsCount > 0) {
            if ($managerPresent && $userPosition == 'manager') {
                return $missingReviewsCount;
            } elseif (!$managerPresent && $supervisorPresent && $userPosition == 'supervisor') {
                return $missingReviewsCount;
            }
        }

        // If there is neither manager nor supervisor, or no missing reviews, don't show missing reviews count
        return 0;
    }


    public
    static function getNumberOfManagerSupervisor($userDepartment): array
    {
        $positionsPresent = Profile::where('department', $userDepartment)
            ->whereIn('position', ['manager', 'supervisor'])
            ->pluck('position')
            ->toArray();

        return [
            in_array('manager', $positionsPresent),
            in_array('supervisor', $positionsPresent)
        ];
    }

    public
    function initialize(&$suggestion): void
    {
        $suggestion['departmentNames'] = UserStatistics::$departmentPersianNames;
        $suggestion['selfFill'] = false;
        $suggestion['isEditable'] = false;
        $suggestion['isEditing'] = false;
        $suggestion['response'] = false;
        $suggestion['confirmBox'] = false;
        $suggestion['submitted'] = true;
        $suggestion['title'] = '';
        $suggestion['description'] = [];
        $suggestion['description']['self'] = '';
        $suggestion['purpose'] = [];
        $suggestion['rule'] = [];
        $suggestion['feedback'] = [];
        $suggestion['fileName'] = '';
        $suggestion['selected'] = false;
        $suggestion['selectedRecord'] = null;
        $suggestion['editableRecord'] = '';
        $suggestion['process'] = [];
    }


    public
    function isDepartmentSelected($suggestion): bool
    {
        return empty($suggestion['departments']) && !$suggestion['confirmBox'];
    }


    public
    function showConfirmationBox(&$suggestion, $txt, $method)
    {
        $suggestion['confirmationText'] = $txt;
        $suggestion['confirmedMethod'] = $method;
        return $suggestion['confirmBox'] = !$suggestion['confirmBox'];
    }

    public
    function showResponseBox(&$suggestion, $id)
    {
        $suggestion['response'] = true;
        $suggestion['suggestion_id'] = $id;
        $suggestion['confirmBox'] = false;
        return $suggestion['confirmBox'] = !$suggestion['confirmBox'];
    }

    public function unsetExtras(&$suggestion): void
    {
        foreach ($suggestion['feedback'] as $key => $value) {
            if ($key !== 'team' && !in_array($key, $suggestion['departments'])) {
                unset($suggestion['feedback'][$key]);
                unset($suggestion['description'][$key]);
            }
        }
    }
}
