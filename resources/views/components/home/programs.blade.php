@props(['programs'])
<section id="programs" class="py-20 lg:py-28 bg-white" data-testid="programs-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-14">
            <div class="max-w-2xl">
                <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                    Program Akademik
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="programs-title">
                    Program Unggulan Sekolah
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Pembelajaran modern yang dirancang untuk mengembangkan potensi akademik, karakter, dan keterampilan siswa.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach($programs as $i => $p)
            <div class="group relative bg-white rounded-2xl border border-slate-200 p-6 hover:border-[#1E3A8A] hover:shadow-lg transition-all duration-300" data-testid="program-{{ $i }}">
                <div class="absolute top-6 right-6 text-6xl font-bold text-slate-100 group-hover:text-[#EFF6FF] transition" style="font-family: 'Outfit', sans-serif;">
                    0{{ $i + 1 }}
                </div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-xl bg-[#EFF6FF] flex items-center justify-center mb-5 group-hover:bg-[#1E3A8A] transition-colors">
                        <x-dynamic-component :component="'lucide-' . ($p['icon'] ?: 'book-open')" class="w-7 h-7 text-[#1E3A8A] group-hover:text-white transition-colors" stroke-width="2" />
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] mb-2">{{ $p['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $p['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
