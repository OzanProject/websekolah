@extends('adminlte::page')

@section('title', 'Berita')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Berita Sekolah</h1>
        <div>
            <button type="button" class="btn btn-danger mr-2" id="btnDeleteSelected" style="display: none;">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel"></i> Import Excel
            </button>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Berita
            </a>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="newsTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 30px" class="text-center">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="width: 50px">No</th>
                            <th style="width: 100px">Gambar</th>
                            <th>Judul Berita</th>
                            <th>Tanggal</th>
                            <th style="width: 150px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $index => $item)
                            <tr id="row-{{ $item->id }}">
                                <td class="text-center">
                                    <input type="checkbox" class="checkItem" value="{{ $item->id }}">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="img-thumbnail" style="max-height: 50px;">
                                    @else
                                        <span class="badge badge-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-sm btn-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Apakah Anda yakin ingin menghapus berita ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.news.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Import Data Berita</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Silakan unduh template Excel berikut, isi data Anda, lalu unggah kembali ke sini.</p>
                        <a href="{{ route('admin.news.template') }}" class="btn btn-outline-success mb-4">
                            <i class="fas fa-download"></i> Download Template Excel
                        </a>
                        
                        <div class="form-group">
                            <label for="file">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" class="form-control-file" id="file" required accept=".xlsx, .xls, .csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Mulai Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 4000,
                    showConfirmButton: false
                });
            @endif

            var table = $('#newsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "columnDefs": [
                    { "orderable": false, "targets": [0, 1, 5] } // Disable ordering on checkbox, image, and action columns
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });

            // Handle Check All
            $('#checkAll').on('click', function() {
                var isChecked = $(this).prop('checked');
                $('.checkItem').prop('checked', isChecked);
                toggleDeleteButton();
            });

            // Handle Individual Checkbox
            $('#newsTable tbody').on('change', '.checkItem', function() {
                if (!$(this).prop('checked')) {
                    $('#checkAll').prop('checked', false);
                }
                
                if ($('.checkItem:checked').length === $('.checkItem').length) {
                    $('#checkAll').prop('checked', true);
                }
                toggleDeleteButton();
            });

            // Handle pagination/search change to uncheck 'Check All'
            table.on('draw', function() {
                $('#checkAll').prop('checked', false);
                $('.checkItem').prop('checked', false);
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                if ($('.checkItem:checked').length > 0) {
                    $('#btnDeleteSelected').fadeIn();
                } else {
                    $('#btnDeleteSelected').fadeOut();
                }
            }

            // Handle Bulk Delete
            $('#btnDeleteSelected').on('click', function() {
                var selectedIds = [];
                $('.checkItem:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Anda akan menghapus ' + selectedIds.length + ' berita yang dipilih. Tindakan ini tidak dapat dibatalkan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.news.bulkDestroy') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: selectedIds
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: response.message,
                                            icon: "success",
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@stop
