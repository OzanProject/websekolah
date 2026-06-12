@props(['facilities', 'showAllButton' => false])
<section id="facilities" class="py-20 lg:py-28 bg-white" data-testid="facilities-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                Sarana & Prasarana
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="facilities-title">
                Fasilitas Sekolah
            </h2>
            <p class="text-slate-600">
                Fasilitas lengkap dan modern untuk mendukung pembelajaran yang optimal bagi seluruh siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($facilities as $i => $f)
            <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-testid="facility-{{ $i }}">
                <div class="aspect-[4/3] overflow-hidden">
                    <img loading="lazy" src="{{ $f['image'] }}" alt="{{ $f['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-[#1E3A8A] transition-colors duration-300">
                        @if(str_contains($f['icon'], 'fa-'))
                            <i class="{{ $f['icon'] }} text-[#1E3A8A] group-hover:text-white transition-colors text-xl"></i>
                        @else
                            <x-dynamic-component :component="'lucide-' . ($f['icon'] ?: 'building-2')" class="w-6 h-6 text-[#1E3A8A] group-hover:text-white transition-colors" />
                        @endif
                    </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-[#0F172A] mb-1.5">{{ $f['title'] }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($showAllButton)
            <div class="mt-12 text-center">
                <a href="{{ url('/fasilitas') }}" class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 h-11 px-8 rounded-full bg-[#1E3A8A] hover:bg-[#1E40AF] hover:shadow-lg hover:-translate-y-0.5 text-white group">
                    Lihat Semua Fasilitas <x-lucide-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
        @endif
    </div>
</section>
