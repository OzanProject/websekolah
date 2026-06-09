@extends('adminlte::page')

@section('title', 'Pesan Kontak')

@section('content_header')
    <h1>Pesan Kontak</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Pesan Masuk</h3>
            <div>
                <button class="btn btn-sm btn-danger" id="btnDeleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Hapus Terpilih
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="messages-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="25%">Subjek</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="{{ !$message->is_read ? 'font-weight-bold bg-light' : '' }}">
                                <td class="text-center">
                                    <input type="checkbox" class="checkItem" value="{{ $message->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $message->name }}
                                    @if(!$message->is_read)
                                        <span class="badge badge-danger ml-1">Baru</span>
                                    @endif
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->subject ?: '-' }}</td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Baca
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Yakin ingin menghapus pesan ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
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
    <script>
        $(document).ready(function() {
            var table = $('#messages-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, 6] }
                ]
            });

            // Handle Check All
            $('#checkAll').on('click', function() {
                var isChecked = $(this).prop('checked');
                $('.checkItem').prop('checked', isChecked);
                toggleDeleteButton();
            });

            // Handle Individual Checkbox
            $('#messages-table tbody').on('change', '.checkItem', function() {
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
                        text: 'Anda akan menghapus ' + selectedIds.length + ' pesan yang dipilih. Tindakan ini tidak dapat dibatalkan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.messages.bulkDestroy') }}",
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
                                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus pesan.', 'error');
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@stop
