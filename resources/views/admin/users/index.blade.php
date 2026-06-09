@extends('adminlte::page')

@section('title', 'Manajemen Admin')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Administrator Sistem</h1>
        <div>
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel"></i> Import Excel
            </button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Admin
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
            <table id="usersTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Terdaftar</th>
                        <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&background=random&size=30" class="img-circle mr-2" alt="Avatar">
                                <strong>{{ $item->name }}</strong>
                                @if(auth()->id() === $item->id)
                                    <span class="badge badge-success ml-2">Anda</span>
                                @endif
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->id() !== $item->id && $users->count() > 1)
                                <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Import Data Admin</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Silakan unduh template Excel berikut, isi data admin Anda, lalu unggah kembali ke sini.</p>
                        <a href="{{ route('admin.users.template') }}" class="btn btn-outline-success mb-4">
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
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });
        });
    </script>
@stop
