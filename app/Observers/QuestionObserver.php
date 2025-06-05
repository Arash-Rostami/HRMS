<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "updated" event.
     *
     * @param \App\Models\Question $question
     * @return void
     */
    public function updated(Question $question)
    {
        // Delete the original file if the image attribute is changed
        if ($question->isDirty('image')) {
            $originalFilePath = $question->getOriginal('image');
            if ($originalFilePath) {
                unlink($originalFilePath);
            }
        }
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param \App\Models\Question $question
     */
    public function deleted(Question $question)
    {
        if ($question->image) {
            unlink($question->getOriginal('image'));
        }
    }
}
