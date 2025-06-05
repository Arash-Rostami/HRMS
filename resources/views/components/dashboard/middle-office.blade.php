<div class="flex flex-row">
    @inject("seats", "App\Models\Seat")
    {{--left office spots --}}
    <div class="flex flex-col">
        @foreach($seats->getFromTo(12,18) as $seat)
            <x-dashboard.horizontal-office-left :desk="$seat"/>
        @endforeach
    </div>
    <x-dashboard.center-office/>
    {{--right office spots--}}
    <div class="flex flex-col ml-auto">
        @foreach($seats->getFromTo(69,17) as $seat)
            <x-dashboard.horizontal-office-right :desk="$seat"/>
        @endforeach
    </div>
</div>
