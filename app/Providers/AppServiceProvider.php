<?php

namespace App\Providers;

use App\Filament\Resources\AppResource;
use App\Filament\Resources\CancellationResource;
use App\Filament\Resources\DelegationResource;
use App\Filament\Resources\DeskResource;
use App\Filament\Resources\DMSResource;
use App\Filament\Resources\EnergyTestResource;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\FAQResource;
use App\Filament\Resources\FeedResource;
use App\Filament\Resources\JobResource;
use App\Filament\Resources\LinkResource;
use App\Filament\Resources\ParkResource;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\PhotoResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\QuestionResource;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\SeatResource;
use App\Filament\Resources\SpotResource;
use App\Filament\Resources\SuggestionProcessResource;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
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
                        ...CancellationResource::getNavigationItems(),
                        ...DeskResource::getNavigationItems(),
                        ...ParkResource::getNavigationItems(),
                    ]),
                NavigationGroup::make('User Panel')
                    ->items([
                        ...AppResource::getNavigationItems(),
                        ...DelegationResource::getNavigationItems(),
                        ...DMSResource::getNavigationItems(),
                        ...EnergyTestResource::getNavigationItems(),
                        ...EventResource::getNavigationItems(),
                        ...FAQResource::getNavigationItems(),
                        ...FeedResource::getNavigationItems(),
                        ...JobResource::getNavigationItems(),
                        ...LinkResource::getNavigationItems(),
                        ...PhotoResource::getNavigationItems(),
                        ...PostResource::getNavigationItems(),
                        ...ProfileResource::getNavigationItems(),
                        ...QuestionResource::getNavigationItems(),
                        //...ResponseResource::getNavigationItems(),
                        ...ReportResource::getNavigationItems(),
                        ...SuggestionProcessResource::getNavigationItems(),
                        ...TicketResource::getNavigationItems(),
                        ...UserResource::getNavigationItems(),
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

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {}
}
