@extends('adminlte::page')

@section('title', 'Pengaturan Navigasi')

@section('content_header')
    <h1>Pengaturan Navigasi (Menu Utama & Footer)</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.navigations.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom Kiri: Header Navigasi -->
            <div class="col-md-7">
                <!-- Header Navigasi -->
                <div class="card card-info" x-data="headerNavBuilder()">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Menu Atas (Navbar)</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-muted">Atur menu navigasi utama. Anda dapat membuat menu tunggal atau menu *dropdown* (bersarang).</p>
                        <input type="hidden" name="header_navigations_json" id="header_navigations_json" :value="JSON.stringify(menus)">
                        
                        <div class="space-y-4 mb-4">
                            <template x-for="(menu, index) in menus" :key="index">
                                <div class="border p-3 rounded bg-light mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="m-0 font-weight-bold">Menu <span x-text="index + 1"></span></h6>
                                        <button type="button" class="btn btn-sm btn-danger" @click="removeMenu(index)"><i class="fas fa-trash"></i></button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-xs">Judul Menu</label>
                                                <input type="text" class="form-control form-control-sm" x-model="menu.title" placeholder="Misal: Beranda">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group" x-show="!menu.is_dropdown">
                                                <label class="text-xs">URL / Link</label>
                                                <input type="text" class="form-control form-control-sm" x-model="menu.url" placeholder="Misal: /#home atau /berita">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-4 pt-1">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :id="'is_dropdown_' + index" x-model="menu.is_dropdown">
                                                    <label class="custom-control-label text-xs" :for="'is_dropdown_' + index">Jadikan Dropdown</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenus -->
                                    <div class="pl-4 border-left ml-2" x-show="menu.is_dropdown">
                                        <label class="text-xs font-weight-bold">Sub-Menu (Anak Menu):</label>
                                        <template x-for="(child, childIndex) in menu.children" :key="childIndex">
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" x-model="child.title" placeholder="Judul Sub-menu">
                                                <input type="text" class="form-control" x-model="child.url" placeholder="URL Sub-menu">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-danger" @click="removeChild(index, childIndex)"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        </template>
                                        <button type="button" class="btn btn-xs btn-outline-info mt-1" @click="addChild(index)"><i class="fas fa-plus"></i> Tambah Sub-Menu</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" class="btn btn-sm btn-info" @click="addMenu()"><i class="fas fa-plus"></i> Tambah Menu Utama</button>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Footer Navigasi -->
            <div class="col-md-5">
                <!-- Footer Navigasi & Link Terkait -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Footer (Link Bawah)</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Menu Navigasi</label>
                            <div id="nav-container">
                                @php
                                    $navs = old('nav_title', is_array($profile->footer_navigations) ? $profile->footer_navigations : []);
                                    if(empty($navs)) {
                                        // Default fallback if empty
                                        $navs = [
                                            ['title' => 'Beranda', 'url' => '/#home'],
                                            ['title' => 'Profil Sekolah', 'url' => '/#about']
                                        ];
                                    }
                                @endphp

                                @foreach($navs as $index => $nav)
                                    @php
                                        $title = is_array($nav) ? $nav['title'] : $nav;
                                        $url = is_array($nav) ? $nav['url'] : (old('nav_url')[$index] ?? '');
                                    @endphp
                                    <div class="input-group mb-2 nav-row">
                                        <input type="text" name="nav_title[]" class="form-control" value="{{ $title }}" placeholder="Judul Link (misal: Beranda)">
                                        <input type="text" name="nav_url[]" class="form-control" value="{{ $url }}" placeholder="URL (misal: /#home)">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger btn-remove-nav"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="btn-add-nav">
                                <i class="fas fa-plus"></i> Tambah Navigasi
                            </button>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Link Terkait</label>
                            <div id="link-container">
                                @php
                                    $links = old('link_title', is_array($profile->footer_related_links) ? $profile->footer_related_links : []);
                                    if(empty($links)) {
                                        // Default fallback if empty
                                        $links = [
                                            ['title' => 'Kemdikbud RI', 'url' => 'https://www.kemdikbud.go.id']
                                        ];
                                    }
                                @endphp

                                @foreach($links as $index => $link)
                                    @php
                                        $title = is_array($link) ? $link['title'] : $link;
                                        $url = is_array($link) ? $link['url'] : (old('link_url')[$index] ?? '');
                                    @endphp
                                    <div class="input-group mb-2 link-row">
                                        <input type="text" name="link_title[]" class="form-control" value="{{ $title }}" placeholder="Judul Link (misal: Kemdikbud)">
                                        <input type="text" name="link_url[]" class="form-control" value="{{ $url }}" placeholder="URL (misal: https://...)">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger btn-remove-link"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="btn-add-link">
                                <i class="fas fa-plus"></i> Tambah Link Terkait
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Pengaturan Navigasi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function headerNavBuilder() {
            let initialData = {!! json_encode(old('header_navigations_json', $profile->header_navigations)) !!};
            
            if(!initialData || (Array.isArray(initialData) && initialData.length === 0)) {
                initialData = [
                    { title: 'Beranda', url: '/', is_dropdown: false, children: [] },
                    { title: 'Profil', url: '', is_dropdown: true, children: [
                        { title: 'Visi & Misi', url: '/profil' },
                        { title: 'Sambutan Kepala Sekolah', url: '/profil' },
                        { title: 'Fasilitas', url: '/fasilitas' }
                    ]},
                    { title: 'Akademik', url: '', is_dropdown: true, children: [
                        { title: 'Program Unggulan', url: '/program' }
                    ]},
                    { title: 'Berita', url: '/berita', is_dropdown: false, children: [] },
                    { title: 'Galeri', url: '/galeri', is_dropdown: false, children: [] },
                    { title: 'Agenda', url: '/agenda', is_dropdown: false, children: [] },
                    { title: 'Kontak', url: '/kontak', is_dropdown: false, children: [] }
                ];
            }

            return {
                menus: initialData,
                addMenu() {
                    this.menus.push({
                        title: '',
                        url: '',
                        is_dropdown: false,
                        children: []
                    });
                },
                removeMenu(index) {
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Hapus menu ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.menus.splice(index, 1);
                        }
                    });
                },
                addChild(parentIndex) {
                    if(!this.menus[parentIndex].children) {
                        this.menus[parentIndex].children = [];
                    }
                    this.menus[parentIndex].children.push({
                        title: '',
                        url: ''
                    });
                },
                removeChild(parentIndex, childIndex) {
                    this.menus[parentIndex].children.splice(childIndex, 1);
                }
            }
        }

        $(document).ready(function() {
            // Fungsi Tambah Navigasi Footer
            $('#btn-add-nav').click(function() {
                var html = `
                    <div class="input-group mb-2 nav-row">
                        <input type="text" name="nav_title[]" class="form-control" placeholder="Judul Link (misal: Beranda)">
                        <input type="text" name="nav_url[]" class="form-control" placeholder="URL (misal: /#home)">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-remove-nav"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
                $('#nav-container').append(html);
            });

            $(document).on('click', '.btn-remove-nav', function() {
                if ($('.nav-row').length > 1) {
                    $(this).closest('.nav-row').remove();
                } else {
                    alert('Harus ada minimal 1 link navigasi!');
                }
            });

            // Fungsi Tambah Link Terkait Footer
            $('#btn-add-link').click(function() {
                var html = `
                    <div class="input-group mb-2 link-row">
                        <input type="text" name="link_title[]" class="form-control" placeholder="Judul Link (misal: Kemdikbud)">
                        <input type="text" name="link_url[]" class="form-control" placeholder="URL (misal: https://...)">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-remove-link"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
                $('#link-container').append(html);
            });

            $(document).on('click', '.btn-remove-link', function() {
                if ($('.link-row').length > 1) {
                    $(this).closest('.link-row').remove();
                } else {
                    alert('Harus ada minimal 1 link terkait!');
                }
            });
        });
    </script>
@stop
