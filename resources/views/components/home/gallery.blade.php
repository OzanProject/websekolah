@props(['gallery', 'showAllButton' => false])

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

        @if($showAllButton)
            <div class="mt-12 text-center">
                <a href="{{ url('/galeri') }}" class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 h-11 px-8 rounded-full bg-[#1E3A8A] hover:bg-[#1E40AF] hover:shadow-lg hover:-translate-y-0.5 text-white group">
                    Lihat Semua Galeri <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
        @endif
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
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-slate-800 hover:text-black bg-white hover:bg-slate-100 rounded-full p-2.5 transition-colors z-[110] shadow-lg" title="{{ __('Tutup') }} (Esc)">
            <x-lucide-x class="w-6 h-6" />
        </button>

        {{-- Click outside to close --}}
        <div class="absolute inset-0 z-[101]" @click="lightboxOpen = false"></div>

        {{-- Image & Navigation Container --}}
        <div class="relative max-w-6xl w-full h-full flex flex-col items-center justify-center z-[102] py-8"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            {{-- PERBAIKAN 5: Panah Navigasi --}}
            <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-full md:mr-4 group hidden md:flex items-center justify-center text-slate-800 hover:text-black bg-white hover:bg-slate-100 rounded-full p-3 transition-all z-[110] shadow-xl border border-slate-200" title="{{ __('Sebelumnya') }} (←)">
                <x-lucide-chevron-left class="w-8 h-8 md:w-10 md:h-10 group-hover:-translate-x-1 transition-transform" />
            </button>
            
            <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-full md:ml-4 group hidden md:flex items-center justify-center text-slate-800 hover:text-black bg-white hover:bg-slate-100 rounded-full p-3 transition-all z-[110] shadow-xl border border-slate-200" title="{{ __('Selanjutnya') }} (→)">
                <x-lucide-chevron-right class="w-8 h-8 md:w-10 md:h-10 group-hover:translate-x-1 transition-transform" />
            </button>
            
            {{-- Wrapper Gambar + Teks agar flexibel dan tidak nabrak --}}
            <div class="flex flex-col items-center justify-center h-full w-full min-h-0">
                {{-- Gambar Utama --}}
                <img :src="currentItem.src" :alt="currentItem.title" class="max-w-full min-h-0 object-contain rounded-xl shadow-2xl border border-white/10" style="max-height: 70vh;">
                
                {{-- Keterangan & Counter (Premium Box Style) --}}
                <div class="mt-4 md:mt-6 flex-shrink-0 bg-white px-6 py-3 md:py-4 rounded-2xl shadow-xl border border-slate-100 text-center max-w-2xl mx-auto w-[90%] md:w-auto transition-all duration-300 transform translate-y-0">
                    <p class="font-semibold text-slate-800 text-sm md:text-lg leading-snug line-clamp-2" x-text="currentItem.title"></p>
                    <div class="flex items-center justify-center gap-2 mt-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <p class="text-xs md:text-sm text-slate-500 font-mono font-medium tracking-widest" x-text="(currentIndex + 1) + ' / ' + items.length"></p>
                    </div>
                </div>
            </div>
            
            {{-- Navigasi Mobile (Bawah) --}}
            <div class="flex md:hidden items-center gap-6 mt-3 pb-4 z-[110]">
                <button @click="prev()" class="w-12 h-12 flex items-center justify-center bg-white hover:bg-slate-100 active:bg-slate-200 rounded-full text-slate-800 transition-colors shadow-lg border border-slate-200">
                    <x-lucide-chevron-left class="w-6 h-6" />
                </button>
                <button @click="next()" class="w-12 h-12 flex items-center justify-center bg-white hover:bg-slate-100 active:bg-slate-200 rounded-full text-slate-800 transition-colors shadow-lg border border-slate-200">
                    <x-lucide-chevron-right class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>
</section>