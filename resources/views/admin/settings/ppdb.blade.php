@extends('adminlte::page')

@section('title', 'Pengaturan PPDB & Form Builder')

@section('content_header')
    <h1>Pengaturan Formulir Pendaftaran PPDB</h1>
@stop

@section('content')
<!-- PPDB Active Settings -->
<div class="card card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">Pengaturan Umum PPDB</h3>
    </div>
    <form action="{{ route('admin.settings.ppdb.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">


            <div class="form-group">
                <div class="custom-control custom-switch custom-switch-lg">
                    <input type="checkbox" class="custom-control-input" id="ppdb_active" name="ppdb_active" value="1" {{ old('ppdb_active', $profile->ppdb_active) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="ppdb_active">Buka Pendaftaran PPDB</label>
                </div>
                <small class="text-muted d-block mt-1">Jika dimatikan, halaman form pendaftaran dan tombol menuju PPDB akan disembunyikan.</small>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="ppdb_title">Judul Formulir Pendaftaran</label>
                        <input type="text" class="form-control" id="ppdb_title" name="ppdb_title" value="{{ old('ppdb_title', $profile->ppdb_title) }}" placeholder="Contoh: Formulir Pendaftaran PPDB">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ppdb_year">Tahun Ajaran</label>
                        <input type="text" class="form-control" id="ppdb_year" name="ppdb_year" value="{{ old('ppdb_year', $profile->ppdb_year) }}" placeholder="Contoh: 2026/2027">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="ppdb_slug">URL PPDB (Slug)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ url('/') }}/</span>
                    </div>
                    <input type="text" class="form-control" id="ppdb_slug" name="ppdb_slug" value="{{ old('ppdb_slug', $profile->ppdb_slug) }}" placeholder="Contoh: pendaftaran-baru">
                </div>
                <small class="text-muted d-block mt-1">Jangan gunakan spasi atau karakter spesial. Hanya huruf, angka, dan tanda strip (-).</small>
            </div>

            <div class="form-group mb-0">
                <label for="ppdb_description">Deskripsi Tambahan / Pengumuman</label>
                <textarea class="form-control" id="ppdb_description" name="ppdb_description" rows="2" placeholder="Contoh: Silakan isi formulir dengan data yang valid...">{{ old('ppdb_description', $profile->ppdb_description) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Pengaturan Umum</button>
        </div>
    </form>
</div>

<!-- Form Builder -->
<div class="row">
    <div class="col-md-8">
        <!-- Sections & Fields -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
            <h4 class="font-weight-bold mb-3 mb-sm-0"><i class="fas fa-list-ol mr-2 text-primary"></i> Struktur Formulir</h4>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-success shadow-sm mr-2 mb-2" data-toggle="modal" data-target="#modalImportExcel">
                    <i class="fas fa-file-excel mr-1"></i> Import Excel
                </button>
                <button class="btn btn-primary shadow-sm mb-2" data-toggle="modal" data-target="#modalAddSection">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Bagian Baru
                </button>
            </div>
        </div>

        <div id="accordion-builder">
        @forelse($sections as $section)
            <div class="card card-outline card-primary shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center section-header" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseSection{{ $section->id }}">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-angle-down mr-3 text-muted transition-icon"></i>
                        <span class="badge badge-primary mr-2 shadow-sm">{{ $section->order_weight }}</span> {{ $section->name }}
                        @if(!$section->is_active) <span class="badge badge-secondary ml-2 py-1 px-2" style="font-size: 0.7rem;">Non-Aktif</span> @endif
                    </h3>
                    <div class="card-tools d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-primary mr-2 px-3 shadow-none border-0" data-toggle="modal" data-target="#modalAddField" data-section-id="{{ $section->id }}" data-section-name="{{ $section->name }}">
                            <i class="fas fa-plus-circle mr-1"></i> <span class="d-none d-sm-inline">Tambah Kolom</span>
                        </button>
                        <form action="{{ route('admin.form-builder.sections.duplicate', $section) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-info mr-1 border-0" title="Duplikat Bagian">
                                <i class="fas fa-copy"></i>
                            </button>
                        </form>
                        <button class="btn btn-sm btn-outline-warning mr-1 border-0" data-toggle="modal" data-target="#modalEditSection{{ $section->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.form-builder.sections.destroy', $section) }}" method="POST" class="d-inline form-delete">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-tool text-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div id="collapseSection{{ $section->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" data-parent="#accordion-builder">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40px" class="text-center">#</th>
                                <th>Label Kolom</th>
                                <th>Tipe</th>
                                <th>Wajib?</th>
                                <th style="width: 100px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($section->fields as $field)
                                <tr>
                                    <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="font-weight-500">{{ $field->label }}</span>
                                        <br><small class="text-muted">Key: <code>{{ $field->name }}</code></small>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ strtoupper($field->type) }}</span>
                                        @if($field->options)
                                            <div class="small text-muted mt-1">Opsi: {{ implode(', ', $field->options) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $field->is_required ? 'danger' : 'secondary' }}">
                                            {{ $field->is_required ? 'Wajib' : 'Opsional' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-link text-warning p-0 mr-1" 
                                                data-toggle="modal" 
                                                data-target="#modalEditField"
                                                data-id="{{ $field->id }}"
                                                data-label="{{ $field->label }}"
                                                data-help="{{ $field->help_text }}"
                                                data-type="{{ $field->type }}"
                                                data-required="{{ $field->is_required ? '1' : '0' }}"
                                                data-active="{{ $field->is_active ? '1' : '0' }}"
                                                data-featured="{{ $field->is_featured ? '1' : '0' }}"
                                                data-order="{{ $field->order_weight }}"
                                                data-options="{{ is_array($field->options) ? implode(', ', $field->options) : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.form-builder.fields.destroy', $field) }}" method="POST" class="d-inline form-delete">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted mt-2">
                                        <i class="fas fa-info-circle mr-1"></i> Belum ada kolom data di bagian ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>

            <!-- Modal Edit Section -->
            <div class="modal fade" id="modalEditSection{{ $section->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('admin.form-builder.sections.update', $section) }}" method="POST" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Edit Bagian Form</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Bagian</label>
                                <input type="text" name="name" class="form-control" value="{{ $section->name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="order_weight" class="form-control" value="{{ $section->order_weight }}" required>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="switchActive{{ $section->id }}" {{ $section->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="switchActive{{ $section->id }}">Aktifkan Bagian Ini</label>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-light text-center border-dashed py-5 shadow-sm">
                <i class="fas fa-layer-group fa-3x text-muted opacity-25 mb-3"></i>
                <h5 class="text-muted font-weight-bold">Belum ada struktur formulir.</h5>
                <p class="text-muted small">Silakan tambahkan bagian (section) pertama Anda untuk memulai.</p>
                <button class="btn btn-outline-primary btn-sm mt-3" data-toggle="modal" data-target="#modalAddSection">
                    <i class="fas fa-plus mr-1"></i> Mulai Membuat Form
                </button>
            </div>
        @endforelse
        </div>
    </div>

    <div class="col-md-4">
        <!-- Requirements -->
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-file-upload mr-2 text-success"></i> Syarat Dokumen</h3>
                <div class="card-tools">
                    <button class="btn btn-xs btn-success px-2" data-toggle="modal" data-target="#modalAddRequirement">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        @forelse($requirements as $req)
                            <tr>
                                <td class="pl-3 py-2">
                                    <span class="font-weight-bold d-block">{{ $req->name }}</span>
                                    <span class="badge badge-{{ $req->is_required ? 'danger' : 'secondary' }} small">
                                        {{ $req->is_required ? 'Wajib' : 'Opsional' }}
                                    </span>
                                </td>
                                 <td class="text-right pr-3 py-2 align-middle">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button class="btn btn-xs btn-link text-warning p-0 mr-2" data-toggle="modal" data-target="#modalEditRequirement{{ $req->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.form-builder.requirements.destroy', $req) }}" method="POST" class="form-delete">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-link text-danger p-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit Requirement -->
                                    <div class="modal fade text-left" id="modalEditRequirement{{ $req->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('admin.form-builder.requirements.update', $req) }}" method="POST" class="modal-content">
                                                @csrf @method('PUT')
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title font-weight-bold">Edit Syarat Dokumen</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Dokumen</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $req->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Urutan Tampil</label>
                                                        <input type="number" name="order_weight" class="form-control" value="{{ $req->order_weight }}" required>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_required" class="custom-control-input" id="edit_req_required{{ $req->id }}" value="1" {{ $req->is_required ? 'checked' : '' }}>
                                                        <label class="custom-control-label font-weight-normal" for="edit_req_required{{ $req->id }}">Wajib diunggah calon siswa</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light p-2">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning btn-sm px-3 shadow-sm">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center py-4 text-muted small italic">Belum ada syarat dokumen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert alert-info shadow-inner border-0 mt-4 small">
            <h6 class="font-weight-bold mb-2"><i class="fas fa-lightbulb mr-1"></i> Tips Form Builder</h6>
            <ul>
                <li><strong>Section</strong> digunakan untuk mengelompokkan data agar siswa tidak pusing melihat form panjang.</li>
                <li>Gunakan tipe data <strong>Select</strong> jika ingin membuat pilihan (pisahkan opsi dengan koma).</li>
                <li><strong>Syarat Dokumen</strong> akan muncul otomatis di halaman pendaftaran siswa sebagai upload field.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Modal Add Section -->
<div class="modal fade" id="modalAddSection" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.form-builder.sections.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Tambah Bagian Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Bagian</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Data Pribadi, Data Wali, dll" required>
                    <small class="text-muted font-italic">Bagian ini akan muncul sebagai Header di formulir siswa.</small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Bagian</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Add Field -->
<div class="modal fade" id="modalAddField" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.form-builder.fields.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="form_section_id" id="field_section_id">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Tambah Kolom Baru (<span id="field_section_name_display"></span>)</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Label Kolom</label>
                    <input type="text" name="label" class="form-control" placeholder="Contoh: Tempat Lahir, NIK Ayah" required>
                </div>
                <div class="form-group">
                    <label>Keterangan Tambahan / Deskripsi (Opsional)</label>
                    <textarea name="help_text" class="form-control" rows="2" placeholder="Contoh: Masukkan 16 digit NIK sesuai KTP/KK."></textarea>
                    <small class="text-muted">Muncul di bawah kolom input untuk membantu siswa.</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipe Input</label>
                            <select name="type" class="form-control" required id="field_type_select">
                                <option value="text">Teks Pendek</option>
                                <option value="number">Hanya Angka</option>
                                <option value="date">Tanggal</option>
                                <option value="select">Pilihan (Select)</option>
                                <option value="textarea">Paragraf Panjang</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column pt-3">
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" name="is_required" class="custom-control-input" id="field_required" value="1" checked>
                            <label class="custom-control-label" for="field_required">Wajib diisi?</label>
                        </div>
                        <div class="custom-control custom-checkbox text-primary">
                            <input type="checkbox" name="is_featured" class="custom-control-input" id="field_featured" value="1">
                            <label class="custom-control-label font-weight-bold" for="field_featured">Tampilkan di Tabel Utama</label>
                        </div>
                    </div>
                </div>
                <div class="form-group d-none" id="options_group">
                    <label>Opsi Pilihan (Pisahkan dengan koma)</label>
                    <input type="text" name="options" class="form-control" placeholder="Contoh: Pilihan A, Pilihan B, Pilihan C">
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Tambahkan Kolom</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Field -->
<div class="modal fade" id="modalEditField" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="formEditField" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold">Edit Kolom Data</h5>
                <button type="button" class="close text-dark" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Label Kolom</label>
                    <input type="text" name="label" id="edit_field_label" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Keterangan Tambahan / Deskripsi (Opsional)</label>
                    <textarea name="help_text" id="edit_field_help" class="form-control" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipe Input</label>
                            <select name="type" id="edit_field_type" class="form-control" required>
                                <option value="text">Teks Pendek</option>
                                <option value="number">Hanya Angka</option>
                                <option value="date">Tanggal</option>
                                <option value="select">Pilihan (Select)</option>
                                <option value="textarea">Paragraf Panjang</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urutan Tampil</label>
                            <input type="number" name="order_weight" id="edit_field_order" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group d-none" id="edit_options_group">
                    <label>Opsi Pilihan (Pisahkan dengan koma)</label>
                    <input type="text" name="options" id="edit_field_options" class="form-control">
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="is_required" class="custom-control-input" id="edit_field_required" value="1">
                            <label class="custom-control-label font-weight-normal" for="edit_field_required">Wajib diisi?</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="edit_field_active" value="1">
                            <label class="custom-control-label font-weight-normal" for="edit_field_active">Status Aktif</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="custom-control custom-checkbox text-primary">
                            <input type="checkbox" name="is_featured" class="custom-control-input" id="edit_field_featured" value="1">
                            <label class="custom-control-label font-weight-bold" for="edit_field_featured">Tampilkan di Tabel Utama</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm">Perbarui Kolom</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Add Requirement -->
<div class="modal fade" id="modalAddRequirement" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.form-builder.requirements.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold">Tambah Syarat Dokumen</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Dokumen</label>
                    <textarea name="name" class="form-control" rows="3" placeholder="Gunakan koma (,) untuk menambahkan banyak sekaligus. Contoh: Ijazah, Akta Kelahiran, KK" required></textarea>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="is_required" class="custom-control-input" id="req_required" value="1" checked>
                    <label class="custom-control-label font-weight-normal" for="req_required">Wajib diunggah calon siswa</label>
                </div>
            </div>
            <div class="modal-footer bg-light p-2">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success btn-sm px-3 shadow-sm">Tambahkan Syarat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.form-builder.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-excel mr-2"></i> Import Struktur Form</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-weight-bold mb-0"><i class="fas fa-info-circle mr-1"></i> Petunjuk Format Excel:</h6>
                        <a href="{{ route('admin.form-builder.template') }}" class="btn btn-xs btn-primary px-3 shadow-none">
                            <i class="fas fa-download mr-1"></i> Download Template
                        </a>
                    </div>
                    <p class="small mb-2">Pastikan file Excel Anda memiliki header pada baris pertama dengan nama kolom berikut:</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered bg-white small mb-0">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>bagian</th>
                                    <th>label_kolom</th>
                                    <th>keterangan</th>
                                    <th>tipe</th>
                                    <th>wajib</th>
                                    <th>opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nama Section</td>
                                    <td>Label Input</td>
                                    <td>Help Text</td>
                                    <td>text/number/date/select/textarea</td>
                                    <td>Y / N</td>
                                    <td>Pilihan A, Pilihan B (Jika tipe select)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label>Pilih File Excel (.xlsx, .xls, .csv)</label>
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="excelFile" required>
                        <label class="custom-file-label" for="excelFile">Pilih file...</label>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-exclamation-triangle mr-1 text-warning"></i> 
                        <strong>Penting:</strong> Impor akan <u>menambah</u> struktur baru tanpa menghapus data formulir yang sudah ada.
                    </small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success px-4">Proses Impor</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(function() {
        // Modal logic for adding fields
        $('#modalAddField').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var sectionId = button.data('section-id');
            var sectionName = button.data('section-name');
            
            var modal = $(this);
            modal.find('#field_section_id').val(sectionId);
            modal.find('#field_section_name_display').text(sectionName);
        });

        // Toggle options field based on type
        $('#field_type_select').on('change', function() {
            if ($(this).val() === 'select') {
                $('#options_group').removeClass('d-none');
            } else {
                $('#options_group').addClass('d-none');
            }
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

        // File input label update
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Modal logic for editing fields
        $('#modalEditField').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var label = button.data('label');
            var help = button.data('help');
            var type = button.data('type');
            var required = button.data('required');
            var active = button.data('active');
            var featured = button.data('featured');
            var order = button.data('order');
            var options = button.data('options');
            
            var modal = $(this);
            var formAction = "{{ route('admin.form-builder.fields.update', ':id') }}";
            modal.find('#formEditField').attr('action', formAction.replace(':id', id));
            
            modal.find('#edit_field_label').val(label);
            modal.find('#edit_field_help').val(help);
            modal.find('#edit_field_type').val(type);
            modal.find('#edit_field_order').val(order);
            modal.find('#edit_field_options').val(options);
            
            if (required == '1') {
                modal.find('#edit_field_required').prop('checked', true);
            } else {
                modal.find('#edit_field_required').prop('checked', false);
            }
            
            if (active == '1') {
                modal.find('#edit_field_active').prop('checked', true);
            } else {
                modal.find('#edit_field_active').prop('checked', false);
            }

            if (featured == '1') {
                modal.find('#edit_field_featured').prop('checked', true);
            } else {
                modal.find('#edit_field_featured').prop('checked', false);
            }

            if (type === 'select') {
                $('#edit_options_group').removeClass('d-none');
            } else {
                $('#edit_options_group').addClass('d-none');
            }
        });

        $('#edit_field_type').on('change', function() {
            if ($(this).val() === 'select') {
                $('#edit_options_group').removeClass('d-none');
            } else {
                $('#edit_options_group').addClass('d-none');
            }
        });

        $(document).on('click', '.btn-delete-section, .btn-delete-field, .btn-delete-requirement', function(e) {
            e.preventDefault();
            let formId = $(this).data('form-id');
            
            Swal.fire({
              title: "Apakah Anda yakin?",
              text: "Data ini akan dihapus secara permanen!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Ya, Hapus!",
              cancelButtonText: "Batal"
            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire({
                  title: "Dihapus!",
                  text: "Data berhasil dihapus.",
                  icon: "success",
                  showConfirmButton: false,
                  timer: 1500
                });
                setTimeout(() => { $('#' + formId).submit(); }, 600);
              }
            });
        });
    });
</script>
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

    .border-dashed { border: 2px dashed #dee2e6 !important; }
    .font-weight-500 { font-weight: 500; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
    .badge-light { background-color: #f8f9fa; color: #333; }
    .section-header:hover { background-color: #fcfcfc !important; }
    .transition-icon { transition: transform .3s ease; }
    .collapsed .transition-icon { transform: rotate(-90deg); }
    .card-tools .btn { transition: all 0.2s; }
    .card-tools .btn:hover { transform: translateY(-1px); }
</style>
@stop
