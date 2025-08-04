<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SARV CRM')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-meta/>
    @include('api.partials.sarvCss')
    <script src="https://unpkg.com/htmx.org"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
</head>
<body>
@yield('content')
@include('api.partials.sarvJs')
</body>
</html>
