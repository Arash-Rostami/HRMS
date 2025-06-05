<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <x-meta/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css')}}" rel="stylesheet">
        <script src="{{ asset('js/app.js')}}" defer></script>
        <x-extra-css/>
    </head>
    <body>
        <div class="main-color antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
