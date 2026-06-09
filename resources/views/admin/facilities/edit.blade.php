@extends('adminlte::page')

@section('title', 'Edit Fasilitas')

@section('content_header')
    <h1>Edit Fasilitas</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title_id">Nama Fasilitas</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id', $facility->getTranslation('title', 'id', false)) }}" placeholder="Masukkan nama fasilitas" required>
                </div>
                <div class="form-group">
                    <label for="description_id">Deskripsi</label>
                    <textarea name="description[id]" class="form-control" id="description_id" rows="3" placeholder="Masukkan deskripsi (opsional)">{{ old('description.id', $facility->getTranslation('description', 'id', false)) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="icon">Pilih Ikon (Opsional)</label>
                    <select name="icon" class="form-control @error('icon') is-invalid @enderror" id="icon">
                        <option value="">-- Tanpa Ikon --</option>
                        <option value="building-2" {{ old('icon', $facility->icon) == 'building-2' ? 'selected' : '' }}>Gedung / Bangunan</option>
                        <option value="book-open" {{ old('icon', $facility->icon) == 'book-open' ? 'selected' : '' }}>Buku Terbuka</option>
                        <option value="book-marked" {{ old('icon', $facility->icon) == 'book-marked' ? 'selected' : '' }}>Buku Bertanda</option>
                        <option value="monitor" {{ old('icon', $facility->icon) == 'monitor' ? 'selected' : '' }}>Komputer / Monitor</option>
                        <option value="laptop" {{ old('icon', $facility->icon) == 'laptop' ? 'selected' : '' }}>Laptop / Komputer Portabel</option>
                        <option value="flask-conical" {{ old('icon', $facility->icon) == 'flask-conical' ? 'selected' : '' }}>Laboratorium / Flask</option>
                        <option value="trophy" {{ old('icon', $facility->icon) == 'trophy' ? 'selected' : '' }}>Piala / Penghargaan</option>
                        <option value="heart" {{ old('icon', $facility->icon) == 'heart' ? 'selected' : '' }}>Hati / Kesehatan</option>
                        <option value="globe" {{ old('icon', $facility->icon) == 'globe' ? 'selected' : '' }}>Bola Dunia / Jaringan</option>
                        <option value="graduation-cap" {{ old('icon', $facility->icon) == 'graduation-cap' ? 'selected' : '' }}>Topi Toga / Akademik</option>
                        <option value="users" {{ old('icon', $facility->icon) == 'users' ? 'selected' : '' }}>Pengguna / Komunitas</option>
                        <option value="activity" {{ old('icon', $facility->icon) == 'activity' ? 'selected' : '' }}>Aktivitas / Olahraga</option>
                    </select>
                    @error('icon')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar Fasilitas (Opsional)</label>
                    @if($facility->image_path)
                        <div class="mb-2">
                            <img src="{{ filter_var($facility->image_path, FILTER_VALIDATE_URL) ? $facility->image_path : Storage::url($facility->image_path) }}" alt="{{ $facility->title }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image" accept="image/*">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Fasilitas</button>
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
