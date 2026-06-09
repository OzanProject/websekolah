@extends('adminlte::page')

@section('title', 'Edit Testimoni')

@section('content_header')
    <h1>Edit Testimoni</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Contoh: Budi Santoso" value="{{ old('name', $testimonial->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Peran (Role)</label>
                    <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" id="role" placeholder="Contoh: Alumni 2025, Orang Tua Siswa, Siswa Berprestasi" value="{{ old('role', $testimonial->role) }}" required>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Language Tabs -->
                <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="id-tab" data-toggle="tab" href="#lang-id" role="tab">🇮🇩 Indonesia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="en-tab" data-toggle="tab" href="#lang-en" role="tab">🇬🇧 English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ar-tab" data-toggle="tab" href="#lang-ar" role="tab">🇸🇦 العربية</a>
                    </li>
                </ul>

                <div class="tab-content" id="langTabsContent">
                    <!-- Tab Indonesia -->
                    <div class="tab-pane fade show active" id="lang-id" role="tabpanel">
                        <div class="form-group">
                            <label for="quote_id">Kutipan Testimoni (ID)</label>
                            <textarea name="quote[id]" class="form-control" id="quote_id" rows="4" required>{{ old('quote.id', $testimonial->getTranslation('quote', 'id', false)) }}</textarea>
                        </div>
                    </div>

                    <!-- Tab English -->
                    <div class="tab-pane fade" id="lang-en" role="tabpanel">
                        <div class="form-group">
                            <label for="quote_en">Kutipan Testimoni (EN)</label>
                            <textarea name="quote[en]" class="form-control" id="quote_en" rows="4">{{ old('quote.en', $testimonial->getTranslation('quote', 'en', false)) }}</textarea>
                        </div>
                    </div>

                    <!-- Tab Arabic -->
                    <div class="tab-pane fade" id="lang-ar" role="tabpanel">
                        <div class="form-group">
                            <label for="quote_ar">Kutipan Testimoni (AR)</label>
                            <textarea name="quote[ar]" class="form-control" id="quote_ar" rows="4" dir="rtl">{{ old('quote.ar', $testimonial->getTranslation('quote', 'ar', false)) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="avatar">Ganti Foto Profil (Opsional)</label>
                    @if($testimonial->avatar_path)
                        <div class="mb-3">
                            <img src="{{ filter_var($testimonial->avatar_path, FILTER_VALIDATE_URL) ? $testimonial->avatar_path : Storage::url($testimonial->avatar_path) }}" alt="{{ $testimonial->name }}" class="img-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    @else
                        <div class="mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=random" alt="{{ $testimonial->name }}" class="img-circle img-thumbnail" style="width: 100px; height: 100px;">
                        </div>
                    @endif
                    <input type="file" name="avatar" class="form-control-file @error('avatar') is-invalid @enderror" id="avatar" accept="image/*">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengganti foto profil. Format: JPG, JPEG, PNG. Maks: 2MB.</small>
                    @error('avatar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Testimoni</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-default float-right">Batal</a>
            </div>
        </form>
    </div>
@stop
