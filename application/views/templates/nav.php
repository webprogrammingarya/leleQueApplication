<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
    <ul id="sidebarnav">

    <!-- start menu home -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Home</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-layout-dashboard"></i>
        </span>
        <span class="hide-menu">Dasbor</span>
        </a>
    </li>
    <!-- end menu home -->
    


    <!-- start menu arus keuangan -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">ARUS KEUANGAN</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/pembukuan'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-exchange"></i>
        </span>
        <span class="hide-menu">Pembukuan</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/utang'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-moneybag"></i>
        </span>
        <span class="hide-menu">Utang</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/laporanKeuangan'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-report-money"></i>
        </span>
        <span class="hide-menu">Laporan Keuangan</span>
        </a>
    </li>
    <!-- end menu arus keuangan -->



    <!--start menu manajemen stok  -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">MANAJEMEN STOK</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/stok'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-packages"></i>
        </span>
        <span class="hide-menu">Stok Barang</span>
        </a>
    </li>
    <!-- end menu manajemen stok -->



    <!--start menu manajemen stok  -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">KOMUNITAS</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/komunitas'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-message"></i>
        </span>
        <span class="hide-menu">Komunitas Diskusi</span>
        </a>
    </li>
    <!-- end menu manajemen stok -->



    <!-- start menu pengaturan -->
    <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">PENGATURAN</span>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/userProfile'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-user"></i>
        </span>
        <span class="hide-menu">Profil</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/bantuan'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-help"></i>
        </span>
        <span class="hide-menu">Bantuan</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('Main/keluar'); ?>" aria-expanded="false">
        <span>
            <i class="ti ti-door-exit"></i>
        </span>
        <span class="hide-menu">Logout</span>
        </a>
    </li>
    <!-- end menu pengaturan -->
    </ul>
</nav>