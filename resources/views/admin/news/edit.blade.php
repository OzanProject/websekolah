@extends('adminlte::page')

@section('title', 'Edit Berita')

@section('content_header')
    <h1>Edit Berita</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title_id">Judul Berita</label>
                            <input type="text" name="title[id]" class="form-control @error('title.id') is-invalid @enderror" id="title_id" placeholder="Masukkan judul berita" value="{{ old('title.id', $news->getTranslation('title', 'id', false)) }}" required>
                            @error('title.id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date', $news->date) }}" required>
                    @error('date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar / Thumbnail (Opsional)</label>
                    @if($news->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($news->image) }}" alt="{{ $news->getTranslation('title', 'id', false) }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image" accept="image/*">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content_id">Konten Berita</label>
                    <textarea name="content[id]" class="form-control tinymce @error('content.id') is-invalid @enderror" id="content_id" rows="10" placeholder="Tulis isi berita di sini...">{{ old('content.id', $news->getTranslation('content', 'id', false)) }}</textarea>
                    @error('content.id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Berita</button>
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
