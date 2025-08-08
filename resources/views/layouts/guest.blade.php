<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <x-meta/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css')}}" rel="stylesheet">
        <script src="{{ asset('js/app.js')}}" defer></script>
        <x-extra-css/>
        @if(request()->is(['login','forgot-password','register','otp']))
            <link href="{{ asset('css/welcomePage.css') }}" rel="stylesheet">
            <script src="{{ asset('js/welcomePage.js') }}" defer></script>
        @endif
    </head>
    <body>
        <div class="main-color antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
