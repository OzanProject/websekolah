@extends('adminlte::page')

@section('title', 'Pengaturan Umum')

@section('content_header')
    <h1>Pengaturan Umum</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Identitas Sekolah</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">


                        <div class="form-group">
                            <label for="school_name">Nama Sekolah</label>
                            <input type="text" class="form-control" id="school_name" name="school_name" value="{{ old('school_name', $profile->school_name) }}" placeholder="Contoh: SMP Negeri 4 Kadupandak">
                            <small class="text-muted">Akan ditampilkan sebagai judul utama website.</small>
                        </div>

                        <div class="form-group">
                            <label for="school_tagline">Tagline / Slogan</label>
                            <input type="text" class="form-control" id="school_tagline" name="school_tagline" value="{{ old('school_tagline', $profile->school_tagline) }}" placeholder="Contoh: Berkarakter, Berprestasi, Berakhlak Mulia">
                            <small class="text-muted">Akan ditampilkan di bawah nama sekolah pada header & footer.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="school_npsn">NPSN</label>
                                    <input type="text" class="form-control" id="school_npsn" name="school_npsn" value="{{ old('school_npsn', $profile->school_npsn) }}" placeholder="Contoh: 20227453">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="school_nss">NSS</label>
                                    <input type="text" class="form-control" id="school_nss" name="school_nss" value="{{ old('school_nss', $profile->school_nss) }}" placeholder="Contoh: 201020220018">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="school_accreditation">Akreditasi</label>
                                    <input type="text" class="form-control" id="school_accreditation" name="school_accreditation" value="{{ old('school_accreditation', $profile->school_accreditation) }}" placeholder="Contoh: B">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="school_logo">Logo Sekolah</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="school_logo" name="school_logo" accept="image/*">
                                    <label class="custom-file-label" for="school_logo">Pilih file...</label>
                                </div>
                            </div>
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. Disarankan berasio kotak 1:1.</small>
                        </div>
                        
                        @if($profile->school_logo)
                            <div class="mt-2">
                                <label>Logo Saat Ini:</label><br>
                                <img src="{{ asset('storage/' . $profile->school_logo) }}" alt="Logo Sekolah" class="img-thumbnail" style="max-height: 100px; background-color: #f4f6f9;">
                            </div>
                        @endif

                        <hr class="my-4">

                        <h4 class="mb-4"><i class="fas fa-edit mr-2"></i> Pengaturan Editor Teks</h4>
                        
                        <div class="form-group">
                            <label for="tinymce_api_key">TinyMCE API Key</label>
                            <input type="text" class="form-control" id="tinymce_api_key" name="tinymce_api_key" value="{{ old('tinymce_api_key', $profile->tinymce_api_key) }}" placeholder="Contoh: a1b2c3d4e5f6g7h8i9j0k...">
                            <small class="text-muted">Dapatkan API Key gratis di <a href="https://www.tiny.cloud/" target="_blank">tiny.cloud</a> untuk menghilangkan peringatan "This domain is not registered" pada teks editor.</small>
                        </div>

                        <hr class="my-5">
                        
                        <h4 class="mb-4"><i class="fas fa-images mr-2"></i> Pengaturan Hero Slider & Tombol Utama</h4>
                        
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5>Pengaturan Tombol Hero</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Teks Tombol 1 (Kiri)</label>
                                            <input type="text" class="form-control" name="hero_btn1_text" value="{{ old('hero_btn1_text', $profile->hero_btn1_text) }}" placeholder="Contoh: Daftar PPDB Online">
                                        </div>
                                        <div class="form-group">
                                            <label>URL Tombol 1</label>
                                            <input type="text" class="form-control" name="hero_btn1_url" value="{{ old('hero_btn1_url', $profile->hero_btn1_url) }}" placeholder="Contoh: /ppdb">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Teks Tombol 2 (Kanan)</label>
                                            <input type="text" class="form-control" name="hero_btn2_text" value="{{ old('hero_btn2_text', $profile->hero_btn2_text) }}" placeholder="Contoh: Profil Sekolah">
                                        </div>
                                        <div class="form-group">
                                            <label>URL Tombol 2</label>
                                            <input type="text" class="form-control" name="hero_btn2_url" value="{{ old('hero_btn2_url', $profile->hero_btn2_url) }}" placeholder="Contoh: /profil">
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Jika ingin menyembunyikan tombol, biarkan isian URL kosong.</small>
                            </div>
                        </div>
                        
                        @php
                            $slides = is_array($profile->hero_slides) && count($profile->hero_slides) > 0 
                                ? $profile->hero_slides 
                                : [];
                            if (empty($slides)) {
                                // Default empty slide if none exists
                                $slides[] = ['image' => '', 'tag' => '', 'title' => '', 'desc' => ''];
                            }
                        @endphp

                        <div id="slides-container">
                            @foreach($slides as $index => $slide)
                                <div class="slide-item border rounded p-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Slide <span class="slide-number">{{ $index + 1 }}</span></h5>
                                        <button type="button" class="btn btn-sm btn-danger btn-remove-slide" {{ count($slides) <= 1 ? 'style=display:none;' : '' }}>
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tag (Label Kecil)</label>
                                                <input type="text" class="form-control slide-tag" name="slides[{{ $index }}][tag]" value="{{ $slide['tag'] ?? '' }}" placeholder="Contoh: Selamat Datang">
                                            </div>
                                            <div class="form-group">
                                                <label>Judul (Title)</label>
                                                <input type="text" class="form-control slide-title" name="slides[{{ $index }}][title]" value="{{ $slide['title'] ?? '' }}" placeholder="Contoh: Sekolah Berprestasi">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gambar Slide</label>
                                                <input type="hidden" class="slide-old-image" name="slides[{{ $index }}][old_image]" value="{{ $slide['image'] ?? '' }}">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input slide-image" name="slides[{{ $index }}][image]" accept="image/*">
                                                        <label class="custom-file-label">Pilih gambar baru...</label>
                                                    </div>
                                                </div>
                                                @if(!empty($slide['image']))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $slide['image']) }}" alt="Slide Image" class="img-thumbnail" style="max-height: 80px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Singkat</label>
                                        <textarea class="form-control slide-desc" name="slides[{{ $index }}][desc]" rows="2" placeholder="Deskripsi slide...">{{ $slide['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-success btn-sm mt-2" id="btn-add-slide">
                            <i class="fas fa-plus"></i> Tambah Slide Baru
                        </button>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Informasi</h3>
                </div>
                <div class="card-body">
                    <p>Pengaturan ini akan berdampak langsung pada tampilan utama (Frontend) website Anda, khususnya pada bagian:</p>
                    <ul>
                        <li>Logo di Navbar Atas</li>
                        <li>Nama dan Tagline di Navbar & Footer</li>
                        <li>Informasi NPSN, NSS, dan Akreditasi di Footer</li>
                        <li>Judul Tab Browser (Title SEO)</li>
                    </ul>
                    <p class="mb-0 text-muted">Gunakan gambar logo dengan kualitas yang baik dengan background transparan (PNG) untuk hasil yang lebih memuaskan.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .custom-switch-lg .custom-control-label::before {
            left: -2.25rem;
            width: 3rem;
            height: 1.5rem;
            border-radius: 0.75rem;
        }
        .custom-switch-lg .custom-control-label::after {
            top: calc(0.25rem + 2px);
            left: calc(-2.25rem + 2px);
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            border-radius: 50%;
        }
        .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(1.5rem);
        }
        .custom-switch-lg .custom-control-label {
            padding-left: 1.5rem;
            padding-top: 0.2rem;
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>
@stop

@section('js')
    <script>
        // Update label custom-file dengan nama file yang dipilih
        $(document).on('change', '.custom-file-input', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        @if(session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if($errors->any())
            Swal.fire({
                title: 'Terdapat Kesalahan!',
                html: '<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                icon: 'error'
            });
        @endif

        // Slides Repeater Logic
        $(document).ready(function() {
            let slideIndex = $('.slide-item').length;

            function updateSlideNumbers() {
                $('.slide-item').each(function(index) {
                    $(this).find('.slide-number').text(index + 1);
                    // Update field names to match new index
                    $(this).find('.slide-tag').attr('name', `slides[${index}][tag]`);
                    $(this).find('.slide-title').attr('name', `slides[${index}][title]`);
                    $(this).find('.slide-desc').attr('name', `slides[${index}][desc]`);
                    $(this).find('.slide-image').attr('name', `slides[${index}][image]`);
                    $(this).find('.slide-old-image').attr('name', `slides[${index}][old_image]`);
                });
                
                // Show/hide remove buttons based on count
                if ($('.slide-item').length <= 1) {
                    $('.btn-remove-slide').hide();
                } else {
                    $('.btn-remove-slide').show();
                }
            }

            $('#btn-add-slide').click(function() {
                const template = `
                    <div class="slide-item border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Slide <span class="slide-number"></span></h5>
                            <button type="button" class="btn btn-sm btn-danger btn-remove-slide">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tag (Label Kecil)</label>
                                    <input type="text" class="form-control slide-tag" placeholder="Contoh: Selamat Datang">
                                </div>
                                <div class="form-group">
                                    <label>Judul (Title)</label>
                                    <input type="text" class="form-control slide-title" placeholder="Contoh: Sekolah Berprestasi">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gambar Slide</label>
                                    <input type="hidden" class="slide-old-image" value="">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input slide-image" accept="image/*">
                                            <label class="custom-file-label">Pilih gambar baru...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea class="form-control slide-desc" rows="2" placeholder="Deskripsi slide..."></textarea>
                        </div>
                    </div>
                `;
                
                $('#slides-container').append(template);
                slideIndex++;
                updateSlideNumbers();
            });

            $(document).on('click', '.btn-remove-slide', function() {
                if ($('.slide-item').length > 1) {
                    $(this).closest('.slide-item').remove();
                    updateSlideNumbers();
                }
            });
            
            // Initial call to set correct states
            updateSlideNumbers();
        });
    </script>
@stop
