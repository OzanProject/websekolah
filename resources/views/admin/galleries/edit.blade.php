@extends('adminlte::page')

@section('title', 'Edit Foto Galeri')

@section('content_header')
    <h1>Edit Foto Galeri</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title_id">Judul / Deskripsi Singkat Foto</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id', $gallery->getTranslation('title', 'id', false)) }}" placeholder="Masukkan judul foto" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Ganti Foto/Gambar (Opsional)</label>
                    @if($gallery->image_path)
                        <div class="mb-3">
                            <img src="{{ filter_var($gallery->image_path, FILTER_VALIDATE_URL) ? $gallery->image_path : Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image" accept="image/*">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Foto</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
