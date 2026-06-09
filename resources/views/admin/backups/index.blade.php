@extends('adminlte::page')

@section('title', 'Backup & Restore Database')

@section('content_header')
    <h1>Backup & Restore Database</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Panel Daftar Backup -->
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-database mr-1"></i> Daftar File Backup (SQL)</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.backups.create') }}" method="POST" id="form-backup">
                            @csrf
                            <button type="button" class="btn btn-primary btn-sm" onclick="confirmBackup()">
                                <i class="fas fa-plus"></i> Buat Backup Baru
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th>Tanggal Pembuatan</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $backup)
                                    <tr>
                                        <td><code>{{ $backup['filename'] }}</code></td>
                                        <td>{{ $backup['size'] }}</td>
                                        <td>{{ $backup['date'] }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.backups.download', $backup['filename']) }}" class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            
                                            <!-- Restore Button -->
                                            <button type="button" class="btn btn-sm btn-warning" title="Restore" onclick="confirmRestore('{{ $backup['filename'] }}')">
                                                <i class="fas fa-sync-alt"></i> Restore
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('{{ $backup['filename'] }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Delete Form -->
                                            <form id="delete-form-{{ $backup['filename'] }}" action="{{ route('admin.backups.destroy', $backup['filename']) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada file backup database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Restore Upload -->
        <div class="col-md-4">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-upload mr-1"></i> Upload SQL & Restore</h3>
                </div>
                <form action="{{ route('admin.backups.restore') }}" method="POST" enctype="multipart/form-data" id="form-upload-restore">
                    @csrf
                    <div class="card-body">
                        <div class="callout callout-warning">
                            <p class="text-sm">Anda dapat melakukan restore dari file .sql eksternal. <b>Peringatan:</b> Aksi ini akan menimpa (overwrite) seluruh database saat ini!</p>
                        </div>
                        <div class="form-group">
                            <label for="backup_file">Pilih File (.sql)</label>
                            <input type="file" class="form-control-file" id="backup_file" name="backup_file" accept=".sql" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-warning btn-block" onclick="confirmUploadRestore()"><i class="fas fa-exclamation-triangle"></i> Upload & Restore Database</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Restore Form -->
    <form id="restore-form" action="{{ route('admin.backups.restore') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="filename" id="restore-filename">
    </form>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmBackup() {
            Swal.fire({
                title: 'Buat Backup Database?',
                text: "Proses ini mungkin memerlukan waktu beberapa saat tergantung ukuran database.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Buat Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Memproses...',
                        html: 'Mohon tunggu, sedang men-generate file SQL.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById('form-backup').submit();
                }
            })
        }

        function confirmRestore(filename) {
            Swal.fire({
                title: 'PERINGATAN KRITIKAL!',
                html: "Anda akan me-restore database dari file: <br><code>" + filename + "</code><br><br><b>Semua data Anda saat ini akan ditimpa!</b> Pastikan Anda yakin sebelum melanjutkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, RESTORE SEKARANG!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('restore-filename').value = filename;
                    Swal.fire({
                        title: 'Sedang Merestore...',
                        html: 'Jangan tutup halaman ini. Menimpa database membutuhkan waktu.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById('restore-form').submit();
                }
            })
        }

        function confirmUploadRestore() {
            var fileInput = document.getElementById('backup_file');
            if (fileInput.files.length === 0) {
                Swal.fire('Error', 'Pilih file .sql terlebih dahulu!', 'error');
                return;
            }

            Swal.fire({
                title: 'PERINGATAN KRITIKAL!',
                text: "Anda akan me-restore database dari file yang diupload. Seluruh data Anda saat ini akan dihapus dan diganti! Yakin melanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, UPLOAD & RESTORE!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Upload & Restore...',
                        html: 'Jangan tutup halaman ini. Proses ini mungkin memakan waktu agak lama.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById('form-upload-restore').submit();
                }
            })
        }

        function confirmDelete(filename) {
            Swal.fire({
                title: 'Hapus file backup?',
                text: "File " + filename + " akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + filename).submit();
                }
            })
        }
    </script>
@stop
