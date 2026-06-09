@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
    <div class="pt-10">
        <x-home.contact :profile="$profile" />
    </div>
@endsection
