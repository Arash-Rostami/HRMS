@if(str_contains(request()->url(), 'welcome'))
    @for($i = 1; $i <= 50; $i++)
        <div class="snowflake" style="
        --size: {{ ($i % 6 == 0) ? '0.2' : (($i % 2 == 0) ? '0.8' : '0.6') }}vw;
        --left-ini: {{ ($i % 3 == 0) ? '0' : (($i % 5 == 0) ? '-7' : '5') }}vw;
        --left-end: {{ ($i % 4 == 0) ? '5' : (($i % 7 == 0) ? '9' : '-2') }}vw;
        left: {{ ($i % 8 == 0) ? '80' : (($i % 10 == 0) ? '20' : '50') }}vw;
        animation: snowfall {{ ($i % 9 == 0) ? '6' : (($i % 11 == 0) ? '14' : '10') }}s linear infinite;
        animation-delay: -{{ ($i % 12 == 0) ? '5' : (($i % 13 == 0) ? '3' : '1') }}s;
    "></div>
    @endfor
@endif

<div class="fixed  w-full z-50 filter grayscale blur-sm contrast-200 bottom-[-20px] md:bottom-[-70px]">
    <img src="/img/snow.png" alt="snow" class="w-full">
</div>
