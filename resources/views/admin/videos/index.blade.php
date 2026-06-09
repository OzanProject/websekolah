@extends('adminlte::page')

@section('title', 'Video Profil')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Video Profil Sekolah</h1>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Video
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="videosTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">No</th>
                        <th>Judul</th>
                        <th>URL YouTube</th>
                        <th style="width: 100px" class="text-center">Status</th>
                        <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item->title }}</strong></td>
                            <td><a href="{{ $item->url }}" target="_blank" class="text-info"><i class="fas fa-external-link-alt"></i> {{ Str::limit($item->url, 40) }}</a></td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!$item->is_active)
                                <form action="{{ route('admin.videos.activate', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Aktifkan video ini? Video lain akan otomatis dinonaktifkan.')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Jadikan Aktif">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('admin.videos.edit', $item->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
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
            $('#videosTable').DataTable({
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
