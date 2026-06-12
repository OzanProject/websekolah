@extends('adminlte::page')

@section('title', 'Data Pendaftar PPDB')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-users mr-2"></i>Data Pendaftar PPDB</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Pendaftar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold">Daftar Calon Siswa Baru</h3>
                    <div class="card-tools d-flex align-items-center">
                        <button class="btn btn-sm btn-danger mr-3" id="btnDeleteSelected" style="display: none;">
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="ppdbTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="4%" class="text-center">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="15%">No. Pendaftaran</th>
                                    <th width="15%">Waktu Daftar</th>
                                    @foreach($featuredFields as $field)
                                        <th>{{ $field->label }}</th>
                                    @endforeach
                                    <th width="10%" class="text-center">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ppdbs as $ppdb)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="checkItem" value="{{ $ppdb->id }}">
                                        </td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td><strong>{{ $ppdb->nomor }}</strong></td>
                                        <td>{{ $ppdb->created_at->format('d/m/Y H:i') }}</td>
                                        
                                        @foreach($featuredFields as $field)
                                            <td>
                                                @php
                                                    $val = $ppdb->form_data[$field->name] ?? '-';
                                                    if (is_array($val)) {
                                                        $val = implode(', ', $val);
                                                    }
                                                @endphp
                                                {{ $val }}
                                            </td>
                                        @endforeach
                                        
                                        <td class="text-center">
                                            @if($ppdb->status == 'diterima')
                                                <span class="badge badge-success">Diterima</span>
                                            @elseif($ppdb->status == 'ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @else
                                                <span class="badge badge-warning">Menunggu</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.ppdb.show', $ppdb->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <form action="{{ route('admin.ppdb.destroy', $ppdb->id) }}" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Data pendaftar ini akan dihapus secara permanen beserta seluruh berkasnya!">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
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
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            var table = $('#ppdbTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "columnDefs": [
                    { "orderable": false, "targets": [0, -1] }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            // Handle Check All
            $('#checkAll').on('click', function() {
                var isChecked = $(this).prop('checked');
                $('.checkItem').prop('checked', isChecked);
                toggleDeleteButton();
            });

            // Handle Individual Checkbox
            $('#ppdbTable tbody').on('change', '.checkItem', function() {
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
                        text: 'Anda akan menghapus ' + selectedIds.length + ' data pendaftar. Berkas pendaftar juga akan dihapus. Tindakan ini tidak dapat dibatalkan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.ppdb.bulkDestroy') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: selectedIds
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Terhapus!',
                                            text: response.message,
                                            icon: 'success'
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

@section('css')
    <style>
        .table-responsive { overflow-x: auto; }
    </style>
@stop
