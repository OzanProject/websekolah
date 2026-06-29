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
                    <label for="title_id">Judul / Deskripsi Singkat Foto (Opsional)</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id') }}" placeholder="Contoh: Kegiatan Sekolah">
                    <small class="form-text text-muted">Jika dikosongkan, nama file asli akan otomatis digunakan sebagai judul. Jika Anda mengunggah banyak file dan mengisi ini, akan otomatis diberi nomor urut.</small>
                </div>
                
                <div class="form-group">
                    <label for="images">File Foto/Gambar (Bisa pilih banyak sekaligus)</label>
                    <input type="file" name="images[]" class="form-control-file @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" id="images" required accept="image/*" multiple>
                    <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG, GIF. Maks: 2MB per file. (Gunakan CTRL+Klik untuk memilih banyak foto sekaligus)</small>
                    @error('images')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @error('images.*')
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
