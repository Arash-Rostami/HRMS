<div class="flex flex-row">
    @inject("spots", "App\Models\Spot")
    {{--left parking space--}}
    <div class="flex flex-col">
        @foreach($spots->getFromTo(0,14) as $spot)
            <x-dashboard.horizontal-space-left :space="$spot"/>
        @endforeach
    </div>
            <x-dashboard.center-space />
    {{--right parking space--}}
    <div class="flex flex-col ml-auto">
        @foreach($spots->getFromTo(13,26) as $spot)
            <x-dashboard.horizontal-space-right :space="$spot"/>
        @endforeach
    </div>
</div>
