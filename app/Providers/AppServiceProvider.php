<?php

namespace App\Providers;

use App\Filament\Resources\CancellationResource;
use App\Filament\Resources\DelegationResource;
use App\Filament\Resources\DeskResource;
use App\Filament\Resources\DMSResource;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\FAQResource;
use App\Filament\Resources\FeedbackResource;
use App\Filament\Resources\InstantMessageResource;
use App\Filament\Resources\JobResource;
use App\Filament\Resources\LinkResource;
use App\Filament\Resources\ParkResource;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\QuestionResource;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ResponseResource;
use App\Filament\Resources\SeatResource;
use App\Filament\Resources\SpotResource;
use App\Filament\Resources\SuggestionProcessResource;
use App\Filament\Resources\SurveyResource;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Permission;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        Filament::registerScripts([
            asset('js/filamentScript.js'),
        ]);

        Filament::registerStyles([
            asset('css/filamentStyles.css'),
        ]);

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $builder->items([
                NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->activeIcon('heroicon-s-home')
                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.pages.dashboard'))
                    ->url(route('filament.pages.dashboard')),
            ]);
            $builder->groups([
                NavigationGroup::make('Reservation Panel')
                    ->items([
                        ...ParkResource::getNavigationItems(),
                        ...DeskResource::getNavigationItems(),
                        ...CancellationResource::getNavigationItems(),
                    ]),
                NavigationGroup::make('User Panel')
                    ->items([
                        ...DelegationResource::getNavigationItems(),
                        ...DMSResource::getNavigationItems(),
                        ...QuestionResource::getNavigationItems(),
//                        ...ResponseResource::getNavigationItems(),
                        ...FAQResource::getNavigationItems(),
                        ...UserResource::getNavigationItems(),
                        ...ProfileResource::getNavigationItems(),
                        ...PostResource::getNavigationItems(),
                        ...LinkResource::getNavigationItems(),
                        ...JobResource::getNavigationItems(),
                        ...InstantMessageResource::getNavigationItems(),
//                        ...SuggestionResource::getNavigationItems(),
                        ...SuggestionProcessResource::getNavigationItems(),
                        ...FeedbackResource::getNavigationItems(),
                        ...SurveyResource::getNavigationItems(),
                        ...TicketResource::getNavigationItems(),
                        ...ReportResource::getNavigationItems(),
                        ...EventResource::getNavigationItems(),
                    ]),
                NavigationGroup::make('Raw Data')
                    ->items([
                        ...SeatResource::getNavigationItems(),
                        ...SpotResource::getNavigationItems(),
                        ...PermissionResource::getNavigationItems(),
                    ]),


            ]);
            return $builder;
        });
    }
}
