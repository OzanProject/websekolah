@extends('layouts.app')

@php
    $profile = \App\Models\SchoolProfile::first();
    $ppdbActive = $profile->ppdb_active ?? false;
    $ppdbTitle = $profile->ppdb_title ?? 'Formulir Pendaftaran PPDB';
    $ppdbYear = $profile->ppdb_year ?? 'Tahun Ajaran ' . date('Y') . '/' . (date('Y')+1);
    $ppdbDesc = $profile->ppdb_description ?? '';
@endphp

@section('content')
<div class="pt-20 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-[#1E3A8A] px-8 py-10 text-white text-center">
                <h1 class="text-3xl font-bold mb-3">{{ $ppdbTitle }}</h1>
                <p class="text-white/80">{{ $ppdbYear }}</p>
            </div>
            
            <div class="p-8" x-data="{ activeTab: '{{ session('error_cek') || !empty($check_result) ? 'cek' : 'form' }}' }">
                
                <!-- TABS -->
                <div class="flex flex-col sm:flex-row border-b border-slate-200 mb-8">
                    <button @click="activeTab = 'form'" 
                            :class="activeTab === 'form' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm sm:text-base text-center transition-colors">
                        <i class="fas fa-edit mr-2"></i> Formulir Pendaftaran
                    </button>
                    <button @click="activeTab = 'cek'" 
                            :class="activeTab === 'cek' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm sm:text-base text-center transition-colors">
                        <i class="fas fa-search mr-2"></i> Cek Status
                    </button>
                </div>

                <!-- TAB: CEK STATUS -->
                <div x-show="activeTab === 'cek'" x-transition.opacity.duration.300ms style="display: none;">
                    <div class="max-w-xl mx-auto">
                        <h2 class="text-xl font-bold text-slate-800 mb-6 text-center">Lacak Status Pendaftaran Anda</h2>
                        
                        <form action="{{ route('ppdb.check-status') }}" method="POST" class="mb-8">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text" name="nomor" placeholder="Masukkan Nomor Pendaftaran (Misal: PPDB-2026-0001)" required
                                    class="flex-1 h-12 px-4 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent">
                                <button type="submit" class="h-12 bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold px-6 rounded-lg transition duration-200">
                                    Cek Status
                                </button>
                            </div>
                            @if(session('error_cek'))
                                <p class="text-red-500 text-sm mt-2 text-center">{{ session('error_cek') }}</p>
                            @endif
                        </form>

                        @if(!empty($check_result))
                            <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 shadow-sm">
                                <div class="text-center mb-6">
                                    <h3 class="text-lg font-medium text-slate-600 mb-1">Status Kelulusan:</h3>
                                    <p class="text-xl font-bold text-slate-800 mb-4">{{ $ppdb_nomor }}</p>
                                    
                                    @if($ppdb_status == 'diterima')
                                        <div class="inline-flex items-center justify-center space-x-2 bg-green-100 text-green-800 px-6 py-3 rounded-full">
                                            <i class="fas fa-check-circle text-2xl"></i>
                                            <span class="text-xl font-bold uppercase">Selamat! Anda Diterima</span>
                                        </div>
                                    @elseif($ppdb_status == 'ditolak')
                                        <div class="inline-flex items-center justify-center space-x-2 bg-red-100 text-red-800 px-6 py-3 rounded-full">
                                            <i class="fas fa-times-circle text-2xl"></i>
                                            <span class="text-xl font-bold uppercase">Mohon Maaf, Anda Ditolak</span>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center justify-center space-x-2 bg-yellow-100 text-yellow-800 px-6 py-3 rounded-full">
                                            <i class="fas fa-hourglass-half text-2xl"></i>
                                            <span class="text-xl font-bold uppercase">Menunggu Pengumuman</span>
                                        </div>
                                    @endif
                                </div>

                                @if($ppdb_status == 'ditolak' && !empty($ppdb_pesan))
                                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                                        <p class="text-sm text-red-700 font-bold mb-1">Catatan Panitia:</p>
                                        <p class="text-sm text-red-600">{{ $ppdb_pesan }}</p>
                                    </div>
                                @endif
                                
                                @if(!empty($ppdb_pesan) && $ppdb_status != 'ditolak')
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                                        <p class="text-sm text-blue-700 font-bold mb-1">Catatan / Informasi Tambahan:</p>
                                        <p class="text-sm text-blue-600">{{ $ppdb_pesan }}</p>
                                    </div>
                                @endif

                                @if($ppdb_status == 'ditolak')
                                    <div class="mt-6 border-t pt-6">
                                        <button @click="activeTab = 'form'" class="w-full bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-sm flex justify-center items-center">
                                            <i class="fas fa-edit mr-2"></i> Perbaiki Data Pendaftaran
                                        </button>
                                        <p class="text-xs text-slate-500 mt-2">Formulir akan terisi otomatis dengan data lama Anda.</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TAB: FORMULIR -->
                <div x-show="activeTab === 'form'" x-transition.opacity.duration.300ms>
                @if($ppdbDesc)
                    <div class="mb-6 p-4 bg-blue-50 text-blue-800 rounded-lg border border-blue-100 text-center">
                        <p>{{ $ppdbDesc }}</p>
                    </div>
                @endif

                @if(!$ppdbActive)
                    <div class="text-center py-10">
                        <x-lucide-x-circle class="w-20 h-20 text-red-500 mx-auto mb-4" />
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Pendaftaran Ditutup</h2>
                        <p class="text-slate-600">Mohon maaf, formulir pendaftaran PPDB saat ini sedang tidak menerima tanggapan baru.</p>
                        <a href="/" class="mt-6 inline-block bg-[#1E3A8A] text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">Kembali ke Beranda</a>
                    </div>
                @else
                    @if(session('success'))
                        <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-xl text-center" x-data="{ show: true }" x-show="show">
                            <x-lucide-check-circle class="w-12 h-12 text-green-500 mx-auto mb-4" />
                            @if(session('is_edit'))
                                <h3 class="text-xl font-bold text-green-800 mb-2">Pembaruan Data Berhasil!</h3>
                                <p class="text-green-700 mb-4">Data pendaftaran Anda telah berhasil diperbaiki dan status Anda kembali dalam proses peninjauan.</p>
                            @else
                                <h3 class="text-xl font-bold text-green-800 mb-2">Pendaftaran Berhasil!</h3>
                                <p class="text-green-700 mb-4">Nomor Pendaftaran Anda:</p>
                                <div class="text-3xl font-mono font-bold text-[#1E3A8A] bg-white border border-slate-200 py-3 px-6 rounded-lg inline-block mb-4">
                                    {{ session('nomor_pendaftaran') }}
                                </div>
                                <p class="text-sm text-green-700">Simpan nomor ini untuk keperluan verifikasi dan daftar ulang.</p>
                            @endif
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-100">
                            <h4 class="font-bold mb-2">Terdapat Kesalahan:</h4>
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($sections->isEmpty())
                        <div class="text-center py-10 border border-dashed border-slate-300 rounded-lg">
                            <p class="text-slate-500">Formulir pendaftaran belum dikonfigurasi oleh Administrator.</p>
                        </div>
                    @else
                        <form action="{{ url('/ppdb') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            
                            @php
                                $isEditing = isset($ppdb_status) && $ppdb_status == 'ditolak' && !empty($ppdb_data);
                            @endphp

                            @if($isEditing)
                                <input type="hidden" name="edit_nomor" value="{{ $ppdb_nomor }}">
                                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded relative mb-4 flex items-start" role="alert">
                                    <i class="fas fa-info-circle mt-1 mr-3 text-blue-500"></i>
                                    <div>
                                        <span class="block sm:inline font-medium">Mode Perbaikan Data.</span>
                                        <span class="block text-sm mt-1 text-blue-600">Anda sedang memperbaiki data untuk nomor pendaftaran <strong>{{ $ppdb_nomor }}</strong>. Silakan perbaiki bagian yang salah lalu kirim ulang.</span>
                                    </div>
                                </div>
                            @endif

                            @foreach($sections as $section)
                                <div>
                                    <h3 class="text-lg font-bold text-[#0F172A] border-b pb-2 mb-4">{{ $section->name }}</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($section->fields as $field)
                                            <div class="space-y-2 {{ $field->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                                <label class="text-sm font-medium text-slate-700">
                                                    {{ $field->label }} {!! $field->is_required ? '<span class="text-red-500">*</span>' : '' !!}
                                                </label>

                                                @php 
                                                    $inputName = "fields[" . $field->name . "]"; 
                                                    $oldVal = old('fields.'.$field->name, $isEditing ? ($ppdb_data[$field->name] ?? '') : '');
                                                @endphp

                                                @if($field->type === 'textarea')
                                                    <textarea name="{{ $inputName }}" {{ $field->is_required ? 'required' : '' }} rows="3" class="w-full p-3 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent">{{ $oldVal }}</textarea>
                                                @elseif($field->type === 'select')
                                                    <select name="{{ $inputName }}" {{ $field->is_required ? 'required' : '' }} class="w-full h-10 px-3 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent bg-white">
                                                        <option value="">Pilih {{ $field->label }}</option>
                                                        @if(is_array($field->options))
                                                            @foreach($field->options as $option)
                                                                <option value="{{ $option }}" {{ $oldVal == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                @else
                                                    <input type="{{ $field->type }}" name="{{ $inputName }}" {{ $field->is_required ? 'required' : '' }} class="w-full h-10 px-3 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent" value="{{ $oldVal }}">
                                                @endif

                                                @if($field->help_text)
                                                    <p class="text-xs text-slate-500">{{ $field->help_text }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            @if($requirements->isNotEmpty())
                                <div>
                                    <h3 class="text-lg font-bold text-[#0F172A] border-b pb-2 mb-4">Syarat Dokumen (Upload)</h3>
                                    <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                                        <p class="text-sm text-slate-600 mb-4">Format file yang didukung: PDF, JPG, PNG (Maks 2MB).</p>
                                        <div class="space-y-4">
                                            @foreach($requirements as $req)
                                                <div class="bg-white p-3 rounded border border-slate-200">
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                                        {{ $req->name }} {!! $req->is_required ? '<span class="text-red-500">*</span>' : '<span class="text-slate-400 font-normal">(Opsional)</span>' !!}
                                                    </label>
                                                    <input type="file" name="req_{{ $req->id }}" id="req_{{ $req->id }}" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'preview_{{ $req->id }}')" {{ ($req->is_required && !$isEditing) ? 'required' : '' }} class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#1E3A8A] file:text-white hover:file:bg-blue-800 transition">
                                                    
                                                    <!-- Tempat Preview -->
                                                    <div id="preview_{{ $req->id }}" class="mt-3 hidden rounded-lg border border-slate-200 p-2 bg-slate-50 relative overflow-hidden">
                                                        <!-- Preview content will be injected here via JS -->
                                                    </div>

                                                    @if($isEditing && $req->is_required)
                                                        <p class="text-xs text-orange-500 mt-1 mt-1"><i class="fas fa-exclamation-triangle"></i> Biarkan kosong jika tidak ingin mengubah berkas yang sudah diunggah sebelumnya.</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="pt-6 border-t">
                                <button type="submit" class="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-lg shadow-sm">
                                    Kirim Formulir Pendaftaran
                                </button>
                            </div>
                        </form>
                    @endif
                @endif
                </div> <!-- End Tab Formulir -->
            </div>
        </div>
    </div>
</div>

<script>
function previewFile(input, previewId) {
    const previewContainer = document.getElementById(previewId);
    previewContainer.innerHTML = ''; // Clear previous preview
    previewContainer.classList.remove('hidden');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileType = file.type;
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // in MB

        if (fileType.startsWith('image/')) {
            // Preview Image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <div class="flex items-center">
                        <img src="${e.target.result}" class="w-24 h-24 object-cover rounded shadow-sm mr-4" alt="Preview">
                        <div>
                            <p class="text-sm font-semibold text-slate-700 truncate w-48">${fileName}</p>
                            <p class="text-xs text-slate-500">${fileSize} MB</p>
                        </div>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        } else if (fileType === 'application/pdf') {
            // Preview PDF
            previewContainer.innerHTML = `
                <div class="flex items-center p-2">
                    <i class="fas fa-file-pdf text-red-500 text-3xl mr-4"></i>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 truncate w-48">${fileName}</p>
                        <p class="text-xs text-slate-500">${fileSize} MB</p>
                    </div>
                </div>
            `;
        } else {
            // Unknown type
            previewContainer.innerHTML = `
                <p class="text-sm text-red-500"><i class="fas fa-exclamation-triangle"></i> Format file tidak didukung untuk pratinjau.</p>
            `;
        }
    } else {
        previewContainer.classList.add('hidden');
    }
}
</script>
@endsection
