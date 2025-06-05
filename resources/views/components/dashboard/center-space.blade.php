{{--left lane--}}
<div class="flex flex-col flex-grow justify-center items-center opacity-50 rotate-180">
    <img src="/img/twoway.png" width="100" alt="two-way">
</div>

<div id="main" class="flex flex-col justify-center items-center">
    {{--top lane--}}
    <div class="h-9 md:h-24 w-10 md:w-20 flex flex-grow justify-center items-center opacity-50 rotate-90">
        <img src="/img/slow.png" width="55" alt="slow-down">
    </div>
    {{--left parking space--}}
    <div class="flex flex-row">
        <div class="flex flex-col mr-5">
            @for($i=560; $i<569;$i++)
                <x-dashboard.horizontal-space-right :space="$i"/>
            @endfor
        </div>
        {{--right parking space--}}
        <div class="flex flex-col ml-5">
            @for($i=710; $i<719;$i++)
                <x-dashboard.horizontal-space-left :space="$i"/>
            @endfor
        </div>
    </div>
    {{--bottom lane--}}
    <div class="h-9 md:h-24 w-10 md:w-20 flex flex-grow justify-center items-center opacity-50 rotate-90">
        <img src="/img/twoway.png" width="55" alt="two-way">
    </div>
</div>

{{--right lane--}}
<div class="flex flex-col flex-grow justify-center items-center opacity-50">
    <img src="/img/slow.png" width="100" alt="slow-down">
</div>
