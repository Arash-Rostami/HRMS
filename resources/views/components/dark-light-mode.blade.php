@php $dark = (Cookie::get('mode') == '#F1F1F1');@endphp
@if($dark)
    <div class="mode shadow-drop-center rounded" title="Change to dark mode 🌙">
        <a href="{{route('landing-page', 'dark-mode')}}">
            <img src="/img/dark.svg" class="text-dark" alt="dark-mode">
        </a>
    </div>
@else
    <div class="mode shadow-drop-center rounded" title="Change to light mode ☀️">
        <a href="{{route('landing-page', 'light-mode')}}">
            <img class="light-mode" src="/img/light.svg" alt="light-mode">
        </a>
    </div>
@endif
