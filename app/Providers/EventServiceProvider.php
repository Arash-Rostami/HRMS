<?php

namespace App\Providers;

use App\Events\QuestionMade;
use App\Events\UpdateLastSeen;
use App\Events\UserLoggedIn;
use App\Events\userLoggedInETS;
use App\Events\UserLoggedOut;
use App\Listeners\DispatchEmailNotification;
use App\Listeners\SetUserOnLeave;
use App\Listeners\SetUserOnSite;
use App\Listeners\SetUserOnSiteOrOffSite;
use App\Listeners\UpdateLastSeenListener;
use App\Models\Delegation;
use App\Models\DMS;
use App\Models\FAQ;
use App\Models\Job;
use App\Models\Link;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Report;
use App\Models\Ticket;
use App\Models\User;
use App\Observers\DelegationObserver;
use App\Observers\DmsFileObserver;
use App\Observers\FAQObserver;
use App\Observers\JobObserver;
use App\Observers\LinkObserver;
use App\Observers\PinObserver;
use App\Observers\PostObserver;
use App\Observers\ProfileObserver;
use App\Observers\QuestionObserver;
use App\Observers\ReportCacheObserver;
use App\Observers\ReportObserver;
use App\Observers\THSObserver;
use App\Observers\TicketObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdateLastSeen::class => [
            UpdateLastSeenListener::class,
        ],
        UserLoggedOut::class => [
            SetUserOnLeave::class
        ],
        UserLoggedIn::class => [
            SetUserOnSiteOrOffSite::class
        ],
        UserLoggedInETS::class => [
            SetUserOnSite::class
        ],
        QuestionMade::class => [
            DispatchEmailNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        DMS::observe(DmsFileObserver::class);
        Delegation::observe(DelegationObserver::class);
        FAQ::observe(FAQObserver::class);
        Job::observe(JobObserver::class);
        Link::observe(LinkObserver::class);
        //Grouped
        Post::observe(PostObserver::class);
//        Post::observe(PinObserver::class);
        Profile::observe(ProfileObserver::class);
        Question::observe(QuestionObserver::class);
        //Grouped
        Report::observe(ReportObserver::class);
        Report::observe(ReportCacheObserver::class);
        Ticket::observe(TicketObserver::class);
//        User::observe(UserObserver::class);
    }
}
