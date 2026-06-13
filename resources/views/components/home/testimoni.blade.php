@props(['testimonials'])
<section class="py-20 lg:py-28 bg-[#0F172A] relative overflow-hidden" data-testid="testimoni-section" x-data="testimoniSlider({{ json_encode($testimonials) }})">
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#1E3A8A]/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-4">
                Testimoni
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" data-testid="testimoni-title">
                Apa Kata Mereka?
            </h2>
            <p class="text-white/70">
                Pengalaman siswa, alumni, dan orang tua tentang SMPN 4 Kadupandak.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <template x-for="(t, i) in testimonials" :key="i">
                <div :class="i === active ? 'ring-2 ring-[#F59E0B]' : ''" class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 lg:p-8 hover:bg-white/10 transition-all" :data-testid="'testimoni-card-' + i">
                    <x-lucide-quote class="w-10 h-10 text-[#F59E0B] mb-4" />
                    <div class="flex gap-1 mb-4">
                        <x-lucide-star class="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />
                        <x-lucide-star class="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />
                        <x-lucide-star class="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />
                        <x-lucide-star class="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />
                        <x-lucide-star class="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />
                    </div>
                    <p class="text-white/90 leading-relaxed mb-6 text-sm lg:text-base" x-text="`&quot;${t.quote}&quot;`"></p>
                    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <img loading="lazy" :src="t.avatar" :alt="t.name" class="w-12 h-12 rounded-full object-cover ring-2 ring-[#F59E0B]/40" />
                        <div>
                            <div class="font-semibold text-white" x-text="t.name"></div>
                            <div class="text-xs text-white/60" x-text="t.role"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex justify-center gap-3 mt-10">
            <button aria-label="Previous" @click="prev" class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#F59E0B] text-white flex items-center justify-center transition-all backdrop-blur-sm border border-white/20" data-testid="testimoni-prev">
                <x-lucide-chevron-left class="w-6 h-6" />
            </button>
            <button aria-label="Next" @click="next" class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#F59E0B] text-white flex items-center justify-center transition-all backdrop-blur-sm border border-white/20" data-testid="testimoni-next">
                <x-lucide-chevron-right class="w-6 h-6" />
            </button>
        </div>
    </div>
</section>

<script>
    function testimoniSlider(testimonials) {
        return {
            active: 0,
            testimonials: testimonials,
            prev() {
                this.active = (this.active - 1 + this.testimonials.length) % this.testimonials.length;
            },
            next() {
                this.active = (this.active + 1) % this.testimonials.length;
            }
        }
    }
</script>
