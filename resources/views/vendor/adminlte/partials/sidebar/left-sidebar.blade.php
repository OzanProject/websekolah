<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Menu Kustom (Static HTML) --}}
                
                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- INFORMASI SEKOLAH --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ Request::is('admin/programs*') || Request::is('admin/facilities*') || Request::is('admin/profiles*') || Request::is('admin/navigations*') || Request::is('admin/extracurriculars*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/programs*') || Request::is('admin/facilities*') || Request::is('admin/profiles*') || Request::is('admin/navigations*') || Request::is('admin/extracurriculars*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            INFORMASI SEKOLAH
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.profiles.edit') }}" class="nav-link {{ Request::is('admin/profiles*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profil (Visi & Misi)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.navigations.edit') }}" class="nav-link {{ Request::is('admin/navigations*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Navigasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.programs.index') }}" class="nav-link {{ Request::is('admin/programs*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Program Unggulan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.facilities.index') }}" class="nav-link {{ Request::is('admin/facilities*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fasilitas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.extracurriculars.index') }}" class="nav-link {{ Request::is('admin/extracurriculars*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ekstrakurikuler</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- PUBLIKASI & KEGIATAN --}}
                <li class="nav-item {{ Request::is('admin/news*') || Request::is('admin/agendas*') || Request::is('admin/galleries*') || Request::is('admin/videos*') || Request::is('admin/pages*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/news*') || Request::is('admin/agendas*') || Request::is('admin/galleries*') || Request::is('admin/videos*') || Request::is('admin/pages*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            PUBLIKASI & KEGIATAN
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.news.index') }}" class="nav-link {{ Request::is('admin/news*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Berita</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.agendas.index') }}" class="nav-link {{ Request::is('admin/agendas*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agenda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ Request::is('admin/galleries*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Galeri</p>
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('admin.videos.index') }}" class="nav-link {{ Request::is('admin/videos*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Video Profil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ Request::is('admin/pages*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Halaman Kustom</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                {{-- INTERAKSI --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ Request::is('admin/testimonials*') || Request::is('admin/messages*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/testimonials*') || Request::is('admin/messages*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            INTERAKSI
                            <i class="right fas fa-angle-left"></i>
                            @php
                                $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
                            @endphp
                            @if($unreadMessages > 0)
                                <span class="badge badge-danger right">{{ $unreadMessages }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.index') }}" class="nav-link {{ Request::is('admin/messages*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pesan Masuk
                                    @if($unreadMessages > 0)
                                        <span class="badge badge-danger right">{{ $unreadMessages }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ Request::is('admin/testimonials*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Testimoni</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- PENDAFTARAN PPDB --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ Request::is('admin/ppdb*') || Request::is('admin/settings/ppdb*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/ppdb*') || Request::is('admin/settings/ppdb*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            PENDAFTARAN PPDB
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.ppdb.index') }}" class="nav-link {{ Request::routeIs('admin.ppdb.index') || Request::routeIs('admin.ppdb.show') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pendaftar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.ppdb.edit') }}" class="nav-link {{ Request::is('admin/settings/ppdb*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan PPDB</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- SISTEM --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ Request::is('admin/users*') || Request::is('admin/settings/general*') || Request::is('admin/backups*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/users*') || Request::is('admin/settings/general*') || Request::is('admin/backups*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            SISTEM
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.general.edit') }}" class="nav-link {{ Request::is('admin/settings/general*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Umum</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Administrator</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.backups.index') }}" class="nav-link {{ Request::is('admin/backups*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-warning"></i>
                                <p>Backup & Restore</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- Konfigurasi bawaan jika masih ada yang terlewat (opsional, dikomen saja) --}}
                {{-- @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item') --}}
            </ul>
        </nav>
    </div>

</aside>
