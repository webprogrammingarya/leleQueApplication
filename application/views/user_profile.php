  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <?php require 'templates/main_logo.php'?>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <?php 
        require 'templates/nav.php';
        ?>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <?php require 'templates/main_nav_profile.php'?>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Profil</h5>  
              <form action="<?= base_url('Main/saveProfile'); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <img src="<?= base_url('assets'); ?>/images/profile/<?= (empty($userData["gambar"])) ? "user-1.jpg" : $userData["gambar"]; ?>" width="100px" height="100px" >
                    <input type="file" name="gambarProfile"> 
                </div>
                <fieldset disabled>
                    <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" value="<?= $userData["username"]; ?>">
                    </div>
                </fieldset>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $userData['nama']; ?>">
                </div>
                <div class="mb-3">
                    <label for="nomorHP" class="form-label">Nomor HP</label>
                    <input type="number" name="nomorHP" class="form-control" id="nomorHP" value="<?= $userData['nomorHP']; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $userData['email']; ?>">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggalLahir" class="form-control" id="tanggalLahir" value="<?= $userData['tanggalLahir']; ?>">
                </div>
                <div class="mb-3">
                  <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                  <div>
                      <input class="form-check-input me-2" type="radio" name="jenisKelamin" value="Pria" id="pria" checked>
                      <label for="pria" class="form-check-label">
                        Pria
                      </label>
                  </div>
                  <div>
                      <input class="form-check-input me-2" type="radio" name="jenisKelamin" value="Wanita" id="wanita" <?php echo ($userData["jenisKelamin"] === "Wanita") ? 'checked' : ''; ?>>
                      <label for="wanita" class="form-check-label">
                        Wanita
                      </label>
                  </div>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary mb-3">Submit</button>
              </form>
              <p class="text-end">Ingin <a href="" data-bs-toggle="modal" data-bs-target="#ubahPassword">ubah password?</a></p>
              <div class="modal fade" id="ubahPassword" tabindex="-1" aria-labelledby="ubahPasswordLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="ubahPasswordLabel">Ubah Password</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="formUbahPassword" action="<?= base_url('Main/validateChangePassword'); ?>" method="post">
                        <div class="mb-3">
                          <input type="password" name="passwordLama" class="form-control" placeholder="Masukkan password lama">
                        </div>
                        <div class="mb-1">
                          <input type="password" name="passwordBaru" class="form-control" placeholder="Masukkan password baru">
                        </div>
                        <small>
                            <i>
                                <p>Password minimal 8 karakter</p>
                            </i>
                        </small>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-secondary" form="formUbahPassword">Ubah Password</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/'); ?>/libs/jquery/dist/jquery.min.js"></script>
  
