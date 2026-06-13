<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title') @yield('title') | {{ $globalSchoolName ?? 'Sekolah' }} @else {{ $globalSchoolName ?? 'Sekolah' }} @endif</title>
    @if(isset($schoolProfile) && $schoolProfile->school_logo)
        <link rel="icon" href="{{ asset('storage/' . $schoolProfile->school_logo) }}">
    @endif
    
    <!-- SEO & Meta tags -->
    <meta name="description" content="@yield('og_description', 'Website Resmi ' . ($globalSchoolName ?? 'Sekolah') . '. ' . ($globalSchoolTagline ?? '') . ' Dapatkan informasi PPDB, berita, dan kegiatan sekolah.')">
    <meta name="keywords" content="sekolah menengah pertama, sekolah cianjur, ppdb">
    <meta name="author" content="{{ $globalSchoolName ?? 'Sekolah' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', $globalSchoolName ?? 'Sekolah')">
    <meta property="og:description" content="@yield('og_description', 'Website Resmi ' . ($globalSchoolName ?? 'Sekolah') . '. Dapatkan informasi PPDB, berita, dan kegiatan sekolah terkini.')">
    <meta property="og:image" content="@yield('og_image', isset($schoolProfile) && $schoolProfile->school_logo ? asset('storage/' . $schoolProfile->school_logo) : asset('images/og-image.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og_title', $globalSchoolName ?? 'Sekolah')">
    <meta property="twitter:description" content="@yield('og_description', 'Website Resmi ' . ($globalSchoolName ?? 'Sekolah') . '. Dapatkan informasi PPDB, berita, dan kegiatan sekolah terkini.')">
    <meta property="twitter:image" content="@yield('og_image', isset($schoolProfile) && $schoolProfile->school_logo ? asset('storage/' . $schoolProfile->school_logo) : asset('images/og-image.jpg'))">

    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap"></noscript>

    @if($profile && $profile->google_site_verification)
        {!! $profile->google_site_verification !!}
    @endif

    @if($profile && $profile->google_analytics)
        {!! $profile->google_analytics !!}
    @endif

    @if($profile && $profile->google_tag_manager)
        {!! $profile->google_tag_manager !!}
    @endif

    @stack('preload')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#FAFAFA] text-[#0F172A] font-sans selection:bg-[#1E3A8A] selection:text-white">

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />
    <x-floating-wa />

</body>
</html>
