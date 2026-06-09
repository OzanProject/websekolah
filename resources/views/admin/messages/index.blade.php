@extends('adminlte::page')

@section('title', 'Pesan Kontak')

@section('content_header')
    <h1>Pesan Kontak</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pesan Masuk</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="messages-table">
                    <thead>
                        <tr>
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
            $('#messages-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@stop
