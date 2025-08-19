@if( isUserPanel())
    <script src="{{ asset('/js/scriptManager.js') }}"></script>
    <script defer>
        const color = @json(\App\Services\AssetManager::getColorMode());
        const scripts = @json(\App\Services\AssetManager::getBodyJsAssets());
        const url = "{{ asset('/') }}";
        loadAndCacheScripts(scripts, url);
    </script>

    {{--    if google translate is enabled--}}
    @if($translatePage)
        {{--         Google Translate CDN --}}
        <script type="text/javascript"
                src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    @endif

    {{--     analytics | statistics --}}
    @if(hasChosenAnalytics())
        <script src="{{ asset('/js/analyticsChart.js') }}" defer></script>
        <script defer>window.chartConfig = @json(\App\Services\AssetManager::getAnalyticsConfig());</script>
        <script src="{{ asset('/js/chartjs.js') }}" defer></script>
    @endif
@endif


