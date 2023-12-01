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
          <?php require 'templates/main_nav_profile.php' ?>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4" id="title">Detail Barang</h5> 
                <div id="btnTambah-responsive-st">
                  <div class="text-end">
                    <a href="javascript:void(0);" class="mb-3 btn btn-primary" id="tambahBarang">Tambah Barang</a>
                  </div>    
                </div>

                <div id="table-responsive">
                  <table class="table table-striped" id="detailBarang">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Stok Saat Ini / Satuan</th>
                            <th scope="col">Aksi</th>
                          </tr>
                    </thead>
                    <tbody>
                      
                      <?php if (empty($barangData)) : ?>
                          <tr>
                              <td colspan="4" class="text-center">Data tidak tersedia</td>
                          </tr>
                      <?php else : ?>
                          <?php foreach ($barangData as $index => $barang) : ?>
                              <tr>
                                  <td class="align-middle"><?= $index + 1; ?></td>
                                  <td class="align-middle"><?= $barang["namaBarang"]; ?></td>
                                  <td class="align-middle"><?= $barang["stokSaatIni"]; ?> / <?= $barang["satuan"]; ?></td>
                                  <td class=""><a href="<?= base_url('Main/deleteDataStok'); ?>?id=<?= $barang['_id'] ?>" class="btn btn-danger" name="hapus">Hapus</a></td>
                              </tr>
                          <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>

                <div id="card-responsive">
                  <?php if (!empty($barangData)) : ?>
                    <?php foreach ($barangData as $index => $barang) : ?>
                      <div class="card border border-dark">
                        <div class="card-body">
                          <p class="text-end">
                            <a href="<?= base_url('Main/deleteDataStok'); ?>?id=<?= $barang['_id'] ?>" class="bg-danger text-white ps-2 pe-2 pt-1 pb-1 rounded-5">X</a>
                          </p>
                          <table>
                            <tr>
                              <th scope="col" class="pe-3">Nama Barang</th>
                              <td><?= $barang["namaBarang"]; ?></td>
                            </tr>
                            <tr>
                              <th scope="col" class="pe-3">Stok Saat Ini / Satuan</th>
                              <td><?= $barang["stokSaatIni"]; ?> / <?= $barang["satuan"]; ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <div class="card">
                      <div class="card-body">
                        <p class="text-center">Tidak ada data yang tersedia</p>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>

                <div id="paginationDetailBarang">
                  <div class="paginationDetailBarang d-flex justify-content-center"></div>
                </div>


                <form action="<?= base_url('Main/saveStok'); ?>" method="post" id="formTambahBarang">
                  <div class="mb-3">
                      <label for="namaBarang" class="form-label">Nama Barang</label>
                      <input type="text" class="form-control" name="namaBarang" id="namaBarang" placeholder="Nama Barang" required>
                  </div>
                  <div class="mb-3">
                      <label for="hargaBarang" class="form-label">Harga Barang</label>
                      <input type="number" class="form-control" name="hargaBarang" id="hargaBarang" placeholder="Harga Barang">
                  </div>
                  <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <a class="btn btn-outline-primary d-flex align-items-center gap-2"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="ti ti-circle-plus fs-6"></i>
                        Tambah Satuan
                    </a>
                  </div>

                  <div class="mb-3" id="divSatuanDitambahkan" style="display: none;">
                    <input type="text" name="satuan" class="form-control" value="" disabled>
                    <input type="hidden" name="satuan_hidden" id="satuan_hidden">
                  </div>
                      
                  <div class="mb-3">
                      <label for="stokSaatIni" class="form-label">Stok Saat Ini</label>
                      <input type="number" name="stokSaatIni" id="stokSaatIni" class="form-control" placeholder="Stok Saat Ini">
                  </div>
                  <div class="mb-3">
                      <label for="stokMinimum" class="form-label">Stok Minimum</label>
                      <input type="number" class="form-control" name="stokMinimum" id="stokMinimum" placeholder="Stok Minimum">
                  </div>
                  <div class="mb-3">
                      <label for="deskripsi" class="form-label">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" placeholder="Deskripsi"></textarea>
                  </div>
                  <div class="mb-3">
                    <button type="submit" name="simpanBarang" class="btn btn-primary w-100" form=formTambahBarang>Simpan</button>
                  </div>
                </form>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Satuan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                      <p class="mb-3">
                        <a href="javascript:void(0);" class="tambahSatuan">Tambah satuan</a>
                      </p>
                      <table class="table table-striped" id="detailBarang">
                            <thead>
                                <tr>
                                  <th scope="col" class="text-center">No.</th>
                                  <th scope="col">Satuan</th>
                                  <th scope="col" class="text-center">Pilih</th>
                                  <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if (empty($satuanData)) : ?>
                                  <tr>
                                      <td colspan="4" class="text-center">Data tidak tersedia</td>
                                  </tr>
                              <?php else : ?>
                                  <?php foreach ($satuanData as $index => $satuan) : ?>
                                      <tr>
                                          <td class="text-center align-middle"><?= $index + 1; ?></td>
                                          <td class="align-middle"><?= $satuan["satuan"]; ?></td>
                                          <td class="text-center align-middle"><input type="radio" name="pilihSatuan" value="" id="flexCheckDefault"></td>
                                          <td class="text-center"><a href="<?= base_url('Main/deleteDataSatuan'); ?>?id=<?= $satuan['_id'] ?>" class="btn btn-danger">Hapus</a></td>
                                          <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                                      </tr>
                                  <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        
                        <form action="<?= base_url('Main/saveSatuan'); ?>" method="post" id="formTambahSatuan">
                          <div class="mb-3">
                            <input type="text" name="satuan" class="form-control" placeholder="Masukkan satuan">
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnTambahClose" data-bs-dismiss="modal">Tambahkan</button>
                        <button type="submit" class="btn btn-success btnTambahSatuan" data-bs-dismiss="modal" form="formTambahSatuan">Tambah Satuan</button>
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
  <script>

    $(document).ready(function(){
        $('#formTambahBarang').hide();        
        $('#tambahBarang').click(function() {
            $('#detailBarang').toggle();
            $('#title').text("Tambah Barang");
            $('#formTambahBarang').toggle();
            $('#simpanTambah').toggle();
            $('#card-responsive').toggleClass('d-none');
            $('.paginationDetailBarang').toggleClass('d-flex d-none');
        })

        $('.btnTambahSatuan').hide();
        $('#formTambahSatuan').hide();
        $('.tambahSatuan').click(function() {
          $('#detailSatuan').toggle();
          $('.btnTambahClose').toggle();
          $('.btnTambahSatuan').toggle();
          $('#formTambahSatuan').toggle();
        })   

        $('input[name="pilihSatuan"]').on('change', function() {
          if ($(this).is(':checked')) {
            var selectedSatuan = $(this).closest('tr').find('td:eq(1)').text();
            
            // Simpan nilai satuan di input tersembunyi
            $('#satuan_hidden').val(selectedSatuan);
            
            // Set nilai satuan ke input pada form utama
            $('#divSatuanDitambahkan input[name="satuan"]').val(selectedSatuan).prop('disabled', true);
            
            // Tampilkan div yang menampung input "satuan" di form utama
            $('#divSatuanDitambahkan').show();
          }
        });

        var recordsDetailBarang = 3; // Jumlah record per halaman untuk Detail Barang

        var detailBarangRows = $('#detailBarang tbody tr');

        // Fungsi untuk menampilkan halaman tertentu
        function displayDetailBarang(start, end) {
            detailBarangRows.hide();
            detailBarangRows.slice(start, end).show();
        }

        // Inisialisasi pagination untuk Detail Barang
        var detailBarangTotalPages = Math.ceil(detailBarangRows.length / recordsDetailBarang);
        $('.paginationDetailBarang').append('<ul class="pagination"></ul>');
        for (var i = 1; i <= detailBarangTotalPages; i++) {
            $('.paginationDetailBarang .pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        displayDetailBarang(0, recordsDetailBarang);

        $('.paginationDetailBarang .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsDetailBarang;
            var end = start + recordsDetailBarang;
            displayDetailBarang(start, end);
        });

    });
  </script>