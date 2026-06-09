@extends('adminlte::page')

@section('title', 'Tambah Berita')

@section('content_header')
    <h1>Tambah Berita</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title_id">Judul Berita</label>
                            <input type="text" name="title[id]" class="form-control @error('title.id') is-invalid @enderror" id="title_id" value="{{ old('title.id') }}" placeholder="Masukkan judul berita" required>
                            @error('title.id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar / Thumbnail (Opsional)</label>
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image" accept="image/*">
                    <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG, GIF. Maks: 2MB.</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content_id">Konten Berita</label>
                    <textarea name="content[id]" class="form-control tinymce @error('content.id') is-invalid @enderror" id="content_id" rows="10" placeholder="Tulis isi berita di sini...">{{ old('content.id') }}</textarea>
                    @error('content.id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Berita</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        tinymce.init({
            selector: '.tinymce',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            height: 400,
        });
    </script>
@stop
