@props(['menus'])

<nav class="hidden lg:flex items-center gap-1">
    @foreach($menus as $menu)
        @if(isset($menu['is_dropdown']) && $menu['is_dropdown'])
            <div x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1E3A8A] flex items-center gap-1 outline-none">
                    {{ __($menu['title']) }} <x-lucide-chevron-down class="w-4 h-4" />
                </button>
                <div x-show="dropdownOpen" x-transition x-cloak style="display: none;" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                    <div class="py-1">
                        @if(isset($menu['children']) && is_array($menu['children']))
                            @foreach($menu['children'] as $child)
                                <a href="{{ url($child['url'] ?? '#') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __(($child['title'] ?? '')) }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @else
            <a href="{{ url($menu['url'] ?? '#') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1E3A8A] transition-colors">{{ __($menu['title']) }}</a>
        @endif
    @endforeach
</nav>
