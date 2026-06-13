@php
    $profile = \App\Models\SchoolProfile::first();
    $menus = is_array($profile->header_navigations) && count($profile->header_navigations) > 0 ? $profile->header_navigations : [
        ['title' => __('Beranda'), 'url' => url('/'), 'is_dropdown' => false],
        ['title' => __('Profil'), 'is_dropdown' => true, 'children' => [
            ['title' => __('Visi & Misi'), 'url' => url('/profil')],
            ['title' => __('Sambutan Kepala Sekolah'), 'url' => url('/profil')],
            ['title' => __('Fasilitas'), 'url' => url('/fasilitas')]
        ]],
        ['title' => __('Akademik'), 'is_dropdown' => true, 'children' => [
            ['title' => __('Program Unggulan'), 'url' => url('/program')],
        ]],
        ['title' => __('Berita'), 'url' => url('/berita'), 'is_dropdown' => false],
        ['title' => __('Galeri'), 'url' => url('/galeri'), 'is_dropdown' => false],
        ['title' => __('Agenda'), 'url' => url('/agenda'), 'is_dropdown' => false],
        ['title' => __('Kontak'), 'url' => url('/kontak'), 'is_dropdown' => false],
    ];
@endphp

<!-- Top info bar -->
<x-navbar.top-bar :profile="$profile" />

<!-- Main navbar -->
<header x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="scrolled ? 'bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm' : 'bg-white border-b border-slate-200'" class="sticky top-0 z-50 transition-all w-full" data-testid="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ url('/') }}" class="flex items-center gap-3" data-testid="nav-logo">
                @if($profile && $profile->school_logo)
                    <img src="{{ asset('storage/' . $profile->school_logo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover shadow-md bg-white">
                @else
                    <div class="w-12 h-12 rounded-lg bg-[#1E3A8A] flex items-center justify-center shadow-md">
                        <x-lucide-graduation-cap class="w-7 h-7 text-white" />
                    </div>
                @endif
                <div class="leading-tight">
                    <div class="font-bold text-[#0F172A] text-base">{{ $profile && $profile->school_name ? $profile->school_name : 'SMPN 4 Kadupandak' }}</div>
                    <div class="text-xs text-slate-500">{{ $profile && $profile->school_tagline ? $profile->school_tagline : 'Berkarakter, Berprestasi, Berakhlak Mulia' }}</div>
                </div>
            </a>

            <!-- Desktop Nav -->
            <x-navbar.desktop :menus="$menus" />

            @if($profile && $profile->ppdb_active)
                <div class="hidden lg:flex items-center">
                    <a href="{{ route('ppdb.create') }}" class="inline-flex items-center justify-center whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 py-2 bg-[#F59E0B] hover:bg-[#D97706] text-[#0F172A] font-bold rounded-lg px-5" data-testid="nav-ppdb-btn">
                        {{ __('Daftar PPDB') }}
                    </a>
                </div>
            @endif

            <button aria-label="Toggle Menu" class="lg:hidden p-2 rounded-md hover:bg-slate-100" @click="open = !open" data-testid="mobile-menu-toggle">
                <template x-if="open"><x-lucide-x class="w-6 h-6" /></template>
                <template x-if="!open"><x-lucide-menu class="w-6 h-6" /></template>
            </button>
        </div>

        <!-- Mobile Nav -->
        <x-navbar.mobile :menus="$menus" :profile="$profile" />
    </div>
</header>
