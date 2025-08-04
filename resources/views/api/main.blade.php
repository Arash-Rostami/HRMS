@extends('api.layout')

@section('title', 'SARV API Login/Main Page')

@section('content')
    @auth
        <div id="mainContainer">
            @if (!session()->has('crm_token'))
                {{-- Login Form --}}
                @include('api.partials.logIn')
            @else
                {{-- Module Selector Form --}}
                @include('api.partials.apiForm')

                {{-- HTMX Loading Indicator --}}
                @include('api.partials.loader')
            @endif
            @include('api.partials.message')
        </div>
    @endauth
@endsection

