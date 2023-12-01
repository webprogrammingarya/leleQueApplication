<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="<?= base_url('Auth'); ?>" class="text-nowrap logo-img text-center d-block py-3 w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="<?= base_url('assets/'); ?>/images/logos/leleque-logo.svg" width="180" alt="">
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">LeleQue?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><b>LeleQue</b> adalah sebuah aplikasi yang dirancang untuk memudahkan Anda dalam mengatur keuangan usaha ikan lele.</p>
                                    <p>Dalam aplikasi ini tersedia fitur untuk mencatat utang, pengeluaran dan pemasukan, manajemen stok barang, laporan keuangan, serta forum untuk diskusi.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                                </div>
                            </div>
                            </div>

                            <p class="text-center">Manajemen Keuangan Ikan Lele</p>
                            <form action="<?= base_url('Auth/signIn'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Masukkan username" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                </div>
                                <button type="submit" name="signIn" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a class="text-primary fw-bold ms-2 text-center" href="<?= base_url('Auth/lupaPassword'); ?>">Lupa Password?</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                                    <a class="text-primary fw-bold ms-2" href="<?= base_url('Auth/registrasi'); ?>">Buat Akun</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>