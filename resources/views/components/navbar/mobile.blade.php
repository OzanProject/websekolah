@props(['menus', 'profile' => null])

<div x-show="open" x-transition x-cloak class="lg:hidden border-t border-slate-200 py-4 space-y-1" data-testid="mobile-nav-menu" style="display: none;">
    @foreach($menus as $menu)
        @if(isset($menu['is_dropdown']) && $menu['is_dropdown'])
            <div class="px-2">
                <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase">{{ __($menu['title']) }}</div>
                @if(isset($menu['children']) && is_array($menu['children']))
                    @foreach($menu['children'] as $child)
                        <a href="{{ url($child['url'] ?? '#') }}" @click="open = false" class="block w-full text-left px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-md">{{ __(($child['title'] ?? '')) }}</a>
                    @endforeach
                @endif
            </div>
        @else
            <a href="{{ url($menu['url'] ?? '#') }}" @click="open = false" class="block w-full text-left px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-md">{{ __($menu['title']) }}</a>
        @endif
    @endforeach

    @if($profile && $profile->ppdb_active)
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="{{ route('ppdb.create') }}" class="flex items-center justify-center whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 py-2 w-full bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-md" data-testid="mobile-nav-ppdb-btn">
            Daftar PPDB
        </a>
    </div>
    @endif

    <div class="px-5 pt-3 pb-2 border-t border-slate-100 mt-2">
        <div class="text-xs font-semibold text-slate-400 uppercase mb-2">Bahasa / Language</div>
        <div class="flex gap-2">
            @php $currentLocale = App::getLocale(); @endphp
            <a href="{{ route('locale.switch', 'id') }}" class="px-3 py-1.5 text-sm rounded-md border {{ $currentLocale == 'id' ? 'border-[#1E3A8A] bg-blue-50 text-[#1E3A8A] font-bold' : 'border-slate-200 text-slate-600 bg-white' }}">🇮🇩 ID</a>
            <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1.5 text-sm rounded-md border {{ $currentLocale == 'en' ? 'border-[#1E3A8A] bg-blue-50 text-[#1E3A8A] font-bold' : 'border-slate-200 text-slate-600 bg-white' }}">🇬🇧 EN</a>
            <a href="{{ route('locale.switch', 'ar') }}" class="px-3 py-1.5 text-sm rounded-md border {{ $currentLocale == 'ar' ? 'border-[#1E3A8A] bg-blue-50 text-[#1E3A8A] font-bold' : 'border-slate-200 text-slate-600 bg-white' }}">🇸🇦 AR</a>
        </div>
    </div>
</div>
