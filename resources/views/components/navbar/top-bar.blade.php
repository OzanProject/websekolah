@props(['profile'])

<div class="hidden md:block bg-[#0F172A] text-white text-xs relative z-[60]" data-testid="top-info-bar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-2">
        <div class="flex items-center gap-6">
            <span class="flex items-center gap-2"><x-lucide-mail class="w-3.5 h-3.5" /> {{ $profile && $profile->contact_email ? $profile->contact_email : 'info@smpn4kadupandak.sch.id' }}</span>
            <span class="flex items-center gap-2"><x-lucide-phone class="w-3.5 h-3.5" /> {{ $profile && $profile->contact_phone ? $profile->contact_phone : '+62 263 555 0188' }}</span>
        </div>
        <div class="flex items-center gap-4 text-white/70">
            <!-- Language Switcher -->
            <div x-data="{ topLangOpen: false }" @click.away="topLangOpen = false" class="relative">
                <button @click="topLangOpen = !topLangOpen" class="flex items-center gap-1 hover:text-white transition-colors outline-none font-medium">
                    @php $currentLocale = App::getLocale(); @endphp
                    @if($currentLocale == 'id') 🇮🇩 ID @elseif($currentLocale == 'en') 🇬🇧 EN @elseif($currentLocale == 'ar') 🇸🇦 AR @endif
                    <x-lucide-chevron-down class="w-3 h-3" />
                </button>
                <div x-show="topLangOpen" x-transition x-cloak style="display: none;" class="absolute right-0 mt-2 w-24 rounded-md shadow-lg bg-[#1E293B] ring-1 ring-white/10 focus:outline-none z-50 text-white">
                    <div class="py-1">
                        <a href="{{ route('locale.switch', 'id') }}" class="block px-4 py-2 text-sm hover:bg-[#334155] {{ $currentLocale == 'id' ? 'font-bold bg-[#0F172A]' : '' }}">🇮🇩 ID</a>
                        <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm hover:bg-[#334155] {{ $currentLocale == 'en' ? 'font-bold bg-[#0F172A]' : '' }}">🇬🇧 EN</a>
                        <a href="{{ route('locale.switch', 'ar') }}" class="block px-4 py-2 text-sm hover:bg-[#334155] {{ $currentLocale == 'ar' ? 'font-bold bg-[#0F172A]' : '' }}">🇸🇦 AR</a>
                    </div>
                </div>
            </div>

            @if($profile && $profile->school_npsn)<span>|</span><span>NPSN: {{ $profile->school_npsn }}</span>@endif
            @if($profile && $profile->school_npsn && $profile->school_accreditation)<span>•</span>@endif
            @if($profile && $profile->school_accreditation)<span>Akreditasi {{ $profile->school_accreditation }}</span>@endif
        </div>
    </div>
</div>
