<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="<?= base_url('assets'); ?>/images/profile/<?php echo (empty($userData["gambar"])) ? "user-1.jpg" : $userData["gambar"]; ?>" alt="" width="35" height="35" class="rounded-circle">
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
            <a href="<?= base_url('Main/userProfile'); ?>" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">Profil Saya</p>
            </a>
            <a href="<?= base_url('Main/bantuan'); ?>" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-help fs-6"></i>
                <p class="mb-0 fs-3">Bantuan</p>
            </a>
            <a href="<?= base_url('Main/keluar'); ?>" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
            </div>
        </div>
        </li>
    </ul>
</div>