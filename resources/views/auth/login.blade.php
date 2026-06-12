@extends('adminlte::auth.login')

@section('adminlte_css')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Tutup'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Tutup'
                });
            @endif
        });
    </script>
@endsection