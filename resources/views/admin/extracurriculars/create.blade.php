@extends('adminlte::page')

@section('title', 'Tambah Ekstrakurikuler')

@section('content_header')
    <h1>Tambah Ekstrakurikuler</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Ekstrakurikuler</h3>
        </div>
        <form action="{{ route('admin.extracurriculars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name[id]">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                            <input type="text" name="name[id]" class="form-control @error('name.id') is-invalid @enderror" id="name[id]" placeholder="Masukkan nama ekskul (misal: Pramuka)" value="{{ old('name.id') }}" required>
                            @error('name.id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description[id]">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description[id]" class="form-control @error('description.id') is-invalid @enderror" id="description[id]" rows="4" placeholder="Masukkan deskripsi singkat ekskul" required>{{ old('description.id') }}</textarea>
                            @error('description.id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="icon">Ikon (Lucide)</label>
                            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" id="icon" placeholder="Contoh: tent, activity, music" value="{{ old('icon') }}">
                            <small class="form-text text-muted">Cari nama ikon di <a href="https://lucide.dev/icons" target="_blank">lucide.dev</a></small>
                            @error('icon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Foto Dokumentasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*" required>
                                    <label class="custom-file-label" for="image">Pilih file</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal: 2MB.</small>
                            @error('image')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" style="display:none; max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.extracurriculars.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
            
            // Image Preview
            $("#image").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    $('#imagePreview').hide();
                }
            });
        });
    </script>
@stop
