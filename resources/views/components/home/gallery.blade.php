@props(['gallery'])

{{-- PERBAIKAN 1: Ekstrak data galeri ke JSON agar bisa dibaca Alpine.js --}}
@php
    // Kita siapkan array baru yang bersih dan aman dari karakter aneh
    $preparedGallery = collect($gallery)->map(function($item) {
        return [
            'src' => $item['src'],
            'title' => addslashes($item['title']) // Amankan tanda kutip tunggal
        ];
    });
@endphp

<section id="gallery" class="py-20 lg:py-28 bg-white" data-testid="gallery-section" 
    {{-- PERBAIKAN 2: Logika Alpine.js Baru untuk Navigasi --}}
    x-data="{ 
        lightboxOpen: false, 
        currentIndex: 0,
        {{-- Oper data PHP ke JS menggunakan directive Js::from Laravel (aman & bersih) --}}
        items: {{ \Illuminate\Support\Js::from($preparedGallery) }},
        
        {{-- Helper function untuk ambil data gambar saat ini --}}
        get currentItem() {
            return this.items[this.currentIndex];
        },
        
        {{-- Fungsi Navigasi Ke Kanan (Next) --}}
        next() {
            // Jika di akhir, kembali ke awal. Jika tidak, tambah 1.
            this.currentIndex = (this.currentIndex + 1) % this.items.length;
        },
        
        {{-- Fungsi Navigasi Ke Kiri (Prev) --}}
        prev() {
            // Jika di awal, lompat ke akhir. Jika tidak, kurang 1.
            this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
        }
    }"
    {{-- PERBAIKAN 3: Navigasi Keyboard (Panah & Escape) --}}
    @keydown.window.escape="lightboxOpen = false"
    @keydown.window.left="if(lightboxOpen) prev()"
    @keydown.window.right="if(lightboxOpen) next()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                {{ __('Dokumentasi') }}
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="gallery-title">
                {{ __('Galeri Foto Sekolah') }}
            </h2>
            <p class="text-slate-600">
                {{ __('Momen-momen berharga dari aktivitas, kegiatan, dan keseharian di sekolah kami.') }}
            </p>
        </div>

        {{-- Grid Kaku & Presisi (Cols-2 Mobile, Cols-3 Desktop) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6">

            @foreach($gallery as $i => $g)
            {{-- Wadah Presisi Aspect Ratio 4:3 --}}
            <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer bg-slate-100 border border-slate-100 shadow-sm" 
                 data-testid="gallery-item-{{ $i }}"
                 {{-- PERBAIKAN 4: Klik simpan INDEKS, bukan gambar --}}
                 @click="currentIndex = {{ $i }}; lightboxOpen = true">
                
                {{-- Object Cover untuk Gambar Acak Backend --}}
                <img loading="lazy" src="{{ $g['src'] }}" alt="{{ $g['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                
                {{-- Overlay Gradasi --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                {{-- Judul Foto --}}
                <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="text-white font-semibold text-base leading-snug line-clamp-2">{{ $g['title'] }}</div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>

    {{-- Lightbox Modal Dinamis --}}
    <div x-show="lightboxOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        {{-- Close button (Atas) --}}
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2.5 transition-colors z-[110]" title="{{ __('Tutup') }} (Esc)">
            <x-lucide-x class="w-6 h-6" />
        </button>

        {{-- Click outside to close --}}
        <div class="absolute inset-0 z-[101]" @click="lightboxOpen = false"></div>

        {{-- Image & Navigation Container --}}
        <div class="relative max-w-5xl w-full max-h-full flex flex-col items-center justify-center z-[102]"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            {{-- PERBAIKAN 5: Panah Navigasi --}}
            
            <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-full mr-4 group hidden md:flex items-center justify-center text-white/60 hover:text-white transition z-[110]" title="{{ __('Sebelumnya') }} (←)">
                <x-lucide-chevron-left class="w-16 h-16 group-hover:scale-110 transition-transform" />
            </button>
            
            <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-full ml-4 group hidden md:flex items-center justify-center text-white/60 hover:text-white transition z-[110]" title="{{ __('Selanjutnya') }} (→)">
                <x-lucide-chevron-right class="w-16 h-16 group-hover:scale-110 transition-transform" />
            </button>
            
            {{-- Gambar Utama (Dinamis mengambil dari currentItem) --}}
            <img :src="currentItem.src" :alt="currentItem.title" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl border-2 border-white/10">
            
            {{-- Keterangan & Counter (Dinamis) --}}
            <div class="mt-6 text-center text-white">
                <p class="font-medium text-lg tracking-wide mb-1" x-text="currentItem.title"></p>
                {{-- Counter untuk info urutan foto --}}
                <p class="text-sm text-white/60 font-mono" x-text="(currentIndex + 1) + ' / ' + items.length"></p>
            </div>
            
            {{-- Navigasi Mobile (Bawah) --}}
            <div class="flex md:hidden items-center gap-6 mt-5 z-[110]">
                <button @click="prev()" class="w-12 h-12 flex items-center justify-center bg-white/10 rounded-full text-white">
                    <x-lucide-chevron-left class="w-7 h-7" />
                </button>
                <button @click="next()" class="w-12 h-12 flex items-center justify-center bg-white/10 rounded-full text-white">
                    <x-lucide-chevron-right class="w-7 h-7" />
                </button>
            </div>
        </div>
    </div>
</section>