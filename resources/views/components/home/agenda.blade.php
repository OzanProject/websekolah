@props(['agenda'])
<section id="agenda" class="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="agenda-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-32">
                    <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                        Kalender Sekolah
                    </div>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-5" data-testid="agenda-title">
                        Agenda Kegiatan
                    </h2>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Jadwal kegiatan, acara, dan kalender akademik SMPN 4 Kadupandak yang akan datang.
                    </p>
                    @if(request()->is('/'))
                        <a href="/agenda" class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 rounded-md bg-[#1E3A8A] hover:bg-[#1E40AF] text-white" data-testid="agenda-view-all-btn">
                            Lihat Semua Agenda <x-lucide-arrow-right class="w-4 h-4 ml-2" />
                        </a>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">

                @foreach($agenda as $i => $a)
                <div class="group flex gap-5 bg-white p-5 lg:p-6 rounded-2xl border border-slate-200 hover:border-[#1E3A8A] hover:shadow-md transition-all" data-testid="agenda-item-{{ $i }}">
                    <div class="flex-shrink-0 w-20 lg:w-24 bg-[#EFF6FF] group-hover:bg-[#1E3A8A] transition-colors rounded-xl flex flex-col items-center justify-center py-3">
                        <div class="text-3xl lg:text-4xl font-bold text-[#1E3A8A] group-hover:text-white transition-colors" style="font-family: 'Outfit', sans-serif;">
                            {{ $a['day'] }}
                        </div>
                        <div class="text-xs uppercase font-semibold tracking-wider text-[#1E3A8A] group-hover:text-[#F59E0B] transition-colors">
                            {{ $a['month'] }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2 leading-snug group-hover:text-[#1E3A8A] transition-colors">
                            {{ $a['title'] }}
                        </h3>
                        <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-slate-600">
                            <span class="flex items-center gap-1.5"><x-lucide-clock class="w-4 h-4 text-[#F59E0B]" /> {{ $a['time'] }}</span>
                            <span class="flex items-center gap-1.5"><x-lucide-map-pin class="w-4 h-4 text-[#F59E0B]" /> {{ $a['location'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
