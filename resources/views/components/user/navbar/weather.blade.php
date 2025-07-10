@php $weather = showWeather(); $temperature = showTemperature(); $hasDecimal = is_float($temperature); @endphp

<div class="scale-50 rtl-direction persol-farsi-font">
    {{--    sun and showers--}}
    @switch($weather)
        @case('Drizzle')
            <div class="icon sun-shower" title="امروز آفتابی و رگبارگونه است">
                <div class="cloud"></div>
                <div class="sun">
                    <div class="rays"></div>
                </div>
                <div class="rain"></div>
            </div>
            @break
            {{--    thunder and storms--}}
        @case('Thunderstorm')
            <div class="icon thunder-storm" title="امروز طوفانی همراه با رعد و برق است">
                <div class="cloud"></div>
                <div class="lightning">
                    <div class="bolt"></div>
                    <div class="bolt"></div>
                </div>
            </div>
            @break
            {{--    clouds--}}
        @case('Clouds')
            <div class="icon cloudy mx-0" title="امروز ابری است">
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
            <div class="icon sunny" title="امروز آفتابی است">
                <div class="sun">
                    <div class="rays"></div>
                </div>
            </div>
            @break
            {{--    rain--}}
        @case('Rain')
            <div class="icon rainy" title="امروز بارانی است">
                <div class="cloud"></div>
                <div class="rain"></div>
            </div>
    @endswitch
</div>


<span class="relative ltr-direction @if($hasDecimal) left-10 @endif">
    {{ $temperature }}
    @if($hasDecimal)
        <sup><small>℃</small></sup>
    @else
        <small>℃</small>
    @endif
</span>

