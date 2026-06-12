@extends('adminlte::page')

@section('title', 'Edit Ekstrakurikuler')

@section('content_header')
    <h1>Edit Ekstrakurikuler</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Edit Ekstrakurikuler</h3>
        </div>
        <form action="{{ route('admin.extracurriculars.update', $extracurricular->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name[id]">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                            <input type="text" name="name[id]" class="form-control @error('name.id') is-invalid @enderror" id="name[id]" value="{{ old('name.id', $extracurricular->getTranslation('name', 'id')) }}" required>
                            @error('name.id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description[id]">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description[id]" class="form-control @error('description.id') is-invalid @enderror" id="description[id]" rows="4" required>{{ old('description.id', $extracurricular->getTranslation('description', 'id')) }}</textarea>
                            @error('description.id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="icon">Ikon (Lucide)</label>
                            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" id="icon" value="{{ old('icon', $extracurricular->icon) }}">
                            <small class="form-text text-muted">Cari nama ikon di <a href="https://lucide.dev/icons" target="_blank">lucide.dev</a></small>
                            @error('icon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Ganti Foto Dokumentasi</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Pilih file baru (opsional)</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal: 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                            @error('image')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <p class="mb-1 text-sm font-weight-bold">Preview Foto Saat Ini:</p>
                            @if($extracurricular->image_path)
                                <img id="imagePreview" src="{{ filter_var($extracurricular->image_path, FILTER_VALIDATE_URL) ? $extracurricular->image_path : Storage::url($extracurricular->image_path) }}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            @else
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" style="display:none; max-height: 200px;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.extracurriculars.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            // Menampilkan nama file dan image preview
            $("#image").change(function() {
                // Menampilkan nama file di label
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
                
                // Menampilkan preview gambar
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@stop
