<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand Logo -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin/dashboard">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo" style="height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">SawitGoDigi</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Beranda</div>

    <li class="nav-item">
        <a class="nav-link" href="/admin/usahas">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Daftar Usaha</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/agens">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Daftar Agen</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading untuk menu landing page -->
    <div class="sidebar-heading">Halaman Depan</div>

    <!-- Menu collapse Halaman Depan -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLanding"
            aria-expanded="false" aria-controls="collapseLanding">
            <i class="fas fa-fw fa-globe"></i>
            <span>Halaman Depan</span>
        </a>
        <div id="collapseLanding" class="collapse" aria-labelledby="headingLanding" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pengaturan Halaman:</h6>

                <a class="collapse-item" href="/admin/about">
                    Tentang Kami
                </a>
                <a class="collapse-item" href="/admin/visi-misi">
                    Visi &amp; Misi
                </a>
                <a class="collapse-item" href="/admin/features">
                    Fitur
                </a>
                <a class="collapse-item" href="/admin/gallery-items">
                    Galeri Item
                </a>
                <a class="collapse-item" href="/admin/faqs">
                    FAQ
                </a>
                <a class="collapse-item" href="/admin/contact-info">
                    Kontak
                </a>
            </div>
        </div>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>