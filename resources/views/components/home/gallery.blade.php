@props(['gallery'])

<section id="gallery" class="py-20 lg:py-28 bg-white" data-testid="gallery-section" x-data="{ lightboxOpen: false, lightboxImage: '', lightboxTitle: '' }">
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

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6">

            @foreach($gallery as $i => $g)
            <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer bg-slate-100 border border-slate-100 shadow-sm" 
                 data-testid="gallery-item-{{ $i }}"
                 @click="lightboxOpen = true; lightboxImage = '{{ $g['src'] }}'; lightboxTitle = '{{ addslashes($g['title']) }}'">
                
                <img loading="lazy" src="{{ $g['src'] }}" alt="{{ $g['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="text-white font-semibold text-base leading-snug line-clamp-2">{{ $g['title'] }}</div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>

    <div x-show="lightboxOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors z-[110]">
            <x-lucide-x class="w-6 h-6" />
        </button>

        <div class="absolute inset-0 z-[101]" @click="lightboxOpen = false"></div>

        <div class="relative max-w-5xl w-full max-h-full flex flex-col items-center justify-center z-[102]"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            <img :src="lightboxImage" :alt="lightboxTitle" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl border-2 border-white/10">
            <div class="mt-6 text-center">
                <p class="text-white font-medium text-lg tracking-wide" x-text="lightboxTitle"></p>
            </div>
        </div>
    </div>
</section>