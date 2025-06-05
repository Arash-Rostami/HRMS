<div class="tooltip-main {{$direction}} w-3/4">
    <img alt="car" src="/img/{{showCar()}}-car.png"
         @switch($direction)
             @case("right")
             class="park-sign-horizontal head-right relative left-4 md:left-6">
                     <span class="tooltip">{{ showDetails($space) }}</span>
                 @break
             @case("left")
             class="park-sign-horizontal head-left">
                     <span class="tooltip">{{ showDetails($space) }}</span>
                 @break
             @case("bottom")
             class="park-sign head-bottom">
                 @break
             @default
                class="park-sign">
        @endswitch
</div>
