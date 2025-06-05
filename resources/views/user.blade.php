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
         }" x-cloak>
        <div>
            {{-- Main Dashboard Components --}}
            @if ( showMainDashboardComponents() )
                {{--   Icon and Slogan Positioned on the Right Corner --}}
                <x-user.stickyNav></x-user.stickyNav>
                {{--                 CEO Monthly Question Section --}}
                <x-user.QoM :questions="$questions"></x-user.QoM>

                <div id="sortMe">
                    {{--                Calendar Section--}}
                    <x-user.timetable></x-user.timetable>

                    {{--                 Posts Section --}}
                    <x-user.post :posts="$posts" :pins="$pins"></x-user.post>

                    {{--                 User Status Section --}}
                    <x-user.status :users="$users"></x-user.status>

                    {{--                 Job Ads Section --}}
                    <x-user.ad :jobs="$jobs"></x-user.ad>


                    {{--                 Reports Section --}}
                    <x-user.reports :reports="$reports"></x-user.reports>


                    {{--                 Corporate and Persol Links Sections --}}
                    <x-user.corporate-links :links="$links"></x-user.corporate-links>
                    <x-user.persol-links :links="$links"></x-user.persol-links>

                    {{--                 FAQs Section --}}
                    <x-user.FAQ :faqs="$faqs"></x-user.FAQ>
                </div>

                {{--  Other Components --}}
                {{--  User Emails Section --}}
{{--                <livewire:user-emails/>--}}

                {{--  Main Layout for Modals --}}
                <x-user.modal></x-user.modal>

                {{--   Icon of handy items Positioned on the Left Corner --}}
                <x-user.toolbox/>
            @else
                @if ( showProfile() )
                    {{-- User Profile Section --}}
                    <x-user.profile :users="$users"></x-user.profile>
                @endif
            @endif

            {{-- Music Component Section --}}
            @if ( hasChosenMusic() )
                <x-user.music></x-user.music>
            @endif

            {{-- Onboarding Component Section --}}
            @if ( hasChosenOnboarding() )
                <x-user.onboarding></x-user.onboarding>
            @endif

            {{-- Analytics Component Section --}}
            @if ( hasChosenAnalytics() )
                <x-user.statistics></x-user.statistics>
            @endif

            {{-- Surveys component Section --}}
            @if( showSurvey())
                <x-user.surveys></x-user.surveys>
            @endif

            {{-- Suggestion component Section --}}
            @if( hasChosenSuggestion() )
                <x-user.suggestion></x-user.suggestion>
            @endif

            {{-- Delegation component Section --}}
            @if( hasChosenDelegation())
                <x-user.delegation :delegations="$delegations"></x-user.delegation>
            @endif

            {{-- DMS component Section --}}
            @if( hasChosenDMS())
                <x-user.dms></x-user.dms>
            @endif

            @if ( hasChosenTHS() )
                <x-user.ths></x-user.ths>
            @endif


            {{--Progress bar component Section--}}
            {{--        <x-user.progressModal/>--}}

            {{--This is the main footer with additional feature for translation based on user's choice--}}
            <x-dashboard.footer>
                <x-user.occasion/>
                <x-dashboard.toggle-google :translatePage="$translatePage"/>
            </x-dashboard.footer>

            {{--             Top Head Alert Message --}}
            <x-dashboard.notification></x-dashboard.notification>
        </div>

        <x-user.scroll-button/>
{{--        @include('components.user.targrade')--}}
    </div>
@endsection


