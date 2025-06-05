<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js')}}" defer></script>

    <script src="{{ asset('js/calender.js')}}"></script>

    <x-extra-css/>
</head>
<body class=" antialiased">
<div class="min-h-screen break-words">
    <!--customized menu of reservation -->
    @includeWhen(str_contains(request()->path(), 'sms'), 'layouts.navigation')
    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
</body>
</html>
