@props(['profile'])

<section class="relative py-20 lg:py-28 bg-[#1E3A8A] overflow-hidden" data-testid="stats-section" x-data="{ shown: false }" x-init="$nextTick(() => { let obs = new IntersectionObserver(e => { if(e[0].isIntersecting) { shown = true; obs.disconnect(); } }, { threshold: 0.3 }); obs.observe($el); })">
    <!-- Decorative -->
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#F59E0B]/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-4">
                Mengapa Memilih Kami
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" data-testid="stats-title">
                Pencapaian Sekolah Kami
            </h2>
            <p class="text-white/75 leading-relaxed">
                Angka-angka yang menunjukkan dedikasi dan kualitas pendidikan di SMPN 4 Kadupandak
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <!-- Stat 1 -->
            <div class="text-center" data-testid="stat-jumlah-siswa" x-data="{ count: 0, target: {{ $profile ? $profile->stat_student : 0 }} }" x-effect="if(shown && count < target) { let t = setInterval(() => { count += Math.ceil(target/100); if(count >= target) { count = target; clearInterval(t); } }, 20) }">
                <div class="inline-flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur items-center justify-center mb-5">
                    <x-lucide-users class="w-8 h-8 text-[#F59E0B]" stroke-width="2" />
                </div>
                <div class="text-5xl lg:text-6xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    <span x-text="count"></span>+
                </div>
                <div class="text-white/80 font-medium">Jumlah Siswa</div>
            </div>

            <!-- Stat 2 -->
            <div class="text-center" data-testid="stat-guru-staf" x-data="{ count: 0, target: {{ $profile ? $profile->stat_teacher : 0 }} }" x-effect="if(shown && count < target) { let t = setInterval(() => { count += Math.ceil(target/100); if(count >= target) { count = target; clearInterval(t); } }, 40) }">
                <div class="inline-flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur items-center justify-center mb-5">
                    <x-lucide-graduation-cap class="w-8 h-8 text-[#F59E0B]" stroke-width="2" />
                </div>
                <div class="text-5xl lg:text-6xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    <span x-text="count"></span>
                </div>
                <div class="text-white/80 font-medium">Guru & Staf</div>
            </div>

            <!-- Stat 3 -->
            <div class="text-center" data-testid="stat-rombongan-belajar" x-data="{ count: 0, target: {{ $profile ? $profile->stat_class : 0 }} }" x-effect="if(shown && count < target) { let t = setInterval(() => { count += Math.ceil(target/100); if(count >= target) { count = target; clearInterval(t); } }, 60) }">
                <div class="inline-flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur items-center justify-center mb-5">
                    <x-lucide-book-open class="w-8 h-8 text-[#F59E0B]" stroke-width="2" />
                </div>
                <div class="text-5xl lg:text-6xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    <span x-text="count"></span>
                </div>
                <div class="text-white/80 font-medium">Rombongan Belajar</div>
            </div>

            <!-- Stat 4 -->
            <div class="text-center" data-testid="stat-prestasi-diraih" x-data="{ count: 0, target: {{ $profile ? $profile->stat_achievement : 0 }} }" x-effect="if(shown && count < target) { let t = setInterval(() => { count += Math.ceil(target/100); if(count >= target) { count = target; clearInterval(t); } }, 30) }">
                <div class="inline-flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur items-center justify-center mb-5">
                    <x-lucide-award class="w-8 h-8 text-[#F59E0B]" stroke-width="2" />
                </div>
                <div class="text-5xl lg:text-6xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    <span x-text="count"></span>+
                </div>
                <div class="text-white/80 font-medium">Prestasi Diraih</div>
            </div>
        </div>
    </div>
</section>
