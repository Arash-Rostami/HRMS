<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetUserOnLeave
{
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
     * @param  \App\Events\UserLoggedOut  $event
     * @return void
     */
    public function handle(UserLoggedOut $event)
    {
        $user = $event->user;
        $user->presence = 'on-leave';
        $user->save();
    }
}
