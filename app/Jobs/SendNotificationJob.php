<?php

namespace App\Jobs;

use App\Notifications\NotifySuggestionReviewers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class SendNotificationJob
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reviewer;
    public $message;

    public function __construct($reviewer, $message)
    {
        $this->reviewer = $reviewer;
        $this->message = $message;
    }

    public function handle()
    {
        Log::info("Job Triggered: Sending email to: " . $this->reviewer['email']);

        Notification::route('mail', $this->reviewer['email'])
            ->notify(new NotifySuggestionReviewers($this->message));
    }
}
