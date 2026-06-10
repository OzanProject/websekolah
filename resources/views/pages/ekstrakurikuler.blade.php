@extends('layouts.app')

@section('title', 'Ekstrakurikuler Sekolah')

@section('content')
    <div class="pt-10 pb-20">
        <x-home.extracurriculars :extracurriculars="$extracurriculars" />
    </div>
@endsection
