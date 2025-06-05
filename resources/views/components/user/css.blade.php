<!-- CSS -->
<link href="{{ asset('css/app.css')}}" rel="stylesheet">
<link href="{{ asset('css/tw.css')}}" rel="stylesheet">
<link href="{{ asset('/css/froala.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/sortable.js') }}"></script>
<script src="{{ asset('js/app.js')}}" defer></script>

<x-extra-css/>

<!-- Livewire styles -->
@livewireStyles

<!-- Custom CSS -->
@if(trim($__env->yieldContent('css')))
    @yield('css')
@endif
