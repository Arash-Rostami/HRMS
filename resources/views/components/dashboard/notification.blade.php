{{--showing notifications of results related to successful reservations--}}
@if(session()->has('success'))
    <x-dashboard.alert>{{session('success')}}</x-dashboard.alert>
@endif
{{--showing notifications of results related to unsuccessful reservations--}}
@if(session()->has('error'))
    <x-dashboard.alert>{{session('error')}}</x-dashboard.alert>
@endif
{{-- showing errors of reservations--}}
@if ($errors->any())
    <x-dashboard.alert>
        <x-dashboard.error/>
    </x-dashboard.alert>
@endif
