@extends('layouts.app')

@section('title', 'Agenda Sekolah')

@section('content')
    <div class="pt-10">
        <x-home.agenda :agenda="$agenda" />
    </div>
@endsection
