<!-- Critical CSS -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/tw.css') }}" rel="stylesheet">
<!-- Non-critical CSS (loaded async) -->
<link href="{{ asset('css/fancyBox.css') }}" rel="stylesheet" media="print" onload="this.media='all'">
<!-- Head JS -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/sortable.js') }}" defer></script>
<!-- Extra CSS / Blade Yield -->
<x-extra-css/>
@livewireStyles
@if(trim($__env->yieldContent('css')))
    @yield('css')
@endif
