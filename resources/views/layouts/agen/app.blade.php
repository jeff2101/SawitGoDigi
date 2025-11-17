<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.agen.head')
    @stack('styles') {{-- Optional tambahan style dari halaman --}}
</head>

<body id="page-top">
    <div id="wrapper">
        {{-- Sidebar --}}
        @include('layouts.agen.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Topbar --}}
                @include('layouts.agen.topbar')

                {{-- Konten Utama --}}
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('layouts.agen.footer')
        </div>
    </div>

    {{-- SweetAlert --}}
    @include('vendor.sweetalert.alert')

    {{-- Tombol Scroll ke Atas --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Logout Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Keluar dari Aplikasi?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda yakin ingin keluar dari sesi saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

                    {{-- Form Logout --}}
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Utama --}}
    @include('layouts.agen.scripts')

    {{-- Tambahan Script dari Halaman --}}
    @stack('scripts')
</body>

</html>