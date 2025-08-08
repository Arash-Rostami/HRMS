<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta/>
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js')}}" defer></script>
    <x-extra-css/>
    @if(request()->is(['welcome']))
        <link href="{{ asset('css/welcomePage.css') }}" rel="stylesheet">
        <script src="{{ asset('js/welcomePage.js') }}" defer></script>
    @endif
</head>
@php $dark = (Cookie::get('mode') == '#F1F1F1');@endphp
<body class="antialiased  {{ str_contains(request()->url(), 'welcome') ? 'overflow-hidden' : '' }}">
{{--<x-entry.backdrop :themes="$themes"/>--}}
<x-entry.new-backdrop :themes="$themes"/>
</body>
</html>
