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
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak code media table',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code media table',
            height: 400,
            valid_elements: '*[*]',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function(resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '/admin/upload/tinymce');
                    xhr.setRequestHeader("X-CSRF-Token", '{{ csrf_token() }}');
                    
                    xhr.onload = function() {
                        if (xhr.status === 403 || xhr.status === 419) {
                            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                            return;
                        }
                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }
                        var json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        resolve(json.location);
                    };
                    xhr.onerror = function () {
                        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };
                    var formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            },
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
                    fetch('/admin/upload/tinymce', { method: 'POST', body: formData })
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
    </script>
@stop
