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
            <div x-data="{ open: false }">
                <div @click="open = true" class="group flex flex-col bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer h-full" data-testid="extracurricular-{{ $i }}">
                    {{-- Foto Landscape --}}
                    <div class="aspect-video w-full overflow-hidden relative bg-slate-100 shrink-0">
                        @if($e['image'])
                            <img loading="lazy" src="{{ $e['image'] }}" alt="{{ $e['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                        @else
                            <div class="absolute right-0 top-0 opacity-[0.03] transform translate-x-4 -translate-y-4 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                                @if(str_contains($e['icon'], 'fa-'))
                                    <i class="{{ $e['icon'] }} text-blue-200" style="font-size: 4rem;"></i>
                                @else
                                    <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-16 h-16 text-blue-200" />
                                @endif
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors duration-300"></div>
                        
                        {{-- Indikator Preview (Kaca Pembesar) --}}
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                            <div class="bg-black/50 text-white p-3 rounded-full backdrop-blur-sm shadow-lg">
                                <x-lucide-search class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    {{-- Konten Text dan Icon --}}
                    <div class="flex flex-col flex-grow p-6 sm:p-7">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#1E3A8A] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm relative z-10">
                                @if(str_contains($e['icon'], 'fa-'))
                                    <i class="{{ $e['icon'] }} text-xl"></i>
                                @else
                                    <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-6 h-6" />
                                @endif
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

                {{-- Modal Preview / Detail --}}
                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 sm:p-6" x-transition.opacity style="display: none;">
                        <div @click.away="open = false" class="bg-white rounded-2xl sm:rounded-3xl max-w-3xl w-full overflow-hidden shadow-2xl relative flex flex-col max-h-[90vh]" x-transition x-show="open">
                            
                            {{-- Tombol Tutup --}}
                            <button @click="open = false" class="absolute top-4 right-4 p-2 bg-black/50 text-white rounded-full hover:bg-black/80 transition-colors z-10 shadow-md">
                                <x-lucide-x class="w-5 h-5" />
                            </button>
                            
                            {{-- Gambar Besar --}}
                            @if($e['image'])
                                <img src="{{ $e['image'] }}" alt="{{ $e['name'] }}" class="w-full h-64 sm:h-96 object-cover bg-slate-100 shrink-0" />
                            @else
                                <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
                                    @if(str_contains($e['icon'], 'fa-'))
                                        <i class="{{ $e['icon'] }} text-blue-200" style="font-size: 8rem;"></i>
                                    @else
                                        <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-32 h-32 text-blue-200" />
                                    @endif
                                </div>
                            @endif
                            
                            {{-- Konten Detail --}}
                            <div class="p-6 sm:p-10 overflow-y-auto">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 rounded-2xl bg-white text-[#1E3A8A] flex items-center justify-center shadow-md">
                                        @if(str_contains($e['icon'], 'fa-'))
                                            <i class="{{ $e['icon'] }} text-2xl"></i>
                                        @else
                                            <x-dynamic-component :component="'lucide-' . ($e['icon'] ?: 'activity')" class="w-7 h-7" />
                                        @endif
                                    </div>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-[#0F172A]">{{ $e['name'] }}</h3>
                                </div>
                                <div class="prose prose-slate max-w-none">
                                    <p class="text-slate-700 leading-relaxed text-base sm:text-lg whitespace-pre-line">{{ $e['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
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
