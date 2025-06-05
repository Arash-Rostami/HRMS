<div id="main" class=" flex flex-col flex-grow ">
    @switch($type)
        @case("parking")
        <x-dashboard.top-parking/>
        <x-dashboard.middle-parking/>
        <x-dashboard.bottom-parking/>
        @break
        @case("office")
        <x-dashboard.top-office/>
        <x-dashboard.middle-office/>
        <x-dashboard.bottom-office/>
        @break
    @endswitch
</div>
