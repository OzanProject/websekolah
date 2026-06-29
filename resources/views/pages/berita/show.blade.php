@extends('layouts.app')

@section('title', $news->title)
@section('og_title', $news->title)
@section('og_description', Str::limit(html_entity_decode(strip_tags($news->content)), 150))
@section('og_image', $news->image ? (filter_var($news->image, FILTER_VALIDATE_URL) ? $news->image : asset('storage/' . $news->image)) : asset('images/og-image.jpg'))
@section('content')
<div class="pt-24 pb-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ url('/berita') }}" class="text-[#1E3A8A] text-sm font-medium inline-flex items-center gap-2 hover:text-[#F59E0B] transition-colors mb-6">
                <x-lucide-arrow-left class="w-4 h-4" /> {{ __('Kembali ke Indeks Berita') }}
            </a>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#0F172A] leading-tight mb-6">
                {{ $news->title }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-slate-500 border-y border-slate-100 py-4 mb-8">
                @if($news->category)
                <div class="flex items-center gap-2">
                    <x-lucide-tag class="w-4 h-4 text-[#F59E0B]" />
                    <span class="font-medium text-[#0F172A]">{{ $news->category->name }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <x-lucide-calendar class="w-4 h-4" />
                    <span>{{ \Carbon\Carbon::parse($news->date)->translatedFormat('d F Y') }}</span>
                </div>
                @if($news->author)
                <div class="flex items-center gap-2">
                    <x-lucide-user class="w-4 h-4" />
                    <span>{{ __('Oleh') }}: {{ $news->author->name }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <x-lucide-clock class="w-4 h-4" />
                    <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} {{ __('Menit Baca') }}</span>
                </div>
            </div>
        </div>

        <div class="rounded-2xl overflow-hidden mb-10 border border-slate-100 shadow-sm">
            <img src="{{ $news->image ? (filter_var($news->image, FILTER_VALIDATE_URL) ? $news->image : Storage::url($news->image)) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80' }}" alt="{{ $news->title }}" class="w-full h-auto max-h-[500px] object-cover" loading="lazy">
        </div>

        <article class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed mb-12">
            {!! $news->content !!}
        </article>

        <!-- Share Buttons -->
        <div class="flex items-center gap-4 py-6 border-y border-slate-100 mb-16">
            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wider">{{ __('Bagikan') }}:</span>
            <div class="flex items-center gap-3">
                <button onclick="shareNative('{{ Request::url() }}', '{{ addslashes($news->title) }}')" class="w-10 h-10 rounded-full bg-slate-100 text-[#0F172A] flex flex-col items-center justify-center hover:bg-[#1E3A8A] hover:text-white transition-colors md:hidden" title="{{ __('Bagikan') }}">
                    <x-lucide-share-2 class="w-5 h-5" />
                </button>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . Request::url()) }}" target="_blank" rel="noopener noreferrer" class="hidden md:flex w-10 h-10 rounded-full bg-[#25D366] text-white items-center justify-center hover:bg-[#1EBE5A] transition-colors hover:scale-105" title="Share to WhatsApp">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank" rel="noopener noreferrer" class="hidden md:flex w-10 h-10 rounded-full bg-[#1877F2] text-white items-center justify-center hover:bg-[#1560CA] transition-colors hover:scale-105" title="Share to Facebook">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($news->title) }}" target="_blank" rel="noopener noreferrer" class="hidden md:flex w-10 h-10 rounded-full bg-black text-white items-center justify-center hover:bg-gray-800 transition-colors hover:scale-105" title="Share to X">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <button id="copyLinkBtn" onclick="copyShareLink('{{ Request::url() }}')" class="hidden md:flex w-10 h-10 rounded-full bg-slate-200 text-slate-600 items-center justify-center hover:bg-slate-300 transition-all hover:scale-105" title="{{ __('Salin Tautan') }}">
                    <x-lucide-link class="w-5 h-5 transition-transform" id="copyIcon" />
                </button>
                <span id="copyToast" class="text-sm text-green-600 font-medium opacity-0 transition-opacity duration-300 ml-2">Tersalin!</span>
            </div>
        </div>

        <script>
            function shareNative(url, title) {
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).catch(console.error);
                } else {
                    copyShareLink(url);
                }
            }

            function copyShareLink(url) {
                navigator.clipboard.writeText(url).then(() => {
                    const toast = document.getElementById('copyToast');
                    const btn = document.getElementById('copyLinkBtn');
                    toast.classList.remove('opacity-0');
                    btn.classList.add('bg-green-100', 'text-green-600');
                    btn.classList.remove('bg-slate-200', 'text-slate-600');
                    setTimeout(() => {
                        toast.classList.add('opacity-0');
                        btn.classList.remove('bg-green-100', 'text-green-600');
                        btn.classList.add('bg-slate-200', 'text-slate-600');
                    }, 2000);
                });
            }
        </script>

        @if($relatedNews->count() > 0)
        <div class="pt-10 border-t border-slate-200">
            <h3 class="text-2xl font-bold text-[#0F172A] mb-8">{{ __('Berita Lainnya') }}</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedNews as $related)
                <a href="{{ url('/berita/' . $related->slug) }}" class="group block">
                    <div class="bg-slate-50 rounded-xl overflow-hidden mb-4 border border-slate-100">
                        <img src="{{ $related->image ? (filter_var($related->image, FILTER_VALIDATE_URL) ? $related->image : Storage::url($related->image)) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&q=80' }}" alt="{{ $related->title }}" class="w-full aspect-video object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    </div>
                    <h4 class="font-bold text-[#0F172A] group-hover:text-[#1E3A8A] line-clamp-2 transition-colors mb-2">{{ $related->title }}</h4>
                    <div class="text-xs text-slate-500 flex items-center gap-1">
                        <x-lucide-calendar class="w-3.5 h-3.5" /> {{ \Carbon\Carbon::parse($related->date)->translatedFormat('d M Y') }}
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
