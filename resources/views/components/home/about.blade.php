@props(['profile'])

<section id="about" class="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="about-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4" data-testid="about-eyebrow">
                Tentang Kami
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="about-title">
                Visi & Misi Sekolah
            </h2>
            <p class="text-slate-600 leading-relaxed">
                Komitmen kami dalam mendidik generasi penerus bangsa yang berkarakter dan berprestasi.
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            <!-- Visi -->
            <div class="lg:col-span-2 bg-[#1E3A8A] text-white rounded-2xl p-8 lg:p-10 relative overflow-hidden" data-testid="visi-card">
                <x-lucide-quote class="absolute -top-2 -right-2 w-32 h-32 text-white/5" />
                <div class="relative">
                    <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center mb-6">
                        <x-lucide-eye class="w-7 h-7 text-[#F59E0B]" />
                    </div>
                    <div class="text-[#F59E0B] text-sm font-semibold uppercase tracking-wider mb-3">Visi</div>
                    <p class="text-xl lg:text-2xl font-semibold leading-snug" style="font-family: 'Outfit', sans-serif;">
                        {{ $profile ? $profile->visi : 'Visi sekolah belum diatur.' }}
                    </p>
                </div>
            </div>

            <!-- Misi -->
            <div class="lg:col-span-3 bg-white rounded-2xl p-8 lg:p-10 border border-slate-200" data-testid="misi-card">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-14 h-14 rounded-xl bg-[#EFF6FF] flex items-center justify-center">
                        <x-lucide-target class="w-7 h-7 text-[#1E3A8A]" />
                    </div>
                    <div>
                        <div class="text-[#1E3A8A] text-sm font-semibold uppercase tracking-wider">Misi</div>
                        <div class="text-xl font-bold text-[#0F172A]">Pilar Pendidikan Kami</div>
                    </div>
                </div>
                <ul class="space-y-4">
                    @if($profile && is_array($profile->misi))
                        @foreach($profile->misi as $misiItem)
                        <li class="flex gap-3">
                            <x-lucide-check-circle-2 class="w-5 h-5 text-[#F59E0B] flex-shrink-0 mt-0.5" />
                            <span class="text-slate-700 leading-relaxed">{{ $misiItem }}</span>
                        </li>
                        @endforeach
                    @else
                        <li class="flex gap-3">
                            <span class="text-slate-700 leading-relaxed">Misi sekolah belum diatur.</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
