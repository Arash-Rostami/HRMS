<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifySuggestionReviewers;


class SuggestionNotification
{
    public array $statuses = ['pending', 'team_remarks', 'dept_remarks', 'awaiting_decision'];

    public function getSuggestionStats()
    {
        $stats = [];

        foreach ($this->statuses as $status) {
            $suggestions = Suggestion::where('stage', $status)->where('abort', 'no')->get();
            $statusStats = [
                'count' => $suggestions->count(),
                'suggestions' => $suggestions->map(fn($suggestion) => $this->formatSuggestion($suggestion)),
            ];

            $stats[$status] = $statusStats;
        }

        return response()->json($stats, 200, [], JSON_PRETTY_PRINT);
    }

    public function formatSuggestion($suggestion)
    {
        $stats = $this->getSuggestionStatsData($suggestion);
        $notifications = $this->generateNotifications($suggestion, $stats['pending_reviewers'], $stats['suggester']);

        return array_merge($stats, ['notifications' => $notifications]);
    }

    public function generateNotifications($suggestion, $pendingReviewers, $suggester)
    {
        return $pendingReviewers->map(function ($reviewer) use ($suggester, $suggestion) {
            if ($reviewer->id == $suggester->id) {
                return [
                    'reviewer_id' => $reviewer->id,
                    'message' => "Your suggestion ({$suggestion->title}) needs your team comments. Please include them in your review."
                ];
            }
            $notificationMessage = $reviewer->profile->department === $suggester->profile->department
                ? "You have a suggestion ({$suggestion->title}) from one of your team members ({$suggester->full_name}) to comment on."
                : "You have a suggestion ({$suggestion->title}) from {$suggester->full_name} to comment on.";

            return [
                'reviewer_id' => $reviewer->id,
                'message' => $notificationMessage,
            ];
        });
    }

    public function getPendingReviewers($suggestion, $suggestedDepartments)
    {
        $headsByDepartment = User::whereHas('profile', function ($query) use ($suggestedDepartments) {
            $query->whereIn('department', $suggestedDepartments)
                ->whereIn('position', ['manager', 'supervisor']);
        })->with('profile')->where('status', 'active')->get()
            ->groupBy('profile.department');

        $highestHead = $headsByDepartment->flatMap(function ($users) {
            $managers = $users->filter(fn($user) => $user->profile->position === 'manager');
            return $managers->isNotEmpty() ? $managers : $users->filter(fn($user) => $user->profile->position === 'supervisor');
        });

        $reviewedData = $suggestion->reviews->mapWithKeys(function ($review) {
            return [$review->user_id => $review->pureDepartment];
        })->toArray();

        return $highestHead->reject(function ($user) use ($reviewedData) {
            return array_key_exists($user->id, $reviewedData)
                || in_array($user->profile->department, $reviewedData);
        });
    }

    public function sendNotifications($pendingReviewers, $suggestion, $suggester)
    {
        $pendingReviewers->each(function ($reviewer) use ($suggestion, $suggester) {

            $reviewerId = $reviewer['id'];
            $reviewerDepartment = $reviewer['department'];
            $suggesterId = $suggester['id'];
            $suggesterName = $suggester['name'];
            $suggesterDepartment = $suggester['department'];

            $message = $reviewerId === $suggesterId
                ? "Your suggestion ({$suggestion->title}) needs your team comments. Please include them in your review."
                : ($reviewerDepartment === $suggesterDepartment
                    ? "You have a suggestion ({$suggestion->title}) from one of your team members ({$suggesterName}) to comment on."
                    : "You have a suggestion ({$suggestion->title}) from {$suggesterName} to comment on.");

            SendNotificationJob::dispatch($reviewer, $message);
        });
    }

    public function notifyCEOForAwaitingDecision($suggestions)
    {
        $ceoEmail = 'pedram-soltani@persolco.com';

        if ($suggestions->isEmpty()) {
            return;
        }

        $suggestionDetails = $suggestions->map(function ($suggestion) {
            return [
                'title' => $suggestion->title,
                'suggester' => $suggestion->user->full_name,
            ];
        });

        if ($suggestionDetails->isEmpty()) {
            return;
        }

        $message = $suggestionDetails->map(function ($detail) {
            return "Suggestion: '{$detail['title']}' by {$detail['suggester']}.";
        })->implode("\n");

        $finalMessage = "The following suggestion(s) awaiting your decision:\n" . $message;

        Notification::route('mail', $ceoEmail)
            ->notify(new NotifySuggestionReviewers($finalMessage));
    }

    public function getSuggestionStatsData($suggestion)
    {
        $suggestedDepartments = json_decode($suggestion->department, true);

        $requiredReviewsCount = count($suggestedDepartments);
        $givenReviewsCount = $suggestion->reviews->whereNotIn('department', ['MA'])->count();
        $remainingReviewsCount = max(0, $requiredReviewsCount - $givenReviewsCount);

        $suggester = $suggestion->user;

        $pendingReviewers = $this->getPendingReviewers($suggestion, $suggestedDepartments);

        return [
            'id' => $suggestion->id,
            'title' => $suggestion->title,
            'suggester' => [
                'id' => $suggester->id,
                'name' => $suggester->full_name,
                'department' => $suggester->profile->department,
            ],
            'suggested_departments' => $suggestedDepartments,
            'required_reviews' => $requiredReviewsCount,
            'given_reviews' => $givenReviewsCount,
            'remaining_reviews' => $remainingReviewsCount,
            'pending_reviewers' => $pendingReviewers->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->full_name,
                    'email' => $user->email,
                    'department' => $user->profile->department,
                    'position' => $user->profile->position,
                ];
            }),
            'reviewers' => $suggestion->reviews->map(function ($review) {
                return [
                    'id' => $review->user->id,
                    'name' => $review->user->full_name,
                    'department' => $review->pureDepartment,
                ];
            }),
        ];
    }
}
