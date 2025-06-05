@php $weather = showWeather(); $temperature = showTemperature(); $hasDecimal = is_float($temperature); @endphp

<div class="scale-50">
    {{--    sun and showers--}}
    @switch($weather)
        @case('Drizzle')
            <div class="icon sun-shower" title="Today is sunny & showery">
                <div class="cloud"></div>
                <div class="sun">
                    <div class="rays"></div>
                </div>
                <div class="rain"></div>
            </div>
            @break
            {{--    thunder and storms--}}
        @case('Thunderstorm')
            <div class="icon thunder-storm" title="Today is (thunder)stormy">
                <div class="cloud"></div>
                <div class="lightning">
                    <div class="bolt"></div>
                    <div class="bolt"></div>
                </div>
            </div>
            @break
            {{--    clouds--}}
        @case('Clouds')
            <div class="icon cloudy mx-0" title="Today is cloudy">
                <div class="cloud"></div>
                <div class="cloud"></div>
            </div>
            @break
            {{--    rain and snow--}}
        @case('Snow')
            <div class="icon flurries">
                <div class="cloud"></div>
                <div class="snow">
                    <div class="flake"></div>
                    <div class="flake"></div>
                </div>
            </div>
            @break
            {{--    sun--}}
        @case('Clear')
            <div class="icon sunny" title="Today is sunny">
                <div class="sun">
                    <div class="rays"></div>
                </div>
            </div>
            @break
            {{--    rain--}}
        @case('Rain')
            <div class="icon rainy" title="Today is rainy">
                <div class="cloud"></div>
                <div class="rain"></div>
            </div>
    @endswitch
</div>
<span class="relative  @if($hasDecimal) right-10 @endif"> {{ $temperature }}
    @if($hasDecimal)
        <sup>
       <small>
        &#8451;
    </small>
   </sup>
    @endif
</span>



