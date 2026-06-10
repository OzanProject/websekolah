@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <x-home.hero :profile="$profile" />

    <x-home.about :profile="$profile" />
    <x-home.stats :profile="$profile" />
    <x-home.sambutan :profile="$profile" />
    <x-home.programs :programs="$programs" />

    <x-home.news :latestNews="$latestNews" />

    <x-home.agenda :agenda="$agenda" />
    <x-home.gallery :gallery="$gallery" :show-all-button="true" />
    <x-home.video :video="$video" />
    <x-home.facilities :facilities="$facilities" :show-all-button="true" />
    <x-home.extracurriculars :extracurriculars="$extracurriculars" :show-all-button="true" />
    <x-home.testimoni :testimonials="$testimonials" />
    <x-home.contact :profile="$profile" />

@endsection
