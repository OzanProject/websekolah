@props(['profile' => null])
@php
    $defaultSlides = [
        [
            'image' => 'https://images.pexels.com/photos/18145430/pexels-photo-18145430.jpeg',
            'tag' => 'Selamat Datang',
            'title' => $profile->school_tagline ?? 'Mendidik Generasi Berkarakter & Berprestasi',
            'desc' => ($profile->school_name ?? 'SMP Negeri 4 Kadupandak') . ' hadir sebagai sekolah unggulan di Kabupaten Cianjur dengan kurikulum merdeka, fasilitas modern, dan tenaga pendidik berpengalaman.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644',
            'tag' => 'PPDB 2026/2027',
            'title' => 'Pendaftaran Peserta Didik Baru Telah Dibuka',
            'desc' => 'Bergabung bersama keluarga besar SMPN 4 Kadupandak. Daftar online sekarang dan raih masa depan yang lebih cemerlang bersama kami.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80',
            'tag' => 'Prestasi',
            'title' => 'Sekolah Adiwiyata & Juara Olimpiade Sains',
            'desc' => 'Kami bangga atas berbagai prestasi siswa di tingkat kabupaten dan provinsi yang terus diraih setiap tahunnya.',
        ]
    ];

    $heroSlides = is_array($profile->hero_slides) && count($profile->hero_slides) > 0 
        ? array_map(function($slide) {
            if (!empty($slide['image']) && !filter_var($slide['image'], FILTER_VALIDATE_URL)) {
                $slide['image'] = asset('storage/' . $slide['image']);
            }
            return $slide;
        }, $profile->hero_slides) 
        : $defaultSlides;
@endphp

@push('preload')
@if(isset($heroSlides[0]['image']))
    <link rel="preload" as="image" href="{{ $heroSlides[0]['image'] }}" fetchpriority="high">
@endif
@endpush

<section id="home" class="relative h-[88vh] min-h-[640px] overflow-hidden" data-testid="hero-section" x-data="heroSlider()">
    <template x-for="(slide, index) in slides" :key="index">
        <div class="absolute inset-0 transition-opacity duration-1000" :class="index === active ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" :loading="index === 0 ? 'eager' : 'lazy'" :fetchpriority="index === 0 ? 'high' : 'auto'" />
            <div class="absolute inset-0 bg-gradient-to-b from-[#0F172A]/85 via-[#0F172A]/70 to-[#1E3A8A]/80"></div>
        </div>
    </template>

    <!-- Pattern overlay -->
    <div class="absolute inset-0 opacity-10 z-20" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center z-30">
        <div class="max-w-3xl text-white">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 text-sm font-medium mb-6" data-testid="hero-tag">
                <x-lucide-sparkles class="w-4 h-4 text-[#F59E0B]" />
                <span x-text="slides[active].tag"></span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.1] mb-6" data-testid="hero-title" x-text="slides[active].title"></h1>

            <p class="text-base sm:text-lg text-white/85 leading-relaxed max-w-2xl mb-8" data-testid="hero-desc" x-text="slides[active].desc"></p>

            <div class="flex flex-wrap gap-3">
                @php
                    $btn1Text = $profile->hero_btn1_text ?? 'Daftar PPDB Online';
                    $btn1Url = $profile->hero_btn1_url;
                    
                    // Automatically adapt legacy '/ppdb' to dynamic route
                    if (empty($btn1Url) || $btn1Url === '/ppdb' || $btn1Url === url('/ppdb')) {
                        $btn1Url = route('ppdb.create');
                    }
                    
                    if ($btn1Url === route('ppdb.create') && (!$profile || !$profile->ppdb_active)) {
                        $btn1Url = '';
                    }
                    
                    $btn2Text = $profile->hero_btn2_text ?? 'Profil Sekolah';
                    $btn2Url = $profile->hero_btn2_url ?? '#about';
                @endphp

                @if(!empty($btn1Url))
                    <a href="{{ $btn1Url }}" class="inline-flex items-center justify-center whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#F59E0B] hover:bg-[#D97706] text-[#0F172A] font-bold rounded-lg px-7 h-12 text-base shadow-sm" data-testid="hero-ppdb-btn">
                        {{ $btn1Text }}
                        <x-lucide-chevron-right class="w-5 h-5 ml-1" />
                    </a>
                @endif
                
                @if(!empty($btn2Url))
                    @if(str_starts_with($btn2Url, '#'))
                        <button onclick="document.querySelector('{{ $btn2Url }}')?.scrollIntoView({ behavior: 'smooth' })" class="inline-flex items-center justify-center whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-2 border-white/40 bg-white/10 backdrop-blur-md text-white hover:bg-white hover:text-[#1E3A8A] rounded-lg px-7 h-12 text-base font-semibold" data-testid="hero-profile-btn">
                            {{ $btn2Text }}
                        </button>
                    @else
                        <a href="{{ $btn2Url }}" class="inline-flex items-center justify-center whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-2 border-white/40 bg-white/10 backdrop-blur-md text-white hover:bg-white hover:text-[#1E3A8A] rounded-lg px-7 h-12 text-base font-semibold" data-testid="hero-profile-btn">
                            {{ $btn2Text }}
                        </a>
                    @endif
                @endif
            </div>

            <!-- Mini badges -->
            <div class="mt-12 flex flex-wrap gap-6 text-white/90 text-sm" data-testid="hero-badges">
                <div class="flex items-center gap-2">
                    <x-lucide-award class="w-5 h-5 text-[#F59E0B]" />
                    <span>Akreditasi {{ $profile->school_accreditation ?? 'B' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-lucide-award class="w-5 h-5 text-[#F59E0B]" />
                    <span>NSS {{ $profile->school_nss ?? '201020220018' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-lucide-award class="w-5 h-5 text-[#F59E0B]" />
                    <span>NPSN {{ $profile->school_npsn ?? '20227453' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide indicators -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-30" data-testid="hero-slider-dots">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="active = index" :class="index === active ? 'w-10 bg-[#D97706]' : 'w-6 bg-white/40'" class="h-1.5 rounded-full transition-all" :data-testid="'hero-dot-' + index" :aria-label="'Slide ' + (index + 1)"></button>
        </template>
    </div>
</section>

@endphp<script>
    function heroSlider() {
        return {
            active: 0,
            slides: @json($heroSlides),
            init() {
                setInterval(() => {
                    this.active = (this.active + 1) % this.slides.length;
                }, 6000);
            }
        }
    }
</script>
