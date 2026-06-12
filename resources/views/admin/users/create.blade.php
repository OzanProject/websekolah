@extends('adminlte::page')

@section('title', 'Tambah Admin')

@section('content_header')
    <h1>Tambah Admin</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Contoh: budi@sekolah.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Peran (Role)</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="penulis" {{ old('role') == 'penulis' ? 'selected' : '' }}>Penulis</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_approved">Status Persetujuan</label>
                    <select name="is_approved" id="is_approved" class="form-control @error('is_approved') is-invalid @enderror" required>
                        <option value="1" {{ old('is_approved') == '1' ? 'selected' : '' }}>Aktif (Disetujui)</option>
                        <option value="0" {{ old('is_approved') == '0' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    </select>
                    @error('is_approved')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Ulangi password di atas" required>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Admin</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
