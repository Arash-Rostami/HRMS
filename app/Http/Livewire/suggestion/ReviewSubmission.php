<?php

namespace App\Http\Livewire\suggestion;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewSubmission
{
//
//    public static function checkReview(mixed $department, $suggestionId)
//    {
//        return Review::where('department', $department)->where('suggestion_id', $suggestionId)->exists();
//    }

    public function create(&$suggestion)
    {
        $referral = isset($suggestion['description']['ceo-departments']) ? json_encode($suggestion['description']['ceo-departments']) : null;
        $suggestion['reviewData'] = [
            'user_id' => auth()->id(),
            'department' => auth()->user()->profile->department,
            'referral' => $referral,
            'feedback' => $suggestion['feedback']['ceo'] ?? $suggestion['feedback']['nonceo'],
            'suggestion_id' => $suggestion['suggestion_id'],
            'comments' => $suggestion['description']['ceo'] ?? $suggestion['description']['nonceo'],
            'actions' => $suggestion['description']['ceo-referral'] ?? null,
        ];

        Review::create($suggestion['reviewData']);
    }


    public function findReviewWithReferral($suggestionId)
    {
        return Review::where('department', 'MA')
            ->whereNotNull('referral')
            ->where('suggestion_id', $suggestionId)
            ->first();
    }

    public function insert(&$suggestion, $record): void
    {
        $reviewInputs = (new SuggestionData())->formatReviewInputs($suggestion, $record);

        Review::insert($reviewInputs);
    }

    public static function isFeedbackSent($id)
    {
        return Review::where('department', auth()->user()->profile->department)
            ->where('suggestion_id', $id)->exists();
    }


    public function terminate(&$suggestion)
    {
        list($referredDepartments, $processedSuggestion, $currentDepartment) =
            SuggestionData::formatProcessData($suggestion['process']);

        // Update review status
        $processedSuggestion->reviews()
            ->where('department', $currentDepartment)
            ->update(['complete' => DB::raw("IF(complete = 'yes', 'no', 'yes')")]);

        // Update suggestion stage
        SuggestionSubmission::finalizeStage($processedSuggestion, $referredDepartments);
    }
}
