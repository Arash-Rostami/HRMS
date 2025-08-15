@php
    $presences = [
        'onsite' => ['icon' => 'fa-building', 'color' => 'text-success-400', 'count' => countOnSiteUsers(), 'fade' => 'fade-in-two' , 'border' => 'avatar-image-onsite'],
        'off-site' => ['icon' => 'fa-laptop', 'color' => 'text-warning-500', 'count' => countOffSiteUsers(), 'fade' => 'fade-in-three' , 'border' => 'avatar-image-off-site'],
        'on-leave' => ['icon' => 'fa-bed', 'color' => 'text-gray-500', 'count' => countOnLeaveUsers(), 'fade' => 'fade-in-four' , 'border' => 'avatar-image-on-leave']
    ];
@endphp
@include('components.user.status.title')
{{-- Filter Box --}}
@include('components.user.status.filter')
<div class="clear-both" x-data="smsHandler">
    @include('components.user.status.presence-board', ['presences' => $presences, 'users' => $users])
    {{-- SMS Modal --}}
    @include('components.user.status.sms')
    {{-- Success Message Toast--}}
    @include('components.user.status.toast')
</div>
@once
    @include('components.user.status.js')
@endonce
