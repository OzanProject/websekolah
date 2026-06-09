@props(['profile'])

<section id="contact" class="py-20 lg:py-28 bg-white" data-testid="contact-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                {{ __('Hubungi Kami') }}
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="contact-title">
                {{ __('Mari Terhubung dengan Kami') }}
            </h2>
            <p class="text-slate-600">
                {{ __('Ada pertanyaan? Tim kami siap membantu. Silakan hubungi atau kirim pesan kepada kami.') }}
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            <!-- Contact info + map -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition" data-testid="contact-info-0">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#1E3A8A] flex items-center justify-center">
                        <x-lucide-map-pin class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <div class="font-semibold text-[#0F172A]">{{ __('Alamat') }}</div>
                        <div class="text-sm text-slate-600 leading-relaxed mt-0.5">{{ $profile && $profile->contact_address ? $profile->contact_address : __('Alamat belum diatur') }}</div>
                    </div>
                </div>

                <div class="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition" data-testid="contact-info-1">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#1E3A8A] flex items-center justify-center">
                        <x-lucide-phone class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <div class="font-semibold text-[#0F172A]">{{ __('Telepon') }}</div>
                        <div class="text-sm text-slate-600 leading-relaxed mt-0.5">{{ $profile && $profile->contact_phone ? $profile->contact_phone : __('Telepon belum diatur') }}</div>
                    </div>
                </div>

                <div class="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition" data-testid="contact-info-2">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#1E3A8A] flex items-center justify-center">
                        <x-lucide-mail class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <div class="font-semibold text-[#0F172A]">{{ __('Email') }}</div>
                        <div class="text-sm text-slate-600 leading-relaxed mt-0.5">{{ $profile && $profile->contact_email ? $profile->contact_email : __('Email belum diatur') }}</div>
                    </div>
                </div>

                <div class="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition" data-testid="contact-info-3">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#1E3A8A] flex items-center justify-center">
                        <x-lucide-clock class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <div class="font-semibold text-[#0F172A]">{{ __('Jam Operasional') }}</div>
                        <div class="text-sm text-slate-600 leading-relaxed mt-0.5">{{ $profile && $profile->contact_hours ? $profile->contact_hours : __('Jam belum diatur') }}</div>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden border border-slate-200 aspect-[4/3]" data-testid="contact-map">
                    <iframe title="{{ __('Lokasi Sekolah') }}" src="{{ $profile && $profile->contact_map ? $profile->contact_map : 'https://www.openstreetmap.org/export/embed.html?bbox=107.0683%2C-7.3683%2C107.1683%2C-7.2683&layer=mapnik&marker=-7.3183%2C107.1183' }}" class="w-full h-full" style="border: 0;" loading="lazy"></iframe>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <span class="text-sm font-semibold text-slate-700">{{ __('Ikuti kami') }}:</span>
                    @if($profile && $profile->social_facebook)
                    <a href="{{ $profile->social_facebook }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" title="Facebook">
                        <x-lucide-facebook class="w-4 h-4" />
                    </a>
                    @endif
                    @if($profile && $profile->social_instagram)
                    <a href="{{ $profile->social_instagram }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" title="Instagram">
                        <x-lucide-instagram class="w-4 h-4" />
                    </a>
                    @endif
                    @if($profile && $profile->social_youtube)
                    <a href="{{ $profile->social_youtube }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" title="YouTube">
                        <x-lucide-youtube class="w-4 h-4" />
                    </a>
                    @endif
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('contact.send') }}" method="POST" x-data="{ loading: false }" @submit="loading = true" class="lg:col-span-3 bg-[#FAFAFA] rounded-2xl p-6 lg:p-10 border border-slate-100" data-testid="contact-form">
                @csrf
                <h3 class="text-2xl font-bold text-[#0F172A] mb-2">{{ __('Kirim Pesan') }}</h3>
                <p class="text-slate-600 mb-6">{{ __('Sampaikan pertanyaan, saran, atau pesan Anda kepada kami.') }}</p>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="text-sm font-semibold text-slate-700 mb-1.5 block">{{ __('Nama Lengkap') }} *</label>
                        <input type="text" id="name" name="name" required placeholder="{{ __('Masukkan nama Anda') }}" class="w-full h-12 px-3 rounded-lg bg-white border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent" />
                    </div>
                    <div>
                        <label for="email" class="text-sm font-semibold text-slate-700 mb-1.5 block">{{ __('Email') }} *</label>
                        <input type="email" id="email" name="email" required placeholder="nama@email.com" class="w-full h-12 px-3 rounded-lg bg-white border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent" />
                    </div>
                </div>

                <div class="mb-4">
                    <label for="subject" class="text-sm font-semibold text-slate-700 mb-1.5 block">{{ __('Subjek') }}</label>
                    <input type="text" id="subject" name="subject" placeholder="{{ __('Topik pesan Anda') }}" class="w-full h-12 px-3 rounded-lg bg-white border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent" />
                </div>

                <div class="mb-6">
                    <label for="message" class="text-sm font-semibold text-slate-700 mb-1.5 block">{{ __('Pesan') }} *</label>
                    <textarea id="message" name="message" required placeholder="{{ __('Tulis pesan Anda di sini...') }}" rows="5" class="w-full p-3 rounded-lg bg-white border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent"></textarea>
                </div>

                <button type="submit" :disabled="loading" class="inline-flex items-center justify-center bg-[#1E3A8A] hover:bg-[#1E40AF] text-white font-semibold rounded-lg w-full sm:w-auto px-8 h-12 disabled:opacity-50 transition-colors" data-testid="contact-submit-btn">
                    <span x-show="!loading" class="flex items-center">{{ __('Kirim Pesan') }} <x-lucide-send class="w-4 h-4 ml-2" /></span>
                    <span x-show="loading" x-cloak>{{ __('Mengirim...') }}</span>
                </button>
            </form>
        </div>
    </div>
</section>
