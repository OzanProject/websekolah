@extends('layouts.app')

@section('title', 'Galeri Sekolah')

@section('content')
    <div class="pt-10">
        <x-home.gallery :gallery="$gallery" />
        <x-home.video :video="$video" />
    </div>
@endsection
