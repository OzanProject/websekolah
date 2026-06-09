@extends('layouts.app')

@section('title', $page->title . ' - ' . config('app.name'))

@section('content')
    <!-- Page Header -->
    <div class="bg-primary-900 text-white py-16 md:py-24 relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none opacity-20">
            <svg class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] text-white" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="0,0 100,0 50,100"></polygon>
            </svg>
        </div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 font-outfit" data-aos="fade-up">
                {{ $page->title }}
            </h1>
            <div class="w-24 h-1 bg-secondary-500 mx-auto rounded-full" data-aos="fade-up" data-aos-delay="100"></div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="py-16 bg-slate-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 relative overflow-hidden" data-aos="fade-up">
                <div class="prose prose-lg md:prose-xl prose-slate max-w-none prose-headings:font-outfit prose-a:text-primary-600 hover:prose-a:text-primary-800 prose-img:rounded-xl">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
