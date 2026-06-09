@extends('adminlte::page')

@section('title', 'Tambah Halaman Baru')

@section('content_header')
    <h1>Tambah Halaman Baru</h1>
@stop

@section('content')
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Halaman Kustom</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="title">Judul Halaman <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Sejarah Sekolah">
                    <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                        <strong>Permalink:</strong> <a href="#" id="permalink-preview" class="text-primary">{{ url('halaman') }}/<span id="slug-preview" class="font-italic">...</span></a>
                    </p>
                </div>

                <div class="form-group">
                    <label for="content">Isi Konten (Teks, Gambar, Tabel) <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Aktifkan Halaman Ini (Bisa diakses publik)</label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-default mr-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Halaman</button>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table emoticons template help',
            toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | table | forecolor backcolor emoticons | code preview fullscreen',
            menubar: 'file edit view insert format tools table help',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
        });

        $(document).ready(function() {
            $('#title').on('keyup', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');
                if(slug) {
                    $('#slug-preview').text(slug);
                } else {
                    $('#slug-preview').text('...');
                }
            });
        });
    </script>
@stop
