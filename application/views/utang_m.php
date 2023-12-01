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
          <?php require 'templates/main_nav_profile.php'; ?>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Utang</h5>

              <select id="opsiCatatUtang" class="form-select" aria-label="Default select example">
                <option selected>Pilih opsi ...</option>
                <option value="1">Berikan</option>
                <option value="2">Terima</option>
              </select>
              <form action="<?= base_url('Main/saveUtang'); ?>" method="post" id="formBerikan" class="mt-5">
                <div class="mb-3">
                  <label for="namaPenerima" class="form-label">Memberikan ke</label>
                  <input type="text" name="namaPenerima" id="namaPenerima" class="form-control" placeholder="Nama Penerima">
                </div>
                <div class="mb-3">
                  <label for="jumlahMemberikan" class="form-label">Memberikan Sejumlah</label>
                  <input type="number" name="jumlahMemberikan" id="jumlahMemberikan" class="form-control" placeholder="0">
                  <div id="jumlahMemberikanHelp" class="form-text">Misal jika Rp100.000, ketik 100000</div>
                </div>
                <div class="mb-3">
                  <label for="informasiOpsional" class="form-label">Informasi Opsional</label>
                  <textarea class="form-control" name="informasiOpsional" id="" cols="30" rows="10" placeholder="Catatan"></textarea>
                </div>
                <input type="hidden" name="utangSiapa" id="utangPelanggan" class="form-control" value="Utang Pelanggan">
                <input type="hidden" name="namaPemberi" id="namaPemberi" class="form-control">
                <input type="hidden" name="jumlahDiberikan" id="jumlahDiberikan" class="form-control" placeholder="0">
                <div class="mb-3">
                  <?php
                    date_default_timezone_set('Asia/Jakarta'); 
                    $tanggal_default = date('Y-m-d');
                  ?>
                  <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="mb-3">
                  <button type="submit" name="simpanBerikan" class="btn btn-primary w-100">Simpan</button>
                </div>
              </form>

              
              <form action="<?= base_url('Main/saveUtang'); ?>" method="post" id="formTerima" class="mt-5">
                <div class="mb-3">
                  <label for="namaPemberi" class="form-label">Menerima dari</label>
                  <input type="text" name="namaPemberi" id="namaPemberi" class="form-control" placeholder="Nama Pemberi">
                </div>
                <div class="mb-3">
                  <label for="jumlahDiberikan" class="form-label">Menerima Sejumlah</label>
                  <input type="number" name="jumlahDiberikan" id="jumlahDiberikan" class="form-control" placeholder="0">
                  <div id="jumlahMemberikanHelp" class="form-text">Misal jika Rp100.000, ketik 100000</div>
                </div>
                <div class="mb-3">
                  <label for="informasiOpsional" class="form-label">Informasi Opsional</label>
                  <textarea class="form-control" name="informasiOpsional" id="" cols="30" rows="10" placeholder="Catatan"></textarea>
                </div>
                <input type="hidden" name="utangSiapa" id="utangSaya" class="form-control" value="Utang Saya">
                <input type="hidden" name="namaPenerima" id="namaPenerima" class="form-control">
                <input type="hidden" name="jumlahMemberikan" id="jumlahMemberikan" class="form-control" placeholder="0">
                <div class="mb-3">
                  <?php
                    date_default_timezone_set('Asia/Jakarta'); 
                    $tanggal_default = date('Y-m-d');
                  ?>
                  <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="mb-3">
                  <button type="submit" name="simpanTerima" class="btn btn-primary w-100">Simpan</button>
                </div>
              </form>        
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/'); ?>/libs/jquery/dist/jquery.min.js"></script>
  <script>
      $(document).ready(function() {
        $('#formBerikan').hide();
        $('#formTerima').hide();
        $('#opsiCatatUtang').change(function() {
            if ($(this).val() == "1") {
                $('#formBerikan').show();
                $('#formTerima').hide();
            } else if ($(this).val() == "2") {
                $('#formTerima').show();
                $('#formBerikan').hide();
            } else {
                $('#formTerima').hide();
                $('#formBerikan').hide();
            }
        });
        
        
        var recordsUtangPelanggan = 3; // Jumlah record per halaman untuk Utang Pelanggan
        var recordsUtangSaya = 3; // Jumlah record per halaman untuk Utang Saya

        var utangPelangganRows = $('#dataUtangPelanggan tbody tr');
        var utangSayaRows = $('#dataUtangSaya tbody tr');

        // Fungsi untuk menampilkan halaman tertentu
        function displayUtangPelanggan(start, end) {
            utangPelangganRows.hide();
            utangPelangganRows.slice(start, end).show();
        }

        function displayUtangSaya(start, end) {
            utangSayaRows.hide();
            utangSayaRows.slice(start, end).show();
        }

        // Inisialisasi pagination untuk Utang Pelanggan
        var utangPelangganTotalPages = Math.ceil(utangPelangganRows.length / recordsUtangPelanggan);
        $('.paginationUtangPelanggan').append('<ul class="pagination"></ul>');
        for (var i = 1; i <= utangPelangganTotalPages; i++) {
            $('.paginationUtangPelanggan .pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        displayUtangPelanggan(0, recordsUtangPelanggan);

        $('.paginationUtangPelanggan .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsUtangPelanggan;
            var end = start + recordsUtangPelanggan;
            displayUtangPelanggan(start, end);
        });

        // Inisialisasi pagination untuk Utang Saya
        var utangSayaTotalPages = Math.ceil(utangSayaRows.length / recordsUtangSaya);
        $('.paginationUtangSaya').append('<ul class="pagination"></ul>');
        for (var j = 1; j <= utangSayaTotalPages; j++) {
            $('.paginationUtangSaya .pagination').append('<li class="page-item"><a class="page-link" href="#">' + j + '</a></li>');
        }

        displayUtangSaya(0, recordsUtangSaya);

        $('.paginationUtangSaya .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsUtangSaya;
            var end = start + recordsUtangSaya;
            displayUtangSaya(start, end);
        });


      });
  </script>