@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
    <div class="pt-10">
        <x-home.about :profile="$profile" />
        <x-home.stats :profile="$profile" />
        <x-home.sambutan :profile="$profile" />
    </div>
@endsection
