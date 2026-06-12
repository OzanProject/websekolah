@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    <!-- DataTables & Plugins -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        {{-- Preloader dihilangkan sesuai permintaan --}}

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @include('adminlte::partials.footer.footer')

        {{-- Right Control Sidebar --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function attachSwalToForms() {
            $('form').each(function() {
                var onsubmit = $(this).attr('onsubmit');
                if (onsubmit && onsubmit.indexOf('return confirm') !== -1) {
                    var match = onsubmit.match(/confirm\(['"](.*?)['"]\)/);
                    var msg = match ? match[1] : 'Are you sure?';
                    $(this).removeAttr('onsubmit');
                    $(this).attr('data-confirm-msg', msg);
                    $(this).addClass('swal-delete-form');
                }
            });
        }

        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{!! addslashes(session('success')) !!}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{!! addslashes(session('error')) !!}',
                    timer: 4000,
                    showConfirmButton: false
                });
            @endif

            attachSwalToForms();

            // Re-attach for DataTables events
            $(document).on('draw.dt', function() {
                attachSwalToForms();
            });

            $(document).on('submit', '.swal-delete-form', function(e) {
                e.preventDefault();
                var form = this;
                var dynamicMsg = $(this).attr('data-confirm-msg');
                
                Swal.fire({
                  title: "Apakah Anda yakin?",
                  text: dynamicMsg,
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#d33",
                  cancelButtonColor: "#3085d6",
                  confirmButtonText: "Ya, lanjutkan!",
                  cancelButtonText: "Batal"
                }).then((result) => {
                  if (result.isConfirmed) {
                    Swal.fire({
                      title: "Berhasil!",
                      text: "Tindakan segera diproses.",
                      icon: "success",
                      showConfirmButton: false,
                      timer: 1500
                    });
                    
                    setTimeout(() => { form.submit(); }, 600);
                  }
                });
            });
        });
    </script>
    
    <!-- DataTables & Plugins -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

    <!-- TinyMCE -->
    @php
        $tinymceKey = \App\Models\SchoolProfile::first()->tinymce_api_key ?? 'no-api-key';
        if (empty($tinymceKey)) $tinymceKey = 'no-api-key';
    @endphp
    <script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    @stack('js')
    @yield('js')
@stop
