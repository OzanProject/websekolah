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
            <div class="group flex flex-col bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer" data-testid="extracurricular-{{ $i }}">
                {{-- Foto Landscape --}}
                <div class="aspect-video w-full overflow-hidden relative bg-slate-100">
                    @if($e['image'])
                        <img loading="lazy" src="{{ $e['image'] }}" alt="{{ $e['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                            <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-16 h-16 text-blue-200" />
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors duration-300"></div>
                </div>

                {{-- Konten Text dan Icon --}}
                <div class="flex flex-col flex-grow p-6 sm:p-7">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50/80 text-[#1E3A8A] flex items-center justify-center group-hover:bg-[#1E3A8A] group-hover:text-white transition-colors duration-300 shrink-0">
                            <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold text-[#0F172A] group-hover:text-[#1E3A8A] transition-colors line-clamp-1">{{ $e['name'] }}</h3>
                    </div>
                    
                    {{-- Deskripsi Selalu Tampil --}}
                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-6 flex-grow">
                        {{ $e['desc'] }}
                    </p>
                    
                    {{-- Aksi --}}
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-sm font-semibold text-[#1E3A8A] group-hover:text-[#1E40AF]">
                        <span>Selengkapnya</span>
                        <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
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
