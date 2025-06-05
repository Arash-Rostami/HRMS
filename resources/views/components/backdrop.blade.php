{{--offline backdrop that can be shown manually or automatically when internet is lost --}}
<div class="flex flex-col-reverse md:flex-row items-center justify-center min-h-screen">
    {{--Background effects--}}
    <x-seasonal-background/>

    {{--left/top section of page--}}
    <div class="w-full md:w-1/2 self-center my-auto">
        {{--image of screen--}}
        <img class="mx-auto w-2/3" alt="login-page"
             src="/img/sitting-behind-desk-{{ session('svg') ?? 'grey' }}.svg">
    </div>
    {{--right/bottom section of page--}}
    <div class="w-full md:w-1/2 flex mt-32 md:mb-0 ">
        {{--    <span class="self-center mx-auto justify-center mx-auto mt-auto main-color">{{ config('app.name') }}</span>--}}
        {{--        <div class="things text-flicker-in-glow">--}}
        {{--            <div class="arrow">--}}
        {{--                <div class="curve"></div>--}}
        {{--                <div class="point"></div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div x-data
             title="LOG IN  {{ config('app.name') }} 🔐"
             @click="event.preventDefault();location.href='{{ route('user.panel') }}'"
             class="h-28 md:h-56 self-center mx-auto shadow-drop-center items-center flex section-title
             justify-center w-1/2 mx-auto cursor-pointer rounded">

            <div class="text-center">
                {{--<i class="far fa-address-card"></i><br>--}}
                {{--<h1 class="md:text-4xl text-xl">LOG</h1>--}}
                <i class="fas fa-fingerprint text-large" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>

{{--absolute positioned elements--}}
{{--switch mode--}}
<x-dark-light-mode/>

{{--color pallete--}}
<div class="color-pallet shadow-drop-center rounded" title="Change the theme 🎨">
    @foreach($themes as $name => $code)
        <a href="{{route('landing-page', $name)}}">
            <span class="{{strstr($name,'-theme', true)}} margin-auto block"
                  title="{{strstr($name,'-theme', true)}}">
            </span>
        </a>
    @endforeach
</div>







