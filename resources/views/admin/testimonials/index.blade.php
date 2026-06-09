@extends('adminlte::page')

@section('title', 'Testimoni')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Testimoni</h1>
        <div>
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel"></i> Import Excel
            </button>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Testimoni
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
            <table id="testimonialsTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">No</th>
                        <th style="width: 80px">Avatar</th>
                        <th>Nama</th>
                        <th>Peran (Role)</th>
                        <th>Kutipan</th>
                        <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-center">
                                @if($item->avatar_path)
                                    <img src="{{ filter_var($item->avatar_path, FILTER_VALIDATE_URL) ? $item->avatar_path : Storage::url($item->avatar_path) }}" alt="{{ $item->name }}" class="img-circle img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&background=random" alt="{{ $item->name }}" class="img-circle img-thumbnail" style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td><span class="badge badge-info">{{ $item->role }}</span></td>
                            <td><i>"{{ Str::limit($item->quote, 50) }}"</i></td>
                            <td class="text-center">
                                <a href="{{ route('admin.testimonials.edit', $item->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
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

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.testimonials.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Import Data Testimoni</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Silakan unduh template Excel berikut, isi data testimoni Anda, lalu unggah kembali ke sini.</p>
                        <a href="{{ route('admin.testimonials.template') }}" class="btn btn-outline-success mb-4">
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
            $('#testimonialsTable').DataTable({
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
