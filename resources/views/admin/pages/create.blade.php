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
            selector: '.tinymce',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak code media table',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code media table',
            height: 400,
            valid_elements: '*[*]',
            image_title: true,
            images_upload_url: '{{ route("admin.upload.tinymce") }}',
            automatic_uploads: true,
            file_picker_types: 'image media file',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                if (meta.filetype === 'image') {
                    input.setAttribute('accept', 'image/*');
                } else if (meta.filetype === 'media') {
                    input.setAttribute('accept', 'video/*,audio/*');
                } else {
                    input.setAttribute('accept', '*/*');
                }
                input.onchange = function () {
                    var file = this.files[0];
                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', '{{ csrf_token() }}');
                    fetch('{{ route("admin.upload.tinymce") }}', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => {
                        if (data.location) {
                            cb(data.location, { title: file.name });
                        } else {
                            alert(data.error || 'Upload failed');
                        }
                    })
                    .catch(error => { alert('Upload failed'); });
                };
                input.click();
            },
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
