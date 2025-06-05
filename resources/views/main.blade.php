<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta/>
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js')}}" defer></script>
    <x-extra-css/>
</head>
@php $dark = (Cookie::get('mode') == '#F1F1F1');@endphp
<body class="antialiased {{ str_contains(request()->url(), 'welcome') ? 'overflow-hidden' : '' }}">
    <x-backdrop :themes="$themes"/>
</body>
</html>
