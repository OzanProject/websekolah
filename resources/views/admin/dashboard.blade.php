@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Utama</h1>
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $countPpdb }}</h3>
                    <p>Total Pendaftar PPDB</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="{{ route('admin.ppdb.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $countNews }}</h3>
                    <p>Total Berita</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="{{ route('admin.news.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $countProgram }}</h3>
                    <p>Program Unggulan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <a href="{{ route('admin.programs.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $countFacility }}</h3>
                    <p>Total Fasilitas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.facilities.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Data PPDB Terbaru -->
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Pendaftar PPDB Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>No. Daftar</th>
                                <th>Nama Lengkap</th>
                                <th>Asal Sekolah</th>
                                <th>Waktu Daftar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentPpdb as $ppdb)
                                <tr>
                                    <td><span class="badge badge-success">{{ $ppdb->nomor }}</span></td>
                                    <td>{{ $ppdb->nama }}</td>
                                    <td>{{ $ppdb->asal_sekolah }}</td>
                                    <td>{{ $ppdb->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data pendaftar.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('admin.ppdb.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua PPDB</a>
                </div>
            </div>
        </section>

        <!-- Right col -->
        <section class="col-lg-5 connectedSortable">
            <!-- Agenda Terdekat -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agenda Terdekat</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($recentAgenda as $agenda)
                        <li class="item">
                            <div class="product-info ml-0">
                                <a href="javascript:void(0)" class="product-title">{{ $agenda->title }}
                                    <span class="badge badge-warning float-right">{{ \Carbon\Carbon::parse($agenda->date)->format('d M Y') }}</span>
                                </a>
                                <span class="product-description">
                                    {{ $agenda->location }} | {{ $agenda->time }}
                                </span>
                            </div>
                        </li>
                        @empty
                            <li class="item text-center">Belum ada agenda terdekat.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.agendas.index') }}" class="uppercase">Lihat Semua Agenda</a>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Berita Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($recentNews as $news)
                        <li class="item">
                            <div class="product-img">
                                @if($news->image)
                                    <img src="{{ Storage::url($news->image) }}" alt="News Image" class="img-size-50">
                                @else
                                    <img src="/vendor/adminlte/dist/img/default-150x150.png" alt="News Image" class="img-size-50">
                                @endif
                            </div>
                            <div class="product-info">
                                <a href="{{ route('admin.news.edit', $news->id) }}" class="product-title">{{ Str::limit($news->title, 40) }}</a>
                                <span class="product-description">
                                    Diterbitkan: {{ $news->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </li>
                        @empty
                            <li class="item text-center">Belum ada berita diterbitkan.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.news.index') }}" class="uppercase">Lihat Semua Berita</a>
                </div>
            </div>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Dashboard loaded!');
    </script>
@stop
