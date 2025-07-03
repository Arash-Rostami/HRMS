@extends('layouts.panel')
@section('content')
    <div id="accordionFlush"
         x-data="{
         showReservation: false,
         showProduct: false,
         showModals:false ,
         showPost: false,
         postTitle: '',
         postContent: '',
         postImage: '',
         postDate: ''
         }"
         x-cloak>
        <div>
            {{-- Main Dashboard Components --}}
            @if ( showMainDashboardComponents() )
                {{--   Icon and Slogan Positioned on the Right Corner --}}
                <x-user.navbar.nav></x-user.navbar.nav>
                {{--                 CEO Monthly Question Section --}}
                <x-user.question.main :questions="$questions"></x-user.question.main>

                <div id="sortMe">
                    {{--                Calendar Section--}}
                    <x-user.calendar.main></x-user.calendar.main>

                    {{--                 Posts Section --}}
                    <x-user.posts.main :posts="$posts" :pins="$pins"></x-user.posts.main>

                    {{--                 User Status Section --}}
                    <x-user.status.main :users="$users"></x-user.status.main>

                    {{--                 Job Ads Section --}}
                    <x-user.job.main :jobs="$jobs"></x-user.job.main>

                    {{--                 Reports Section --}}
                    <x-user.report.main :reports="$reports"></x-user.report.main>

                    {{--                 Corporate and Persol Links Sections --}}
                    <x-user.link.external.main :links="$links"></x-user.link.external.main>
                    <x-user.link.internal.main :links="$links"></x-user.link.internal.main>

                    {{--                 FAQs Section --}}
                    <x-user.faq.main :faqs="$faqs"></x-user.faq.main>
                </div>
                <x-user.anniversary></x-user.anniversary>

                {{--  Main Layout for Modals --}}
                <x-user.modal></x-user.modal>

                {{--   Icon of handy items Positioned on the Left Corner --}}
                <x-user.navbar.toolbox/>
            @else
                @if ( showProfile() )
                    {{-- User Profile Section --}}
                    <x-user.profile.main :users="$users"></x-user.profile.main>
                @endif
            @endif

            {{-- Music Component Section --}}
            @if ( hasChosenMusic() )
                <x-user.music.main></x-user.music.main>
            @endif

            {{-- Onboarding Component Section --}}
            @if ( hasChosenOnboarding() )
                <x-user.onboarding.main></x-user.onboarding.main>
            @endif

            {{-- Analytics Component Section --}}
            @if ( hasChosenAnalytics() )
                <x-user.analytics.main></x-user.analytics.main>
            @endif

            {{-- Surveys component Section --}}
            @if( showSurvey())
                <x-user.survey.surveys></x-user.survey.surveys>
            @endif

            {{-- Suggestion component Section --}}
            @if( hasChosenSuggestion() )
                <x-user.suggestion.main></x-user.suggestion.main>
            @endif

            {{-- Delegation component Section --}}
            @if( hasChosenDelegation())
                <x-user.authorities.main :delegations="$delegations"></x-user.authorities.main>
            @endif

            {{-- DMS component Section --}}
            @if( hasChosenDMS())
                <x-user.dms.main></x-user.dms.main>
            @endif

            {{-- THS component Section --}}
            @if ( hasChosenTHS() )
                <x-user.ths.main></x-user.ths.main>
            @endif

            {{--Progress bar component Section--}}
            {{--        <x-user.progressModal/>--}}

            {{--This is the main footer with additional feature for translation based on user's choice--}}
            <x-dashboard.footer>
                <x-user.occasion.main/>
                <x-dashboard.toggle-google :translatePage="$translatePage"/>
            </x-dashboard.footer>

            {{--             Top Head Alert Message --}}
            <x-dashboard.notification></x-dashboard.notification>
        </div>
        <x-user.navbar.scroll/>
    </div>
@endsection


