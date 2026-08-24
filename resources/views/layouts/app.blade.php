<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Solvive Travel | Luxury Small-Group & Private Journeys')</title>
<meta name="description" content="@yield('meta_desc', 'Solvive Travel designs transformative luxury journeys across Vietnam, Cambodia, Laos and Thailand.')">
@hasSection('meta_keywords')
<meta name="keywords" content="@yield('meta_keywords')">
@endif
<link rel="canonical" href="{{ url()->current() }}">
@php $siteSettings = \App\Models\SiteSetting::first(); @endphp
@if($siteSettings && $siteSettings->favicon)
<link rel="icon" href="{{ asset('storage/' . $siteSettings->faviconMedia?->path) }}" type="image/x-icon">
@else
<link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
@endif
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@stack('head')
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>

<x-header />

<main id="main">
    @yield('content')
</main>

<x-footer />

<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
