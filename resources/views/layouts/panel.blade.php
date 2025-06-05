<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta/>
    <x-user.css/>
</head>
{{--<body class="user-panel antialiased container-scrollbar custom-scrollbar">--}}
<body class="antialiased container-scrollbar custom-scrollbar">
<div class="loading-line"></div>

<!--customized menu of user panel -->
@include('layouts.menu')
<!-- Page Content -->
<main>
    @yield('content')
</main>

<!-- Livewire scripts -->
@livewireScripts

<!-- Scripts -->
<x-user.js :translatePage="$translatePage" :jobs="$jobs"/>
</body>
</html>
