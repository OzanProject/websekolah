@extends('adminlte::page')

@section('title', 'Tambah Video')

@section('content_header')
    <h1>Tambah Video Profil</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title_id">Judul Video</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id') }}" placeholder="Masukkan judul video" required>
                </div>
                <div class="form-group">
                    <label for="description_id">Deskripsi Singkat</label>
                    <textarea name="description[id]" class="form-control" id="description_id" rows="3" placeholder="Masukkan deskripsi (opsional)">{{ old('description.id') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="url">URL YouTube</label>
                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" id="url" placeholder="Contoh: https://www.youtube.com/watch?v=..." value="{{ old('url') }}" required>
                    <small class="text-muted">Masukkan link lengkap dari video YouTube.</small>
                    @error('url')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Jadikan Video Aktif (Ditampilkan di halaman depan)</label>
                    </div>
                    <small class="form-text text-warning"><i class="fas fa-exclamation-triangle"></i> Jika diaktifkan, video aktif sebelumnya akan otomatis dinonaktifkan.</small>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Video</button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
