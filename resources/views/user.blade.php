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
            {{--   AI WIDGET --}}
            <x-user.chatbot></x-user.chatbot>
            {{--   Radio Nudge/Section --}}
            <x-user.music.radio/>
            {{--  Calculator --}}
            <x-user.calculator/>
            {{-- Main Dashboard Components --}}
            @if ( showMainDashboardComponents() )
                {{--                 CEO Monthly Question Section --}}
                <x-user.question.main :questions="$questions"></x-user.question.main>

                <div id="sortMe">
                    {{--                Feed Section--}}
                    <x-user.feed.main></x-user.feed.main>
                    {{--                Taskboard Section--}}
                    <x-user.tasks.main></x-user.tasks.main>

                    {{--                Calendar Section--}}
                    <x-user.calendar.main></x-user.calendar.main>

                    {{--                 Posts Section --}}
                    <x-user.posts.main :posts="$posts" :pins="$pins"></x-user.posts.main>

                    {{-- NEW: Gallery Section --}}
                    <x-user.gallery.main/>

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
                {{--                <x-user.anniversary></x-user.anniversary>--}}

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

            {{-- Energy Component Section --}}
            @if ( hasChosenEnergy() )
                <x-user.energy.main></x-user.energy.main>
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


