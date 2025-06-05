<!-- Primary Meta Tags -->
<meta charset="UTF-8">
<meta name="language" content="en">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="theme-color" content="#1B232E">

<title>{{  config('app.name') }}</title>
<meta name="description" content="HRMS for handling reservation and office tasks"/>
<meta name="keywords" content="PERSOL {{ config('app.name') }} ">
<meta name="author" content="Arash Rostami">
<meta name="robots" content="noindex,nofollow"/>

<!-- CSRF token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:title" content="{{  config('app.name') }}">
<meta property="og:description" content="HRMS for handling reservation and users' tasks">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ request()->url() }}">
<meta property="twitter:title" content="{{  config('app.name') }}">
<meta property="twitter:description" content="HRMS for handling reservation and users' tasks">

<!-- Schema.org -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "url": "{{ request()->url() }}",
  "name": "{{  config('app.name') }}",
  "description": "HRMS for handling reservation and users' tasks",
  "logo": "{{ config('app.logo') }}",
  "sameAs": [
    "https://www.instagram.com/persol_co/",
    "https://www.linkedin.com/company/persol/"
  ]
}


</script>

{{ $slot }}
