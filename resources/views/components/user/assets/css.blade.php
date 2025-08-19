<!-- CSS -->
<link href="{{ asset('css/app.css')}}" rel="stylesheet">
<link href="{{ asset('css/tw.css')}}" rel="stylesheet">
<link href="{{ asset('css/fancyBox.css')}}" rel="stylesheet">
<!-- HEAD JS -->
<script src="{{ asset('js/app.js')}}" defer></script>
<script src="{{ asset('js/sortable.js') }}"></script>


<!-- General styles -->
<x-extra-css/>
<!-- Livewire styles -->
@livewireStyles
<!-- Custom CSS -->
@if(trim($__env->yieldContent('css')))
    @yield('css')
@endif
