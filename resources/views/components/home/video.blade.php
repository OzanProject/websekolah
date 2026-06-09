@props(['video'])

@if($video)
<section class="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="video-section">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                {{ __('Video Profil') }}
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="video-title">
                {{ $video->title }}
            </h2>
            @if($video->description)
            <p class="text-slate-600">
                {{ $video->description }}
            </p>
            @endif
        </div>

        <div x-data="{ open: false }" class="relative">
            <div @click="open = true" class="relative aspect-video rounded-2xl overflow-hidden group cursor-pointer shadow-2xl" data-testid="video-thumbnail">
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onerror="this.src='https://images.pexels.com/photos/18145430/pexels-photo-18145430.jpeg'" />
                <div class="absolute inset-0 bg-[#0F172A]/40 group-hover:bg-[#0F172A]/30 transition"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full bg-[#F59E0B]/30 animate-ping"></div>
                        <div class="relative w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white/95 backdrop-blur flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                            <x-lucide-play class="w-8 h-8 lg:w-10 lg:h-10 text-[#1E3A8A] ml-1" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Backdrop -->
            <div x-show="open" 
                 style="display: none;"
                 x-transition.opacity
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                
                <button @click="open = false" class="absolute top-6 right-6 text-white hover:text-gray-300 transition" aria-label="Close modal">
                    <x-lucide-x class="w-8 h-8" />
                </button>
                
                <!-- Modal Content -->
                <div @click.away="open = false" 
                     x-show="open"
                     x-transition.scale.95
                     class="w-full max-w-5xl aspect-video bg-black rounded-xl overflow-hidden shadow-2xl relative">
                    
                    @if($video->youtube_id)
                        <iframe 
                            class="w-full h-full" 
                            x-bind:src="open ? 'https://www.youtube.com/embed/{{ $video->youtube_id }}?autoplay=1' : ''" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-white/50">
                            <x-lucide-video-off class="w-16 h-16 mb-4" />
                            <p>{{ __('Video tidak valid atau tidak dapat diputar.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
