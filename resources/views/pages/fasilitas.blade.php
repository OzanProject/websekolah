@extends('layouts.app')

@section('title', 'Fasilitas Sekolah')

@section('content')
    <div class="pt-10">
        <x-home.facilities :facilities="$facilities" />
    </div>
@endsection
