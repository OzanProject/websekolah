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
    <x-home.gallery :gallery="$gallery" />
    <x-home.video :video="$video" />
    <x-home.facilities :facilities="$facilities" />
    <x-home.testimoni :testimonials="$testimonials" />
    <x-home.contact :profile="$profile" />

@endsection
