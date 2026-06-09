@props(['latestNews'])

    <!-- Berita Preview Section -->
    <section id="news" class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-[#0F172A]">Berita Terbaru</h2>
                    <div class="w-20 h-1 bg-[#F59E0B] mt-4 rounded-full"></div>
                </div>
                <a href="{{ url('/berita') }}" class="text-[#1E3A8A] font-medium hover:underline inline-flex items-center gap-1">
                    Lihat Semua <x-lucide-arrow-right class="w-4 h-4" />
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($latestNews as $news)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-100 flex flex-col h-full group">
                    <div class="h-48 overflow-hidden relative">
                        <img loading="lazy" src="{{ $news->image ? Storage::url($news->image) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644' }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @if($news->category)
                        <div class="absolute top-4 left-4 bg-[#F59E0B] text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {{ $news->category->name }}
                        </div>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-4 text-xs text-slate-500 mb-3">
                            <span class="flex items-center gap-1"><x-lucide-calendar class="w-3.5 h-3.5" /> {{ \Carbon\Carbon::parse($news->date)->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-3 line-clamp-2"><a href="{{ url('/berita/' . $news->slug) }}" class="hover:text-[#1E3A8A]">{{ $news->title }}</a></h3>
                        <p class="text-slate-600 text-sm line-clamp-3 mb-4">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                        <div class="mt-auto pt-4 border-t border-slate-100">
                            <a href="{{ url('/berita/' . $news->slug) }}" class="text-[#1E3A8A] text-sm font-semibold inline-flex items-center gap-1 hover:text-[#F59E0B] transition">Baca Selengkapnya <x-lucide-arrow-right class="w-4 h-4" /></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
