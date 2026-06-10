@props(['extracurriculars', 'showAllButton' => false])
<section id="extracurriculars" class="py-20 lg:py-28 bg-[#F8FAFC]" data-testid="extracurriculars-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                Pengembangan Diri
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="extracurriculars-title">
                Ekstrakurikuler
            </h2>
            <p class="text-slate-600">
                Berbagai pilihan kegiatan ekstrakurikuler untuk mewadahi minat, bakat, dan potensi siswa di luar jam pelajaran.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($extracurriculars as $i => $e)
            <div class="group relative rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 cursor-pointer bg-white" data-testid="extracurricular-{{ $i }}">
                {{-- Foto Latar Belakang --}}
                <div class="aspect-[4/5] overflow-hidden w-full h-full relative">
                    @if($e['image'])
                        <img loading="lazy" src="{{ $e['image'] }}" alt="{{ $e['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-50 flex items-center justify-center">
                            <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-24 h-24 text-blue-200" />
                        </div>
                    @endif
                    
                    {{-- Overlay Gradasi Gelap di Bawah --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                </div>

                {{-- Konten Text dan Icon --}}
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 text-white group-hover:bg-blue-600 group-hover:border-blue-600 transition-colors duration-300">
                            <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-6 h-6" />
                        </div>
                        <h3 class="text-2xl font-bold text-white">{{ $e['name'] }}</h3>
                    </div>
                    
                    {{-- Deskripsi muncul saat hover --}}
                    <div class="h-0 opacity-0 group-hover:h-auto group-hover:opacity-100 overflow-hidden transition-all duration-500 ease-in-out">
                        <p class="text-white/80 text-sm leading-relaxed mt-2 border-t border-white/20 pt-3">
                            {{ $e['desc'] }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($showAllButton)
            <div class="mt-14 text-center">
                <a href="{{ url('/ekstrakurikuler') }}" class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 h-11 px-8 rounded-full bg-[#1E3A8A] hover:bg-[#1E40AF] hover:shadow-lg hover:-translate-y-0.5 text-white group">
                    Lihat Semua Ekskul <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
        @endif
    </div>
</section>
