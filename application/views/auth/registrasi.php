    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="<?= base_url('Auth'); ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="<?= base_url('assets'); ?>/images/logos/leleque-logo.svg" width="180" alt="">
                                </a>
                                <p class="text-center">Manajemen Keuangan Ikan Lele</p>
                                <form action="<?= base_url('Auth/saveRegistrasi'); ?>" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control mb-1" id="email" aria-describedby="textHelp" placeholder="Masukkan email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control mb-1" id="username" aria-describedby="textHelp" placeholder="Masukkan username" required>
                                        <small>
                                            <i>
                                                <p>Username hanya boleh berisi huruf, angka, garis bawah, dan tanda titik (tidak boleh di awal)</p>
                                            </i>
                                        </small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group mb-1">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                            <span class="input-group-text show-password" data-target="password">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        <small>
                                            <i>
                                                <p>Password minimal 8 karakter</p>
                                            </i>
                                        </small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password2" class="form-label">Konfirmasi Password</label>
                                        <div class="input-group mb-1">
                                            <input type="password" name="password2" class="form-control" id="password2" placeholder="Konfirmasi password" required>
                                            <span class="input-group-text show-password" data-target="password2">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        <small>
                                            <i>
                                                <p>Password minimal 8 karakter</p>
                                            </i>
                                        </small>
                                    </div>
                                    <button type="submit" name="signUp" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="<?= base_url('Auth'); ?>">Masuk</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.show-password').click(function() {
                const targetId = $(this).data('target');
                const passwordInput = $('#' + targetId);
                const iconShowPassword = $(this).find('i');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    iconShowPassword.removeClass('ti-eye-off').addClass('ti-eye');
                } else {
                    passwordInput.attr('type', 'password');
                    iconShowPassword.removeClass('ti-eye').addClass('ti-eye-off');
                }
            });
        });
    </script>
</body>

</html>