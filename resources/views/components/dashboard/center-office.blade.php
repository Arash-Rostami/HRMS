@inject("seats", "App\Models\Seat")
{{--left section--}}
<div class="flex flex-col flex-grow justify-center items-center opacity-50">
    <img class="w-1/3 md:w-1/4" src="/img/chair-front.png" alt="front-chair">
</div>
<div id="main" class="flex flex-col justify-center items-center">
    {{--top section--}}
    <div class="h-9 md:h-24 w-10 md:w-20 flex flex-grow justify-center items-center opacity-50">
        <img src="/img/lights.png" width="55" alt="lights">
    </div>
    {{--left office seats--}}
    <div class="flex flex-row">
        <div class="flex flex-col mr-5">
            @foreach($seats->getFromTo(30,20)->merge($seats->getFromTo(86,3)) as $seat)
                <x-dashboard.horizontal-office-right :desk="$seat"/>
            @endforeach
        </div>
        {{--right office seats--}}
        <div class="flex flex-col ml-5">
            @foreach($seats->getFromTo(50,19)->merge($seats->getFromTo(89,3)) as $seat)
                <x-dashboard.horizontal-office-left :desk="$seat"/>
            @endforeach
        </div>
    </div>
    {{--bottom section--}}
    <div class="h-9 md:h-24 w-10 md:w-20 flex flex-grow justify-center items-center opacity-50">
        <img src="/img/clock.png" width="40" alt="clock">
    </div>
</div>

{{--right section--}}
<div class="flex flex-col flex-grow justify-center items-center opacity-50">
    <img class="w-1/4" src="/img/chair-side.png" alt="side-chair">
</div>
