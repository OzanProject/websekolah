@extends('adminlte::page')

@section('title', 'Detail Berita')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detail Berita</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $news->title }}</h3>
            <div class="card-tools">
                <span class="badge badge-info"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($news->date)->translatedFormat('d F Y') }}</span>
                <span class="badge badge-primary"><i class="fas fa-eye"></i> {{ $news->views }} Dilihat</span>
            </div>
        </div>
        <div class="card-body">
            @if($news->image)
                <div class="text-center mb-4">
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                </div>
            @endif
            
            <div class="news-content" style="font-size: 1.1rem; line-height: 1.8;">
                {!! $news->content !!}
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-info">
                <i class="fas fa-edit"></i> Edit Berita
            </a>
            <a href="{{ url('/berita/' . $news->slug) }}" target="_blank" class="btn btn-success">
                <i class="fas fa-external-link-alt"></i> Lihat di Website
            </a>
        </div>
    </div>
@stop
