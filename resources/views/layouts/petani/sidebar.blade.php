<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SawitGoDigi</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="/petani/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Beranda</div>
    <!-- Menu Lahan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petani.lahan.index') }}">
            <i class="fas fa-fw fa-leaf"></i>
            <span>Lahan</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('petani.hargajual.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petani.hargajual.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Harga Jual</span>
        </a>
    </li>

    <!-- Menu Pemesanan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petani.pemesanan.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Pemesanan</span>
        </a>
    </li>

    <!-- Riwayat Transaksi -->
    <li class="nav-item {{ request()->routeIs('petani.transaksi.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petani.transaksi.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Transaksi</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('petani.supir.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petani.supir.index') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Data Supir</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>