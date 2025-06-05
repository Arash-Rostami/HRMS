<!-- Custom scripts -->
@if( isUserPanel())

    {{--    modal library and its config file--}}
    <script src="{{ asset('/js/modal.js') }}"></script>
    <script>
        color = <?php echo json_encode(Cookie::get('mode')); ?>;
    </script>
    {{--if google translate is enabled--}}
    @if($translatePage)
        {{-- Google Translate CDN --}}
        <script type="text/javascript"
                src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        {{-- if page is translated in Farsi and refreshed, change direction  --}}
        <script src="{{ asset('/js/google-translate.js') }}"></script>
    @endif
    {{--   to send AJAX request for pagination - for posts in userpanel dashboard--}}
    <script src="{{ asset('/js/pagination.js') }}"></script>
    @if(count($jobs) > 0)
        {{--   jobs flipability--}}
        <script src="{{ asset('/js/jobs.js') }}"></script>
        {{--   post links sharing--}}
        <script src="{{ asset('/js/clipboard.js') }}"></script>
    @endif
    {{--   filter avatars--}}
    <script src="{{ asset('/js/filter.js') }}"></script>
    {{--   phone number overlay --}}
    <script src="{{ asset('/js/tooltip.js') }}"></script>
    {{--   sortable --}}
    @if(isNotMobileDevice())
        <script src="{{ asset('/js/sortableConfig.js') }}"></script>
    @endif
    {{--   slogans popup  --}}
    <script src="{{ asset('/js/slogans.js') }}"></script>
    {{--   tunes   --}}
    @if(hasChosenMusic())
        <script src="{{ asset('/js/tunes.js') }}"></script>
    @endif
    {{-- analytics | statistics --}}
    @if(hasChosenAnalytics())
        <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
        <script defer>
            {{--           @php dd((\App\Services\UserStatistics::getGenderAndPositions())); @endphp--}}
                window.chartConfig = {
                getGenderAndMaritalStatusChartData: @json(\App\Services\UserStatistics::getGenderAndMaritalStatus()),
                getGenderAndPositionsChartData: @json(\App\Services\UserStatistics::getGenderAndPositions()),
                getEmploymentTypeChartData: @json(\App\Services\UserStatistics::getEmploymentType()),
                getDepartmentDistributionChartData: @json(\App\Services\UserStatistics::getDepartmentDistribution()),
                getAgeDistributionChartData:@json(\App\Services\UserStatistics::getAgeDistribution()),
                getEducationAndExperienceChartData:@json(\App\Services\UserStatistics::getEducationAndExperience()),
                getAverageWorkingHoursChartData:@json(\App\Services\UserStatistics::getAverageWorkingHoursOfDepartments())
            };
        </script>
        <script src="{{ asset('/js/chartjs.js') }}" defer></script>
    @endif
    {{--   music player timer   --}}
    <script src="{{ asset('/js/autoPlayAudio.js') }}"></script>
@endif


<!-- Froala Editor & config file -->
<script src="{{ asset('/js/froala.js') }}"></script>
<script src="{{ asset('/js/editor.js') }}"></script>




