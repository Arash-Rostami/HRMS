<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta/>
    <x-user.assets.css/>
</head>
<body class="antialiased container-scrollbar custom-scrollbar">
<div class="loading-line"></div>
<!--customized menu of user panel -->
<x-user.navbar.main :hasActiveModule="$hasActiveModule"/>
<!-- Page Content -->
<main>
    @yield('content')
</main>
<!-- Livewire scripts -->
@livewireScripts

<!-- Scripts -->
<x-user.assets.js :translatePage="$translatePage" :jobs="$jobs"/>
@stack('scripts')
</body>
</html>
