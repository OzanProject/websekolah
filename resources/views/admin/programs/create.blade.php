@extends('adminlte::page')

@section('title', 'Tambah Program Unggulan')

@section('content_header')
    <h1>Tambah Program Unggulan</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title_id">Judul Program</label>
                    <input type="text" name="title[id]" class="form-control" id="title_id" value="{{ old('title.id') }}" placeholder="Masukkan judul program" required>
                </div>
                <div class="form-group">
                    <label for="description_id">Deskripsi</label>
                    <textarea name="description[id]" class="form-control" id="description_id" rows="4" placeholder="Masukkan deskripsi program" required>{{ old('description.id') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="icon">Pilih Ikon</label>
                    <select name="icon" class="form-control @error('icon') is-invalid @enderror" id="icon">
                        <option value="">-- Tanpa Ikon --</option>
                        <option value="building-2" {{ old('icon') == 'building-2' ? 'selected' : '' }}>Gedung / Bangunan</option>
                        <option value="book-open" {{ old('icon') == 'book-open' ? 'selected' : '' }}>Buku Terbuka</option>
                        <option value="book-marked" {{ old('icon') == 'book-marked' ? 'selected' : '' }}>Buku Bertanda</option>
                        <option value="monitor" {{ old('icon') == 'monitor' ? 'selected' : '' }}>Komputer / Monitor</option>
                        <option value="laptop" {{ old('icon') == 'laptop' ? 'selected' : '' }}>Laptop / Komputer Portabel</option>
                        <option value="flask-conical" {{ old('icon') == 'flask-conical' ? 'selected' : '' }}>Laboratorium / Flask</option>
                        <option value="trophy" {{ old('icon') == 'trophy' ? 'selected' : '' }}>Piala / Penghargaan</option>
                        <option value="heart" {{ old('icon') == 'heart' ? 'selected' : '' }}>Hati / Kesehatan</option>
                        <option value="globe" {{ old('icon') == 'globe' ? 'selected' : '' }}>Bola Dunia / Jaringan</option>
                        <option value="graduation-cap" {{ old('icon') == 'graduation-cap' ? 'selected' : '' }}>Topi Toga / Akademik</option>
                        <option value="users" {{ old('icon') == 'users' ? 'selected' : '' }}>Pengguna / Komunitas</option>
                        <option value="activity" {{ old('icon') == 'activity' ? 'selected' : '' }}>Aktivitas / Olahraga</option>
                    </select>
                    @error('icon')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
