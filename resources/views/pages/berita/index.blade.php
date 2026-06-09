@extends('layouts.app')

@section('title', __('Berita & Informasi Sekolah'))
@section('og_title', __('Berita & Informasi Sekolah'))
@section('og_description', __('Dapatkan informasi terbaru seputar kegiatan, pengumuman, dan prestasi di sekolah kami.'))

@section('content')
<div class="pt-24 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-[#0F172A] mb-4">{{ __('Berita & Informasi Sekolah') }}</h1>
            <p class="text-slate-600 max-w-2xl mx-auto">{{ __('Dapatkan informasi terbaru seputar kegiatan, pengumuman, dan prestasi di sekolah kami.') }}</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($news as $item)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-100 flex flex-col h-full group">
                <div class="h-52 overflow-hidden relative">
                    <img src="{{ $item->image ? (filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : Storage::url($item->image)) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    @if($item->category)
                    <div class="absolute top-4 left-4 bg-[#F59E0B] text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        {{ $item->category->name }}
                    </div>
                    @endif
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-4 text-xs text-slate-500 mb-3">
                        <span class="flex items-center gap-1"><x-lucide-calendar class="w-3.5 h-3.5" /> {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <h2 class="text-lg font-bold text-[#0F172A] mb-3 line-clamp-2">
                        <a href="{{ url('/berita/' . $item->slug) }}" class="hover:text-[#1E3A8A]">{{ $item->title }}</a>
                    </h2>
                    <p class="text-slate-600 text-sm line-clamp-3 mb-4">{{ Str::limit(html_entity_decode(strip_tags($item->content)), 120) }}</p>
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a href="{{ url('/berita/' . $item->slug) }}" class="text-[#1E3A8A] text-sm font-semibold inline-flex items-center gap-1 hover:text-[#F59E0B] transition">
                            {{ __('Baca Selengkapnya') }} <x-lucide-arrow-right class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-slate-500">
                {{ __('Belum ada berita yang diterbitkan.') }}
            </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection