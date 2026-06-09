@extends('adminlte::page')

@section('title', 'Daftar Halaman Kustom')

@section('content_header')
    <h1>Daftar Halaman Kustom</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kelola Halaman Kustom</h3>
            <div class="card-tools">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Halaman Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif

            <table id="pagesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Halaman</th>
                        <th>URL Halaman</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td><a href="{{ url('halaman/' . $page->slug) }}" target="_blank">/halaman/{{ $page->slug }} <i class="fas fa-external-link-alt text-xs"></i></a></td>
                            <td>
                                @if($page->is_active)
                                    <span class="badge badge-success">Aktif / Publik</span>
                                @else
                                    <span class="badge badge-secondary">Draft / Sembunyi</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Apakah Anda yakin ingin menghapus halaman ini?">
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#pagesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@stop
