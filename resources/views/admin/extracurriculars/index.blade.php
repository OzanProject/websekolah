@extends('adminlte::page')

@section('title', 'Ekstrakurikuler')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Ekstrakurikuler</h1>
        <div>
            <button type="button" class="btn btn-danger mr-2" id="btnDeleteSelected" style="display: none;">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
            <a href="{{ route('admin.extracurriculars.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 30px" class="text-center">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="width: 50px">No</th>
                            <th style="width: 100px">Gambar</th>
                            <th>Ikon</th>
                            <th>Nama Ekskul</th>
                            <th>Deskripsi</th>
                            <th style="width: 150px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($extracurriculars as $index => $item)
                            <tr id="row-{{ $item->id }}">
                                <td class="text-center">
                                    <input type="checkbox" class="checkItem" value="{{ $item->id }}">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->image_path)
                                        <img src="{{ filter_var($item->image_path, FILTER_VALIDATE_URL) ? $item->image_path : Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="img-thumbnail" style="max-height: 50px;">
                                    @else
                                        <span class="badge badge-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->icon)
                                        <span class="badge badge-info">{{ $item->icon }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ Str::limit($item->description, 50) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.extracurriculars.edit', $item->id) }}" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.extracurriculars.destroy', $item->id) }}" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Apakah Anda yakin ingin menghapus ekskul ini?">
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

            var table = $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [
                    { "orderable": false, "targets": [0, 2, 6] } 
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
            $('#dataTable tbody').on('change', '.checkItem', function() {
                if (!$(this).prop('checked')) {
                    $('#checkAll').prop('checked', false);
                }
                
                if ($('.checkItem:checked').length === $('.checkItem').length) {
                    $('#checkAll').prop('checked', true);
                }
                toggleDeleteButton();
            });

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
                        text: 'Anda akan menghapus ' + selectedIds.length + ' data yang dipilih. Tindakan ini tidak dapat dibatalkan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.extracurriculars.bulkDestroy') }}",
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
