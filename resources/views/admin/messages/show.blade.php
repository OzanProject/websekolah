@extends('adminlte::page')

@section('title', 'Detail Pesan')

@section('content_header')
    <h1>Detail Pesan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Baca Pesan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-tool" title="Kembali">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h5>{{ $message->subject ?: 'Tanpa Subjek' }}</h5>
                        <h6>Dari: {{ $message->email }}
                            <span class="mailbox-read-time float-right">{{ $message->created_at->format('d M Y H:i A') }}</span>
                        </h6>
                        <h6>Nama Pengirim: {{ $message->name }}</h6>
                    </div>
                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-read-message p-4 bg-light rounded mt-3 mx-3 mb-3">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="mailto:{{ $message->email }}" class="btn btn-default"><i class="fas fa-reply"></i> Balas ke Email</a>
                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline float-right swal-delete-form" data-confirm-msg="Yakin ingin menghapus pesan ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop
