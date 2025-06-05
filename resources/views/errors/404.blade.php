@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <div class="persol-font">{{ __($exception->getMessage() ?? 'Not Found') }}</div>
@endsection
