@extends('adminlte::page')

@section('title', 'Profil Sekolah')

@section('content_header')
    <h1>Profil Sekolah (Visi, Misi, & Statistik)</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profiles.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom Kiri: Visi Misi & Sambutan -->
            <div class="col-md-7">
                <!-- Sambutan Kepala Sekolah -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Sambutan Kepala Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kepsek_name">Nama Kepala Sekolah</label>
                            <input type="text" name="kepsek_name" id="kepsek_name" class="form-control" value="{{ old('kepsek_name', $profile->kepsek_name) }}" placeholder="Contoh: Drs. H. Asep Mulyana, M.Pd">
                        </div>

                        <div class="form-group">
                            <label for="kepsek_image">Foto Kepala Sekolah (Opsional)</label>
                            @if($profile->kepsek_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $profile->kepsek_image) }}" alt="Foto Kepsek" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="kepsek_image" id="kepsek_image" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="sambutan_content_id">Isi Sambutan</label>
                            <textarea name="sambutan_content[id]" id="sambutan_content_id" class="form-control tinymce" rows="5" placeholder="Tuliskan pesan sambutan di sini...">{{ old('sambutan_content.id', $profile->getTranslation('sambutan_content', 'id', false)) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Visi Misi -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Visi & Misi</h3>
                    </div>
                    <div class="card-body">
                        <!-- Visi ID -->
                        <div class="form-group">
                            <label for="visi_id">Visi Sekolah</label>
                            <textarea name="visi[id]" id="visi_id" class="form-control" rows="3" required>{{ old('visi.id', $profile->getTranslation('visi', 'id', false)) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Misi Sekolah</label>
                            <div id="misi-container-id">
                                @php
                                    $misiListId = old('misi.id', $profile->getTranslation('misi', 'id', false) ?: []);
                                    if(empty($misiListId)) $misiListId = [''];
                                @endphp
                                @foreach($misiListId as $index => $misi)
                                    <div class="input-group mb-2 misi-row">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-bullseye text-warning"></i></span></div>
                                        <input type="text" name="misi[id][]" class="form-control" value="{{ $misi }}" placeholder="Tuliskan misi...">
                                        <div class="input-group-append"><button type="button" class="btn btn-danger btn-remove-misi"><i class="fas fa-times"></i></button></div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addMisi('id')"><i class="fas fa-plus"></i> Tambah Poin Misi</button>
                        </div>
                    </div>
                </div>

                <!-- End Kolom Kiri -->
            </div>

            <!-- Kolom Kanan: Statistik & Kontak -->
            <div class="col-md-5">
                <!-- Statistik Pencapaian -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Pencapaian</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="stat_student">Jumlah Siswa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                </div>
                                <input type="number" min="0" name="stat_student" id="stat_student" class="form-control" value="{{ old('stat_student', $profile->stat_student) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stat_teacher">Jumlah Guru & Staf</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                </div>
                                <input type="number" min="0" name="stat_teacher" id="stat_teacher" class="form-control" value="{{ old('stat_teacher', $profile->stat_teacher) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stat_class">Rombongan Belajar (Kelas)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book-open"></i></span>
                                </div>
                                <input type="number" min="0" name="stat_class" id="stat_class" class="form-control" value="{{ old('stat_class', $profile->stat_class) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stat_achievement">Prestasi Diraih</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-award"></i></span>
                                </div>
                                <input type="number" min="0" name="stat_achievement" id="stat_achievement" class="form-control" value="{{ old('stat_achievement', $profile->stat_achievement) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Kontak & Sosial Media</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="contact_address">Alamat Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
                                <input type="text" name="contact_address" id="contact_address" class="form-control" value="{{ old('contact_address', $profile->contact_address) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_phone">Telepon</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $profile->contact_phone) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_email">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $profile->contact_email) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_hours">Jam Operasional</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                                <input type="text" name="contact_hours" id="contact_hours" class="form-control" value="{{ old('contact_hours', $profile->contact_hours) }}" placeholder="Senin - Jumat: 07.00 - 15.00 WIB">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_map">Link Google Maps (Embed URL)</label>
                            
                            @if($profile->contact_map)
                                <div class="mb-3 rounded overflow-hidden border border-slate-200" style="max-width: 100%; height: 200px;" id="map_preview_container">
                                    <iframe id="map_preview" src="{{ $profile->contact_map }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                </div>
                            @endif

                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map"></i></span></div>
                                <input type="text" name="contact_map" id="contact_map" class="form-control" value="{{ old('contact_map', $profile->contact_map) }}" placeholder="https://www.google.com/maps/embed?pb=...">
                            </div>
                            <small class="form-text text-muted">Buka Google Maps > Share > Embed a map > Copy *hanya* bagian <code>src="..."</code> linknya saja.</small>
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <label for="social_facebook">Link Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook-f"></i></span></div>
                                <input type="url" name="social_facebook" id="social_facebook" class="form-control" value="{{ old('social_facebook', $profile->social_facebook) }}" placeholder="https://facebook.com/...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="social_instagram">Link Instagram</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                <input type="url" name="social_instagram" id="social_instagram" class="form-control" value="{{ old('social_instagram', $profile->social_instagram) }}" placeholder="https://instagram.com/...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="social_youtube">Link YouTube</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-youtube"></i></span></div>
                                <input type="url" name="social_youtube" id="social_youtube" class="form-control" value="{{ old('social_youtube', $profile->social_youtube) }}" placeholder="https://youtube.com/...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Semua Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // TinyMCE initialization for sambutan
            tinymce.init({
                selector: '.tinymce',
                height: 300,
                plugins: 'advlist autolink lists link charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
            });

            // Fungsi Tambah Misi diubah menjadi fungsi global
            window.addMisi = function(locale) {
                var html = `
                    <div class="input-group mb-2 misi-row">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bullseye text-warning"></i></span>
                        </div>
                        <input type="text" name="misi[${locale}][]" class="form-control" placeholder="Tuliskan misi...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-remove-misi"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
                $('#misi-container-' + locale).append(html);
            };

            // Fungsi Hapus Misi
            $(document).on('click', '.btn-remove-misi', function() {
                if ($('.misi-row').length > 1) {
                    $(this).closest('.misi-row').remove();
                } else {
                    alert('Harus ada minimal 1 poin misi!');
                }
            });

            // Live Preview untuk Google Maps Embed
            $('#contact_map').on('input', function() {
                var url = $(this).val();
                if(url) {
                    if($('#map_preview').length === 0) {
                        var iframeHtml = `
                        <div class="mb-3 rounded overflow-hidden border border-slate-200" style="max-width: 100%; height: 200px;" id="map_preview_container">
                            <iframe id="map_preview" src="" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>`;
                        $(this).closest('.input-group').before(iframeHtml);
                    }
                    $('#map_preview').attr('src', url);
                } else {
                    $('#map_preview_container').remove();
                }
            });
        });
    </script>
@stop
