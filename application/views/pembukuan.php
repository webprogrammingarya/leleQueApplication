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
              <h5 class="card-title fw-semibold mb-4">Pembukuan</h5>

                <div id="btnTambah-responsive-pb">
                  <div class="text-end">
                    <a href="<?= base_url('Main/pembukuanM') ?>" class="mb-3 btn btn-primary">Tambah Catatan</a>
                  </div>    
                </div>

                <div id="paginationDataPembukuan">
                  <div class="paginationDataPembukuan d-flex justify-content-end"></div>
                </div>
                
                <div id="table-responsive">
                  <table class="table table-striped mb-3" id="dataPembukuan">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Aliran</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Total (Rp)</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th>
                          </tr>
                    </thead>
                    <tbody>
            
                      <?php if(empty($pembukuanData)) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia</td>
                        </tr>
                      <?php else : ?>
                        <?php foreach ($pembukuanData as $index => $pembukuan) : ?>
                            <?php
                              $offset = $this->uri->segment(3) ? $this->uri->segment(3) : 0; // Ambil segmen URL untuk nomor halaman
                              $number = $index + 1 + $offset;
                            ?>
                            <tr>
                                <td class="align-middle"><?= $number; ?></td>
                                <td class="align-middle"><?= $pembukuan["aliran"]; ?></td>
                                <td class="align-middle"><?= $pembukuan["kategori"]; ?></td>
                                <td class="align-middle">Rp<?= $pembukuan["total"]; ?></td>
                                <td class="align-middle"><?= $pembukuan["tanggal"]; ?></td>
                                <td class=""><a href="<?= base_url('Main/deleteDataPembukuan'); ?>?id=<?= $pembukuan['_id'] ?>" class="btn btn-danger" name="hapus">Hapus</a></td>
                                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                            </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
                
                <div id="card-responsive">
                  <?php if (!empty($pembukuanData)) : ?>
                    <?php foreach ($pembukuanData as $index => $pembukuan) : ?>
                      <div class="card <?= $pembukuan['aliran'] === 'Pemasukan' ? 'border border-success' : 'border border-danger'; ?>">
                        <div class="card-body">
                          <p class="text-end">
                            <a href="<?= base_url('Main/deleteDataPembukuan'); ?>?id=<?= $pembukuan['_id'] ?>" class="bg-danger text-white ps-2 pe-2 pt-1 pb-1 rounded-5">X</a>
                          </p>
                          <table>
                            <tr>
                              <th scope="col" class="pe-3">Aliran</th>
                              <td><?= $pembukuan["aliran"]; ?></td>
                            </tr>
                            <tr>
                              <th scope="col" class="pe-3">Kategori</th>
                              <td><?= $pembukuan["kategori"]; ?></td>
                            </tr>
                            <tr>
                              <th scope="col" class="pe-3">Total (Rp)</th>
                              <td>Rp<?= $pembukuan["total"]; ?></td>
                            </tr>
                            <tr>
                              <th scope="col" class="pe-3">Tanggal</th>
                              <td><?= $pembukuan["tanggal"]; ?></td>
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

       
                <select id="opsiCatat" class="form-select" aria-label="Default select example">
                  <option value="0" selected>Pilih opsi ...</option>
                  <option value="1">Pengeluaran</option>
                  <option value="2">Pemasukan</option>
                </select>

                
                <form action="<?= base_url('Main/savePembukuan'); ?>" method="post" id="formBerikan" class="mt-5">
                  <input type="hidden" name="aliran" class="form-control" value="Pengeluaran">
                  <label for="kategori" class="form-label">Kategori</label>
                  <div class="mb-3">
                      <select class="form-select" name="kategori" id="kategori">
                          <option value="Pembelian Benih Lele">Pembelian Benih Lele</option>
                          <option value="Peralatan dan Infrastruktur">Peralatan dan Infrastruktur</option>
                          <option value="Pakan dan Nutrisi">Pakan dan Nutrisi</option>
                          <option value="Tenaga Kerja">Tenaga Kerja</option>
                          <option value="Pengobatan dan Kesehatan Ikan">Pengobatan dan Kesehatan Ikan</option>
                          <option value="Pengelolaan Air">Pengelolaan Air</option>
                          <option value="Listrik dan Energi">Listrik dan Energi</option>
                          <option value="Biaya Transportasi">Biaya Transportasi</option>
                          <option value="Pajak dan Perizinan">Pajak dan Perizinan</option>
                          <option value="Pemeliharaan dan Perawatan">Pemeliharaan dan Perawatan</option>
                          <option value="Asuransi">Asuransi</option>
                          <option value="Biaya Lainnya">Biaya Lainnya</option>
                      </select>
                  </div>
                  <div class="mb-3">
                    <label for="totalPengeluaran" class="form-label">Total Pengeluaran</label>
                    <input type="number" name="total"  class="form-control" id="totalPengeluaran" placeholder="0">
                    <div id="totalPengeluaranHelp" class="form-text">Misal jika Rp100.000, ketik 100000</div>
                  </div>
                  <div class="mb-3" id="tambahBarang">
                      <label for="labelBarangDibeli" class="form-label">Barang Dibeli</label>
                      <br>
                      <a class="btn btn-outline-primary d-flex align-items-center gap-2"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                          <i class="ti ti-circle-plus fs-6"></i>
                          Tambah Barang
                      </a>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-striped" id="detailBarang">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Saat Ini / Satuan</th>
                                    <th scope="col">Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if(empty($barangData)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center">Data tidak tersedia</td>
                                </tr>
                              <?php else : ?>
                                <?php foreach ($barangData as $index => $barang) : ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= $barang["namaBarang"]; ?></td>
                                        <td><?= $barang["stokSaatIni"]; ?> / <?= $barang["satuan"]; ?></td>
                                        <td>
                                            <input type="checkbox" value="" id="flexCheckDefault">
                                        </td>
                                        <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                                    </tr>
                                <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tambahkan</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3" id="divBarangDitambahkan" style="display: none;">
                    <table class="table table-striped" id="tabelBarangDitambahkan">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Nama Barang</th>
                          <th scope="col">Jumlah</th>
                        </tr>
                      </thead>
                      <tbody id="bodyBarangDitambahkan">
                        <!-- Di sini akan ditampilkan barang yang ditambahkan -->
                      </tbody>
                    </table>
                  </div>
                  

                  <input type="hidden" name="barangDipilih" id="barangDipilih" value="">
                  
                  <div class="mb-3">
                    <label for="informasiOpsional" class="form-label">Informasi Opsional</label>
                    <textarea class="form-control" name="informasiOpsional" id="" cols="30" rows="10" placeholder="Catatan"></textarea>
                  </div>
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

                <form action="<?= base_url('Main/savePembukuan'); ?>" method="post" id="formTerima" class="mt-5">
                  <input type="hidden" name="aliran" class="form-control" value="Pemasukan">
                  <label for="kategori" class="form-label">Kategori</label>
                  <div class="mb-3">
                      <select class="form-select" name="kategori" id="kategori">
                        <option value="Penjualan Benih Lele">Penjualan Benih Lele</option>
                        <option value="Hasil Penjualan Ikan">Hasil Penjualan Ikan</option>
                        <option value="Pemasukan dari Layanan Jasa">Pemasukan dari Layanan Jasa</option>
                        <option value="Pemasukan dari Produk Sampingan">Pemasukan dari Produk Sampingan</option>
                        <option value="Pemasukan dari Kerjasama Bisnis">Pemasukan dari Kerjasama Bisnis</option>
                        <option value="Pemasukan dari Investasi">Pemasukan dari Investasi</option>
                        <option value="Pemasukan Lainnya">Pemasukan Lainnya</option>
                      </select>
                  </div>

                  <div class="mb-3">
                    <label for="totalPemasukan" class="form-label">Total Pemasukan</label>
                    <input type="number" name="total"  class="form-control" id="totalPemasukan" placeholder="0">
                    <div id="totalPemasukanHelp" class="form-text">Misal jika Rp100.000, ketik 100000</div>
                  </div>

                  <input type="hidden" name="barangDipilih" id="barangDipilih" value="">
                  
                  <div class="mb-3">
                    <label for="informasiOpsional" class="form-label">Informasi Opsional</label>
                    <textarea class="form-control" name="informasiOpsional" id="" cols="30" rows="10" placeholder="Catatan"></textarea>
                  </div>
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
        $('#opsiCatat').change(function() {
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

        // Daftar kategori yang memerlukan opsi "Tambah Barang"
        const categoriesWithAdditionalItem = [
            'Pembelian Benih Lele',
            'Peralatan dan Infrastruktur',
            'Pakan dan Nutrisi',
            'Pengobatan dan Kesehatan Ikan'
            // Tambahkan kategori lain yang memerlukan opsi "Tambah Barang" di sini jika ada
        ];

        // Handler saat opsi kategori dipilih
        $('#kategori').change(function() {
            const selectedOption = $(this).val();

            // Periksa apakah kategori yang dipilih memerlukan opsi "Tambah Barang"
            if (categoriesWithAdditionalItem.includes(selectedOption)) {
                $('#tambahBarang').show();
            } else {
                $('#tambahBarang').hide();
            }
        });

        var barangDipilih = []; // Variabel untuk menyimpan barang yang dipilih

        $('#detailBarang input[type="checkbox"]').change(function() {
          var namaBarang = $(this).closest('tr').find('td:nth-child(2)').text();
          var isChecked = $(this).is(':checked');

          if (isChecked) {
            if ($('#divBarangDitambahkan').is(':hidden')) {
              $('#divBarangDitambahkan').show();
            }

            var inputJumlah = '<input type="number" class="form-control jumlahBarang" style="width: 70px;" placeholder="0">';
            var newRow = $('<tr class="selected-item"></tr>').append('<td class="align-middle">' + ($('.selected-item').length + 1) + '</td>').append('<td class="align-middle">' + namaBarang + '</td>').append('<td>' + inputJumlah + '</td>');
            $('#bodyBarangDitambahkan').append(newRow);

            // Tambah data barang yang dipilih ke dalam array
            var barang = {
              namaBarang: namaBarang,
              jumlahBarang: ''
            };
            barangDipilih.push(barang);
          } else {
            $('#bodyBarangDitambahkan .selected-item').filter(function() {
              return $(this).find('td:nth-child(2)').text() === namaBarang;
            }).remove();

            // Hapus data barang yang dipilih dari array
            barangDipilih = barangDipilih.filter(function(barang) {
              return barang.namaBarang !== namaBarang;
            });

            if ($('#bodyBarangDitambahkan').is(':empty')) {
              $('#divBarangDitambahkan').hide();
            } else {
              // Update nomor urut setelah item dihapus
              $('#bodyBarangDitambahkan .selected-item').each(function(index) {
                $(this).find('td:first-child').text(index + 1);
              });
            }

            if ($('#bodyBarangDitambahkan .selected-item').length === 0) {
              // Jika tidak ada item yang dipilih, sembunyikan divBarangDitambahkan
              $('#divBarangDitambahkan').hide();
            }
          }
        });

        // Menangani submit form
        $('#formBerikan').submit(function(event) {
          // Loop melalui input jumlah barang dan tambahkan nilai ke dalam array barangDipilih
          $('.jumlahBarang').each(function(index) {
            barangDipilih[index].jumlahBarang = $(this).val();
          });

          // Mengubah array barangDipilih menjadi string JSON dan menambahkannya ke dalam form sebagai input tersembunyi
          $('<input>').attr({
            type: 'hidden',
            name: 'barangDipilih',
            value: JSON.stringify(barangDipilih)
          }).appendTo('#formBerikan');

          // Lanjutkan dengan pengiriman form
          return true;
        });

        var recordsDataPembukuan = 3; // Jumlah record per halaman untuk Data Pembukuan

        var dataPembukuanRows = $('#dataPembukuan tbody tr');

        // Fungsi untuk menampilkan halaman tertentu
        function displayDataPembukuan(start, end) {
            dataPembukuanRows.hide();
            dataPembukuanRows.slice(start, end).show();
        }

        // Inisialisasi pagination untuk Data Pembukuan
        var dataPembukuanTotalPages = Math.ceil(dataPembukuanRows.length / recordsDataPembukuan);
        $('.paginationDataPembukuan').append('<ul class="pagination"></ul>');
        for (var i = 1; i <= dataPembukuanTotalPages; i++) {
            $('.paginationDataPembukuan .pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        displayDataPembukuan(0, recordsDataPembukuan);

        $('.paginationDataPembukuan .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsDataPembukuan;
            var end = start + recordsDataPembukuan;
            displayDataPembukuan(start, end);
        });
      });
  </script>