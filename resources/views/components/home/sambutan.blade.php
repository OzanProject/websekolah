@props(['profile'])

<section id="sambutan" class="py-20 lg:py-28 bg-white" data-testid="sambutan-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Image side -->
            <div class="relative">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-[#F59E0B] rounded-2xl -z-10"></div>
                <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-[#EFF6FF] rounded-2xl -z-10"></div>
                <div class="relative rounded-2xl overflow-hidden border-4 border-white shadow-2xl">
                    <img loading="lazy" src="{{ $profile && $profile->kepsek_image ? asset('storage/' . $profile->kepsek_image) : 'https://images.pexels.com/photos/8197521/pexels-photo-8197521.jpeg' }}" alt="Kepala Sekolah" class="w-full aspect-[4/5] object-cover" data-testid="kepsek-image" />
                </div>
                <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur rounded-xl p-4 shadow-lg" data-testid="kepsek-badge">
                    <div class="font-bold text-[#0F172A]">{{ $profile && $profile->kepsek_name ? $profile->kepsek_name : 'Nama Kepala Sekolah' }}</div>
                    <div class="text-sm text-[#1E3A8A] font-medium">Kepala Sekolah</div>
                </div>
            </div>

            <!-- Content side -->
            <div>
                <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4" data-testid="sambutan-eyebrow">
                    Sambutan
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-6" data-testid="sambutan-title">
                    Selamat Datang di Website Resmi Kami
                </h2>
                
                <div class="prose prose-lg text-slate-600 mb-8" data-testid="sambutan-content">
                    @if($profile && $profile->sambutan_content)
                        {!! $profile->sambutan_content !!}
                    @else
                        <p class="leading-relaxed mb-4">
                            Assalamu'alaikum Warahmatullahi Wabarakatuh.
                        </p>
                        <p class="leading-relaxed mb-4">
                            Puji syukur kita panjatkan ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya. Selamat datang di website resmi SMP Negeri 4 Kadupandak.
                        </p>
                        <p class="leading-relaxed">
                            Di era digital ini, kami berkomitmen untuk terus berinovasi dan memberikan pelayanan pendidikan terbaik. Website ini hadir sebagai wujud transparansi dan media komunikasi interaktif antara sekolah, peserta didik, orang tua, dan masyarakat luas.
                        </p>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-4" data-testid="sambutan-actions">
                    <a href="{{ url('/profil') }}" class="inline-flex items-center justify-center bg-[#1E3A8A] hover:bg-[#1E40AF] text-white font-semibold rounded-lg px-8 h-12 transition">
                        Lebih Lanjut <x-lucide-arrow-right class="w-4 h-4 ml-2" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
