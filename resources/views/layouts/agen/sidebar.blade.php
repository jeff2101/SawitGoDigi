<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SawitGoDigi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('agen/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/agen/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Beranda</div>

    <!-- Master Data Group -->
    <li
        class="nav-item {{ request()->routeIs('agen.petanis.*') || request()->routeIs('agen.supirs.*') || request()->is('agen/data-petani') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData"
            aria-expanded="{{ request()->routeIs('agen.petanis.*') || request()->routeIs('agen.supirs.*') || request()->is('agen/data-petani') ? 'true' : 'false' }}"
            aria-controls="collapseMasterData">
            <i class="fas fa-fw fa-folder"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMasterData"
            class="collapse {{ request()->routeIs('agen.petanis.*') || request()->routeIs('agen.supirs.*') || request()->is('agen/data-petani') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('agen.petanis.*') ? 'active' : '' }}"
                    href="{{ route('agen.petanis.index') }}">
                    <i class="fas fa-fw fa-users"></i> Daftar Petani
                </a>
                <a class="collapse-item {{ request()->routeIs('agen.supirs.*') ? 'active' : '' }}"
                    href="{{ route('agen.supirs.index') }}">
                    <i class="fas fa-fw fa-truck"></i> Daftar Supir
                </a>
                <a class="collapse-item {{ request()->routeIs('agen.data-petani.index') ? 'active' : '' }}"
                    href="{{ route('agen.data-petani.index') }}">
                    <i class="fas fa-fw fa-database"></i> Data Petani
                </a>
            </div>
        </div>
    </li>

    <!-- Transaksi Master Group -->
    <li
        class="nav-item {{ request()->routeIs('agen.hargajual.*') || request()->is('agen/pemesanan') || request()->routeIs('agen.transaksi.create') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaksiMaster"
            aria-expanded="{{ request()->routeIs('agen.hargajual.*') || request()->is('agen/pemesanan') || request()->routeIs('agen.transaksi.create') ? 'true' : 'false' }}"
            aria-controls="collapseTransaksiMaster">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi Master</span>
        </a>
        <div id="collapseTransaksiMaster"
            class="collapse {{ request()->routeIs('agen.hargajual.*') || request()->is('agen/pemesanan') || request()->routeIs('agen.transaksi.create') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('agen.hargajual.*') ? 'active' : '' }}"
                    href="{{ route('agen.hargajual.index') }}">
                    <i class="fas fa-fw fa-dollar-sign"></i> Harga Jual
                </a>
                <a class="collapse-item {{ request()->is('agen/pemesanan') ? 'active' : '' }}" href="/agen/pemesanan">
                    <i class="fas fa-fw fa-shopping-cart"></i> Pemesanan
                </a>
                <a class="collapse-item {{ request()->routeIs('agen.transaksi.create') ? 'active' : '' }}"
                    href="{{ route('agen.transaksi.create') }}">
                    <i class="fas fa-fw fa-plus-circle"></i> Transaksi Baru
                </a>
            </div>
        </div>
    </li>

    <!-- Laporan Pencatatan -->
    <li class="nav-item {{ request()->routeIs('agen.laporan.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('agen.laporan.index') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Laporan Pencatatan</span>
        </a>
    </li>

    <!-- Riwayat Transaksi -->
    <li class="nav-item {{ request()->routeIs('agen.transaksi.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('agen.transaksi.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Transaksi</span>
        </a>
    </li>

    <!-- Tracking Supir -->
    <li class="nav-item {{ request()->routeIs('agen.tracking.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('agen.tracking.index') }}">
            <i class="fas fa-fw fa-map-marker-alt"></i>
            <span>Tracking Supir</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>