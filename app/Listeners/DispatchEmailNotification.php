<?php

namespace App\Listeners;

use App\Events\QuestionMade;
use App\Notifications\NotifyUsersQuestionOfMonth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class DispatchEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\QuestionMade $event
     * @return void
     */
    public function handle(QuestionMade $event)
    {
        Notification::route('mail', 'support@team.persolco.com')
            ->notify(new NotifyUsersQuestionOfMonth($event->emails));
    }
}
