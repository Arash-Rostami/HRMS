@extends('api.layout')

@section('title', 'SARV CRM: ' . ($moduleName ?? 'Module Data'))

@section('content')
    <div class="container">
        <h1>{{ ucfirst($moduleName ?? 'Selected Module') }} Data</h1>
        {{-- Download and Nav Buttons --}}
        @include('api.partials.actionButtons')

        {{-- Data Table --}}
        @include('api.partials.table')

        {{-- Confirmation Modal --}}
        @include('api.partials.confirmation')
    </div>
@endsection
