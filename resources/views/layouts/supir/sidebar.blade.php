<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SawitGoDigi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('supir.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supir.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Menu Supir</div>

    <!-- Pemesanan -->
    <li class="nav-item {{ request()->routeIs('supir.pemesanan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supir.pemesanan.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Pemesanan</span></a>
    </li>

    <!-- Track Record -->
    <li class="nav-item {{ request()->routeIs('supir.trackrecord.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supir.trackrecord.index') }}">
            <i class="fas fa-fw fa-route"></i>
            <span>Track Record</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>