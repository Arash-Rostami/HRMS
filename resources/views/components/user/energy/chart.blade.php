<div x-data="energyChart()"
     x-init="init()">
    <!-- Legend -->
    @include('components.user.energy.legend')
    <!-- Bar | Line graph -->
    @include('components.user.energy.graph')
    <!-- Company Averages Bar -->
    @include('components.user.energy.company')
    <!-- Graph JS -->
    @include('components.user.energy.js')
</div>
