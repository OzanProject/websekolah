@extends('adminlte::page')

@section('title', 'Detail Pendaftar PPDB')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-user-circle mr-2"></i>Detail Pendaftar: {{ $ppdb->nomor }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.ppdb.index') }}">Data Pendaftar</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible shadow-sm">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <!-- Kolom Data Formulir -->
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold">Data Formulir Pendaftaran</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 30%">No. Pendaftaran</th>
                                <td><span class="badge badge-primary">{{ $ppdb->nomor }}</span></td>
                            </tr>
                            <tr>
                                <th>Waktu Pendaftaran</th>
                                <td>{{ $ppdb->created_at->format('d F Y, H:i:s') }} WIB</td>
                            </tr>
                            
                            {{-- Tampilkan Data Dinamis JSON --}}
                            @php
                                // Kita ambil form_sections yang aktif beserta fieldsnya untuk diurutkan sesuai dengan yang ada di builder
                                $sections = \App\Models\FormSection::with(['fields' => function($q) {
                                    $q->orderBy('order_weight');
                                }])->orderBy('order_weight')->get();
                            @endphp

                            @if($sections->isNotEmpty())
                                @foreach($sections as $section)
                                    <tr class="bg-light">
                                        <td colspan="2"><h6 class="font-weight-bold m-0 text-primary mt-2">{{ $section->name }}</h6></td>
                                    </tr>
                                    @foreach($section->fields as $field)
                                        <tr>
                                            <th>{{ $field->label }}</th>
                                            <td>
                                                @php
                                                    $val = $ppdb->form_data[$field->name] ?? '-';
                                                    if (is_array($val)) {
                                                        $val = implode(', ', $val);
                                                    }
                                                @endphp
                                                {{ $val ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                {{-- Fallback jika builder kosong tapi JSON ada (Meskipun jarang terjadi) --}}
                                @if(is_array($ppdb->form_data))
                                    @foreach($ppdb->form_data as $key => $value)
                                        <tr>
                                            <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                            <td>{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-right">
                    <a href="{{ route('admin.ppdb.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <button type="button" onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print mr-1"></i> Cetak</button>
                </div>
            </div>
        </div>

        <!-- Kolom Syarat Dokumen & Aksi -->
        <div class="col-md-4">
            
            <!-- Form Status Kelulusan -->
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold">Status Kelulusan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ppdb.status.update', $ppdb->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="status">Pilih Status</label>
                            <select name="status" id="statusSelect" class="form-control">
                                <option value="menunggu" {{ $ppdb->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diterima" {{ $ppdb->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $ppdb->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="pesanStatusGroup" style="{{ $ppdb->status == 'ditolak' ? 'display:block;' : 'display:none;' }}">
                            <label for="pesan_status">Alasan Penolakan / Catatan Khusus</label>
                            <textarea name="pesan_status" id="pesan_status" class="form-control" rows="3" placeholder="Masukkan alasan kenapa ditolak...">{{ $ppdb->pesan_status }}</textarea>
                            <small class="text-muted">Pesan ini akan terlihat oleh pendaftar saat mengecek status.</small>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan Status</button>
                    </form>
                </div>
            </div>

            <div class="card card-outline card-success shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold">Berkas Unggahan</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @if(is_array($ppdb->requirements_data) && count($ppdb->requirements_data) > 0)
                            @foreach($ppdb->requirements_data as $reqId => $reqData)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-alt text-muted mr-2"></i>
                                        <strong>{{ $reqData['name'] ?? 'Berkas' }}</strong>
                                    </div>
                                    @if(isset($reqData['file']) && \Storage::disk('public')->exists($reqData['file']))
                                        <div class="btn-group">
                                            @php
                                                $fileUrl = Storage::url($reqData['file']);
                                                $ext = strtolower(pathinfo($reqData['file'], PATHINFO_EXTENSION));
                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                                $isPdf = $ext === 'pdf';
                                            @endphp
                                            <button type="button" class="btn btn-sm btn-outline-info px-2" onclick="showPreview('{{ $fileUrl }}', '{{ $isImage ? 'image' : ($isPdf ? 'pdf' : 'other') }}', '{{ $reqData['name'] ?? 'Berkas' }}')">
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>
                                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary px-2">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        </div>
                                    @else
                                        <span class="badge badge-warning">File Hilang</span>
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                Tidak ada berkas yang diunggah.
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div class="card card-outline card-danger shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold text-danger">Aksi Bahaya</h3>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Tindakan ini akan menghapus data pendaftar ini beserta seluruh berkas yang telah diunggahnya dari server.</p>
                    <form action="{{ route('admin.ppdb.destroy', $ppdb->id) }}" method="POST" class="swal-delete-form" data-confirm-msg="Apakah Anda yakin ingin menghapus permanen data ini?">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block font-weight-bold"><i class="fas fa-trash-alt mr-2"></i> Hapus Data Pendaftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pratinjau Berkas -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="previewModalLabel"><i class="fas fa-search mr-2"></i> Pratinjau Berkas</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-0" style="background: #f4f6f9; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    <div id="previewContent" class="w-100 h-100" style="min-height: 400px;">
                        <!-- Content injected via JS -->
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <a href="#" id="previewDownloadBtn" target="_blank" class="btn btn-primary"><i class="fas fa-download mr-1"></i> Unduh Asli</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPreview(url, type, name) {
            $('#previewModalLabel').html('<i class="fas fa-search mr-2"></i> Pratinjau: ' + name);
            $('#previewDownloadBtn').attr('href', url);
            
            let content = '';
            if (type === 'image') {
                content = `<img src="${url}" class="img-fluid" style="max-height: 70vh; object-fit: contain;" alt="${name}">`;
            } else if (type === 'pdf') {
                content = `<iframe src="${url}" width="100%" height="600px" style="border: none;"></iframe>`;
            } else {
                content = `<div class="p-5 text-center text-muted">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i>
                    <p>Format file ini tidak dapat dipratinjau langsung.<br>Silakan unduh file untuk melihatnya.</p>
                </div>`;
            }
            
            $('#previewContent').html(content);
            $('#previewModal').modal('show');
        }

        $(document).ready(function() {
            $('#statusSelect').change(function() {
                if($(this).val() == 'ditolak') {
                    $('#pesanStatusGroup').slideDown();
                } else {
                    $('#pesanStatusGroup').slideUp();
                }
            });
        });
    </script>
@stop

@section('css')
    <style>
        @media print {
            body { font-size: 12pt; }
            .main-footer, .main-header, .sidebar, .card-footer, .btn, .breadcrumb, .card-danger { display: none !important; }
            .card { border: none !important; box-shadow: none !important; }
            .col-md-8 { flex: 0 0 100%; max-width: 100%; }
            .col-md-4 { flex: 0 0 100%; max-width: 100%; margin-top: 20px; }
            a[href]:after { content: none !important; }
        }
    </style>
@stop
