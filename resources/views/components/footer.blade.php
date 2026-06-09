@php
    $profile = \App\Models\SchoolProfile::first();
@endphp

<footer class="bg-[#0F172A] text-white relative overflow-hidden" data-testid="footer">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#1E3A8A]/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
            <!-- Brand -->
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-5">
                    @if($profile && $profile->school_logo)
                        <img src="{{ asset('storage/' . $profile->school_logo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover bg-white">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-[#1E3A8A] flex items-center justify-center">
                            <x-lucide-graduation-cap class="w-7 h-7 text-white" />
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-lg">{{ $profile && $profile->school_name ? $profile->school_name : 'SMPN 4 Kadupandak' }}</div>
                        <div class="text-xs text-white/60">{{ $profile && $profile->school_tagline ? $profile->school_tagline : 'Berkarakter, Berprestasi, Berakhlak Mulia' }}</div>
                    </div>
                </div>
                <p class="text-sm text-white/70 leading-relaxed mb-6">
                    {{ $profile && $profile->school_name ? $profile->school_name : 'SMP Negeri 4 Kadupandak' }} adalah sekolah yang berkomitmen mendidik siswa berkarakter, berprestasi, dan berakhlak mulia.
                </p>
                <div class="flex gap-2">
                    @if($profile && $profile->social_facebook)
                    <a href="{{ $profile->social_facebook }}" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-facebook"><x-lucide-facebook class="w-4 h-4" /></a>
                    @endif
                    @if($profile && $profile->social_instagram)
                    <a href="{{ $profile->social_instagram }}" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-instagram"><x-lucide-instagram class="w-4 h-4" /></a>
                    @endif
                    @if($profile && $profile->social_youtube)
                    <a href="{{ $profile->social_youtube }}" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-youtube"><x-lucide-youtube class="w-4 h-4" /></a>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            <div class="lg:col-span-2">
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">{{ __('Navigasi') }}</h4>
                <ul class="space-y-2.5">
                    @php
                        $navs = is_array($profile->footer_navigations) && count($profile->footer_navigations) > 0 ? $profile->footer_navigations : [
                            ['title' => __('Beranda'), 'url' => url('/#home')],
                            ['title' => __('Profil Sekolah'), 'url' => url('/#about')],
                            ['title' => __('Sambutan Kepsek'), 'url' => url('/#sambutan')],
                            ['title' => __('Program Unggulan'), 'url' => url('/#programs')],
                            ['title' => __('Berita & Agenda'), 'url' => url('/berita')],
                            ['title' => __('Kontak'), 'url' => url('/#contact')]
                        ];
                    @endphp
                    
                    @foreach($navs as $nav)
                        <li><a href="{{ $nav['url'] }}" class="text-sm text-white/70 hover:text-[#F59E0B] transition-colors">{{ $nav['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Link Terkait -->
            <div class="lg:col-span-3">
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">{{ __('Tautan Terkait') }}</h4>
                <ul class="space-y-2.5">
                    @php
                        $links = is_array($profile->footer_related_links) && count($profile->footer_related_links) > 0 ? $profile->footer_related_links : [
                            ['title' => 'Kemdikbud RI', 'url' => 'https://www.kemdikbud.go.id'],
                            ['title' => 'Dinas Pendidikan Cianjur', 'url' => '#'],
                            ['title' => 'Dapodik', 'url' => 'https://dapo.kemdikbud.go.id'],
                            ['title' => 'BAN-S/M', 'url' => 'https://bansm.kemdikbud.go.id'],
                            ['title' => 'Rumah Belajar', 'url' => 'https://belajar.kemdikbud.go.id']
                        ];
                    @endphp

                    @foreach($links as $link)
                        <li><a href="{{ $link['url'] }}" target="_blank" rel="noreferrer" class="text-sm text-white/70 hover:text-[#F59E0B] transition-colors inline-flex items-center gap-1.5">{{ $link['title'] }} <x-lucide-arrow-up-right class="w-3.5 h-3.5" /></a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div class="lg:col-span-3">
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">{{ __('Kontak') }}</h4>
                <ul class="space-y-3 text-sm text-white/70">
                    <li class="flex gap-3"><x-lucide-map-pin class="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{{ $profile && $profile->contact_address ? $profile->contact_address : 'Alamat belum diatur' }}</span></li>
                    <li class="flex gap-3"><x-lucide-phone class="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{{ $profile && $profile->contact_phone ? $profile->contact_phone : 'Telepon belum diatur' }}</span></li>
                    <li class="flex gap-3"><x-lucide-mail class="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{{ $profile && $profile->contact_email ? $profile->contact_email : 'Email belum diatur' }}</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-white/50">
            <div>© {{ date('Y') }} {{ $profile && $profile->school_name ? $profile->school_name : 'SMP Negeri 4 Kadupandak' }}. {{ __('Semua hak dilindungi.') }}</div>
            <div class="flex items-center gap-5">
                @if($profile && $profile->school_npsn)<span>NPSN: {{ $profile->school_npsn }}</span>@endif
                @if($profile && $profile->school_nss)<span>NSS: {{ $profile->school_nss }}</span>@endif
                @if($profile && $profile->school_accreditation)<span>Akreditasi {{ $profile->school_accreditation }}</span>@endif
            </div>
        </div>
    </div>
</footer>
