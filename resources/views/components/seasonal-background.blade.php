@php
    $seasons = ['spring' => [3, 4, 5],'summer' => [6, 7, 8],'fall' => [9, 10, 11],'winter' => [12, 1, 2] ];

    // Get the current month
    $currentMonth = date('n');

    // Determine the current season based on the season's name
    $season = array_search(collect($seasons)->first(fn($months) => in_array($currentMonth, $months)), $seasons);
@endphp

{{-- Background effects --}}
@switch($season)
    @case('winter')
        <x-snowflakes/>
        @break
    @case('spring')
        <x-spring-flower/>
        @break
    @case('summer')
        <x-summer-sun/>
        @break
    @case('fall')
        <x-fall-leaves/>
        @break
    @default
        <div class="bg-login-page opacity-10"></div>
@endswitch
