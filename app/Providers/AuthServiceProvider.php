<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Desk' => 'App\Policies\DeskPolicy',
        'App\Models\Park' => 'App\Policies\ParkPolicy',
        'App\Models\Cancellation' => 'App\Policies\CancellationPolicy',
        'App\Models\Profile' => 'App\Policies\ProfilePolicy',
        'App\Models\DMS' => 'App\Policies\DMSPolicy',
        'App\Models\FAQ' => 'App\Policies\FAQPolicy',
        'App\Models\Feedback' => 'App\Policies\FeedbackPolicy',
        'App\Models\InstantMessage' => 'App\Policies\InstantMessagePolicy',
        'App\Models\Job' => 'App\Policies\JobPolicy',
        'App\Models\Link' => 'App\Policies\LinkPolicy',
        'App\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\Report' => 'App\Policies\ReportPolicy',
        'App\Models\Seat' => 'App\Policies\SeatPolicy',
        'App\Models\Spot' => 'App\Policies\SpotPolicy',
        'App\Models\Suggestion' => 'App\Policies\SuggestionPolicy',
        'App\Models\Survey' => 'App\Policies\SurveyPolicy',
        'App\Models\Ticket' => 'App\Policies\TicketPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
