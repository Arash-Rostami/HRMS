<?php

namespace App\Listeners;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Event;


class SetUserOnSiteOrOffSite
{

    protected $schedule;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user->presence = (isInternalISP() or $event->isp == '85.133.210.62') ? 'onsite' : 'off-site';
        $user->save();
    }
}
