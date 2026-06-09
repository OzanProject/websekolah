@extends('adminlte::page')

@section('title', 'Edit Agenda')

@section('content_header')
    <h1>Edit Agenda</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Judul Agenda</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $agenda->title) }}" placeholder="Masukkan judul agenda" required>
                </div>
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" name="location" class="form-control" id="location" value="{{ old('location', $agenda->location) }}" placeholder="Masukkan lokasi agenda" required>
                </div>

                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date', $agenda->date) }}" required>
                    @error('date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="time">Waktu Pelaksanaan</label>
                    <input type="text" name="time" class="form-control @error('time') is-invalid @enderror" id="time" placeholder="Contoh: 08:00 - Selesai" value="{{ old('time', $agenda->time) }}" required>
                    @error('time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Agenda</button>
                <a href="{{ route('admin.agendas.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
