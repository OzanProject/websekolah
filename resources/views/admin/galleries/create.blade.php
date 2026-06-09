@extends('adminlte::page')

@section('title', 'Tambah Foto Galeri')

@section('content_header')
    <h1>Tambah Foto Galeri</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title_id">Judul / Deskripsi Singkat Foto</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id') }}" placeholder="Masukkan judul foto" required>
                </div>
                
                <div class="form-group">
                    <label for="image">File Foto/Gambar</label>
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image" required accept="image/*">
                    <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG, GIF. Maks: 2MB.</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Foto</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
