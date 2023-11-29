<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="<?= base_url('assets/'); ?>/images/logos/leleque-logo.svg" width="180" alt="">
                            </a>
                            <p class="text-center">Your Social Campaigns</p>
                            <form action="<?= base_url('Auth/sendResetPassword'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Masukkan alamat email" required>
                                </div>
                                <button type="submit" name="resetPassword" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Reset Password</button>
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <a class="text-primary fw-bold ms-2" href="<?= base_url('Auth'); ?>">Kembali ke halaman login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>