@extends('layouts.app')

@section('title', 'Program Unggulan')

@section('content')
    <div class="pt-10">
        <x-home.programs :programs="$programs" />
    </div>
@endsection
