@props(['gallery'])
<section id="gallery" class="py-20 lg:py-28 bg-white" data-testid="gallery-section" x-data="{ lightboxOpen: false, lightboxImage: '', lightboxTitle: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                Dokumentasi
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="gallery-title">
                Galeri Foto Sekolah
            </h2>
            <p class="text-slate-600">
                Momen-momen berharga dari aktivitas, kegiatan, dan keseharian di SMPN 4 Kadupandak.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4">

            @foreach($gallery as $i => $g)
            <div class="group relative overflow-hidden rounded-xl {{ $i === 0 || $i === 5 ? 'row-span-2 aspect-[3/4]' : 'aspect-square' }} cursor-pointer" 
                 data-testid="gallery-item-{{ $i }}"
                 @click="lightboxOpen = true; lightboxImage = '{{ $g['src'] }}'; lightboxTitle = '{{ addslashes($g['title']) }}'">
                <img loading="lazy" src="{{ $g['src'] }}" alt="{{ $g['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <div class="flex items-center gap-2 text-[#F59E0B] text-xs font-semibold uppercase tracking-wider mb-1">
                        <x-lucide-camera class="w-3.5 h-3.5" /> Galeri
                    </div>
                    <div class="text-white font-semibold text-sm leading-snug">{{ $g['title'] }}</div>
                </div>
                
                <!-- Overlay Icon (Click to View) -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <x-lucide-zoom-in class="w-10 h-10 drop-shadow-lg" />
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 sm:p-6 lg:p-10"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Close button -->
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-white/70 hover:text-white bg-black/50 hover:bg-black/80 rounded-full p-2 transition-colors z-[110]">
            <x-lucide-x class="w-6 h-6" />
        </button>

        <!-- Click outside to close -->
        <div class="absolute inset-0 z-[101]" @click="lightboxOpen = false"></div>

        <!-- Image Container -->
        <div class="relative max-w-5xl w-full max-h-full flex flex-col items-center justify-center z-[102]"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            <img :src="lightboxImage" :alt="lightboxTitle" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
            <div class="mt-4 text-center">
                <p class="text-white font-medium text-lg" x-text="lightboxTitle"></p>
            </div>
        </div>
    </div>
</section>
