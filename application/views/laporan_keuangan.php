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
              <h5 class="card-title fw-semibold mb-4">Laporan Keuangan</h5>
              <select id="jenisLaporan" class="form-select" aria-label="Default select example">
                <option value="" selected>Pilih opsi ...</option>
                <option value="1">Transaksi Pembukuan</option>
                <option value="2">Utang</option>
              </select>

              <form action="<?= base_url('Main/laporanKeuangan'); ?>" method="post" class="mt-3" id="formSearchMonthYear">
                <div class="row align-items-end">
                  <div class="col-md-5">
                    <label class="form-label" for="bulan">Pilih Bulan:</label>
                    <select  class="form-select" name="bulan" id="bulan">
                      <?php for($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label" for="tahun">Pilih Tahun:</label>
                    <select class="form-select" name="tahun" id="tahun">
                        <?php foreach ($tahunArray as $tahun): ?>
                            <option value="<?= $tahun ?>"><?= $tahun ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-2 col-12">
                    <input type="submit" name="filter" value="Filter" class="btn btn-success w-100">
                  </div>
                </div>
              </form>

              <form action="<?= base_url('Main/laporanKeuangan'); ?>" method="post" class="mt-3" id="formSearchMonthYearUt">
                <div class="row align-items-end">
                  <div class="col-md-5">
                    <label class="form-label" for="bulanUt">Pilih Bulan:</label>
                    <select  class="form-select" name="bulanUt" id="bulanUt">
                      <?php for($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label" for="tahunUt">Pilih Tahun:</label>
                    <select class="form-select" name="tahunUt" id="tahunUt">
                        <?php foreach ($tahunArrayUt as $tahun): ?>
                            <option value="<?= $tahun ?>"><?= $tahun ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-2 col-12">
                    <input type="submit" name="filter" value="Filter" class="btn btn-success w-100">
                  </div>
                </div>
              </form>
        

              
              <table class="table table-striped" id="tableTransaksiPembukuan">
                <thead>
                    <tr>
                      <th scope="col">Pengeluaran</th>
                      <th scope="col">Pendapatan</th>
                      <th scope="col">Bulan/Tahun</th>
                      <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(empty($totalPembukuanDataWaktu)) : ?>
                    <tr>
                      <td colspan="4" class="text-center">Data tidak tersedia</td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($totalPembukuanDataWaktu as $tanggal => $data) : ?>
                        <tr>
                            <td class="align-middle"><?= $data['total_pengeluaran'] ?></td>
                            <td class="align-middle"><?= $data['total_pemasukan'] ?></td>
                            <td class="align-middle"><?= $tanggal ?></td>
                            <td>
                                <a href="#" class="btn btn-warning detailBtn" 
                                  data-bs-toggle="modal" data-bs-target="#detailTransaksiPembukuan" 
                                  data-tanggal="<?= $tanggal ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>

              <div class="paginationTableTransaksiPembukuan d-none"></div>


              <!-- Modal -->
              <div class="modal fade" id="detailTransaksiPembukuan" tabindex="-1" aria-labelledby="detailTransaksiPembukuanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="detailTransaksiPembukuanLabel">Detail Transaksi</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">  
                      <table class="table table-striped mb-3" id="dataPembukuan">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Aliran</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Total (Rp)</th>
                                <th scope="col">Tanggal</th>
                              </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-primary" id="printData">Cetak</button>
                    </div>
                  </div>
                </div>
              </div>

              <table class="table table-striped" id="tableUtang">
                <thead>
                    <tr>
                      <th scope="col">Utang Saya</th>
                      <th scope="col">Utang Pelanggan</th>
                      <th scope="col">Bulan / Tanggal</th>
                      <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(empty($totalUtangDataWaktu)) : ?>
                    <tr>
                      <td colspan="4" class="text-center">Data tidak tersedia</td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($totalUtangDataWaktu as $tanggal => $dataUt) : ?>
                        <tr>
                            <td class="align-middle"><?= $dataUt['total_utang_saya'] ?></td>
                            <td class="align-middle"><?= $dataUt['total_utang_penerima'] ?></td>
                            <td class="align-middle"><?= $tanggal ?></td>
                            <td><a href="#" class="btn btn-warning detailUtBtn" 
                                  data-bs-toggle="modal" data-bs-target="#detailUtang" 
                                  data-tanggal="<?= $tanggal ?>">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>

              <div class="paginationTableUtang d-none"></div>

              <!-- Modal -->
              <div class="modal fade" id="detailUtang" tabindex="-1" aria-labelledby="detailUtangLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="detailUtangLabel">Detail Utang</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-striped mb-3" id="dataUtangPelanggan">
                        <h6>Utang Pelanggan</h6>
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Jumlah (Rp)</th>
                                <th scope="col">informasiOpsional</th>
                                <th scope="col">Tanggal</th>
                              </tr>
                        </thead>
                        <tbody>
              
                        </tbody>
                      </table>
                      <table class="table table-striped mb-3" id="dataUtangSaya">
                        <h6>Utang Saya</h6>
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Pemberi</th>
                                <th scope="col">Jumlah (Rp)</th>
                                <th scope="col">informasiOpsional</th>
                                <th scope="col">Tanggal</th>
                              </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-primary" id="printDataUt">Cetak</button>
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
      $(document).ready(function() {
        $('#tableUtang').hide();
        $('#tableTransaksiPembukuan').hide();
        $('#formSearchMonthYear').hide();
        $('#formSearchMonthYearUt').hide();
        $('.pagination-links').hide();
        
        $('#jenisLaporan').change(function() {
          var selectedVal = $(this).val();

          // Semua tabel disembunyikan terlebih dahulu
          $('#tableTransaksiPembukuan, #tableUtang').hide();

          // Semua pagination disembunyikan
          $('.paginationTableTransaksiPembukuan, .paginationTableUtang').removeClass('d-flex').addClass('d-none');

          // Semua form pencarian disembunyikan
          $('#formSearchMonthYear, #formSearchMonthYearUt').hide();

          if (selectedVal === "1") {
              $('#tableTransaksiPembukuan').show();
              $('.paginationTableTransaksiPembukuan').addClass('d-flex justify-content-center').removeClass('d-none');
              $('#formSearchMonthYear').show();
          } else if (selectedVal === "2") {
              $('#tableUtang').show();
              $('.paginationTableUtang').addClass('d-flex justify-content-center').removeClass('d-none');
              $('#formSearchMonthYearUt').show();
          }

          // Tampilkan form pencarian hanya jika bukan "Pilih"
          if (selectedVal !== "") {
              $('.pagination-links').show();
          } else {
              $('.pagination-links').hide();
          }
      });


        $('.detailBtn').on('click', function() {
          var tanggal = $(this).data('tanggal');
          $('#detailTransaksiPembukuanLabel').text('Detail Transaksi - ' + tanggal);
          
          var filteredData = <?php echo json_encode($pembukuanData); ?>;
          var filteredRows = '';
          
          // Variabel untuk nomor urutan yang tetap
          var rowNumber = 1;

          filteredData.forEach(function(pembukuan) {
              if (pembukuan.tanggal.includes(tanggal)) {
                  filteredRows += '<tr>' +
                      '<td>' + rowNumber + '</td>' +
                      '<td>' + pembukuan.aliran + '</td>' +
                      '<td>' + pembukuan.kategori + '</td>' +
                      '<td>Rp' + pembukuan.total + '</td>' +
                      '<td>' + pembukuan.tanggal + '</td>' +
                      '</tr>';
                  
                  // Increment nomor urutan
                  rowNumber++;
              }
          });

          $('#dataPembukuan tbody').html(filteredRows);
        });

        $('.detailUtBtn').on('click', function() {
          var tanggal = $(this).data('tanggal');
          $('#detailUtangLabel').text('Detail Utang - ' + tanggal);
          
          var filteredData = <?php echo json_encode($utangData); ?>;
          var filteredRowsUtPelanggan = '';
          var filteredRowsUtSaya = '';
          
          // Variabel untuk nomor urutan yang tetap
          var rowNumber = 1;
          var newRowNumber = 1;

          filteredData.forEach(function(utang) {
            if(utang.utangSiapa === 'Utang Pelanggan') {
              if (utang.tanggal.includes(tanggal)) {
                filteredRowsUtPelanggan += '<tr>' +
                      '<td>' + rowNumber + '</td>' +
                      '<td>' + utang.namaPenerima + '</td>' +
                      '<td>' + utang.jumlahMemberikan + '</td>' +
                      '<td>' + utang.informasiOpsional + '</td>' +
                      '<td>' + utang.tanggal + '</td>' +
                      '</tr>';
                  
                  // Increment nomor urutan
                  rowNumber++;
              } 
            } else {
              if (utang.tanggal.includes(tanggal)) {
                filteredRowsUtSaya += '<tr>' +
                      '<td>' + newRowNumber + '</td>' +
                      '<td>' + utang.namaPemberi + '</td>' +
                      '<td>' + utang.jumlahDiberikan + '</td>' +
                      '<td>' + utang.informasiOpsional + '</td>' +
                      '<td>' + utang.tanggal + '</td>' +
                      '</tr>';
                  
                  // Increment nomor urutan
                  newRowNumber++;
              }
            }
          });

          // Mengatur kondisi jika data tidak tersedia
          if (filteredRowsUtPelanggan === '') {
              filteredRowsUtPelanggan = '<tr><td class="text-center" colspan="5">Data tidak tersedia</td></tr>';
          }
          if (filteredRowsUtSaya === '') {
              filteredRowsUtSaya = '<tr><td class="text-center" colspan="5">Data tidak tersedia</td></tr>';
          }

          $('#dataUtangPelanggan tbody').html(filteredRowsUtPelanggan);
          $('#dataUtangSaya tbody').html(filteredRowsUtSaya);
        });

        $('#printData').on('click', function() {
          var selectedMonth = ''; // Variabel untuk menyimpan nama bulan yang dipilih
          var selectedYear = ''; // Variabel untuk menyimpan tahun yang dipilih

          // Mendapatkan nama bulan dan tahun dari detail transaksi yang dipilih
          var tanggal = $('#dataPembukuan tbody tr:first-child td:last-child').text(); // Mengambil tanggal dari baris pertama tabel
          if (tanggal !== '') {
            var dateParts = tanggal.split('-'); // Misal, tanggal dalam format 'YYYY-MM-DD'
            var year = dateParts[0];
            var month = dateParts[1];
            var monthNames = [
              'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            selectedMonth = monthNames[parseInt(month) - 1]; // Mendapatkan nama bulan dari angka bulan
            selectedYear = year;
          }

          // Menambahkan teks dengan bulan dan tahun yang dipilih ke judul modal
          var additionalText = '';
          if (selectedMonth !== '' && selectedYear !== '') {
            additionalText = `<h2 class="mt-3 mb-3 text-center">Laporan Pembukuan Keuangan Ikan Lele </br> Bulan ${selectedMonth} Tahun ${selectedYear}</h2>`;
          }

          // Menyimpan konten tabel di dalam variabel
          var printContents = document.getElementById('dataPembukuan').outerHTML;

          // Menambahkan teks di atas konten tabel
          printContents = additionalText + printContents;

          // Menyimpan konten asli dari halaman
          var originalContents = document.body.innerHTML;

          // Menampilkan teks dan tabel untuk dicetak
          document.body.innerHTML = printContents;

          // Memanggil fungsi print
          window.print();

          // Mengembalikan konten asli dari halaman setelah pencetakan selesai
          document.body.innerHTML = originalContents;
        });

        $('#printDataUt').on('click', function() {
          var selectedMonth = ''; // Variabel untuk menyimpan nama bulan yang dipilih
          var selectedYear = ''; // Variabel untuk menyimpan tahun yang dipilih

          // Mendapatkan tanggal dari baris pertama tabel dataUtangPelanggan
          var tanggal = $('#dataUtangPelanggan tbody tr:first-child td:last-child').text(); 
          if (tanggal !== '') {
            var dateParts = tanggal.split('-'); // Misal, tanggal dalam format 'YYYY-MM-DD'
            var year = dateParts[0];
            var month = dateParts[1];
            var monthNames = [
              'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            selectedMonth = monthNames[parseInt(month) - 1]; // Mendapatkan nama bulan dari angka bulan
            selectedYear = year;
          }

          // Menambahkan teks dengan bulan dan tahun yang dipilih ke judul modal
          var additionalText = '';
          if (selectedMonth !== '' && selectedYear !== '') {
            additionalText = `<h2 class="mt-3 mb-3 text-center">Detail Utang </br> Bulan ${selectedMonth} Tahun ${selectedYear}</h2>`;
          }
          // Menyimpan konten tabel dari dataUtangPelanggan dan dataUtangSaya
          var printContents = `
            ${additionalText}
            <h6>Utang Pelanggan</h6>
            ${document.getElementById('dataUtangPelanggan').outerHTML}
            <h6>Utang Saya</h6>
            ${document.getElementById('dataUtangSaya').outerHTML}
          `;

          var originalContents = document.body.innerHTML;

          // Menampilkan teks dan tabel untuk dicetak
          document.body.innerHTML = printContents;

          // Memanggil fungsi print
          window.print();

          // Mengembalikan konten asli dari halaman setelah pencetakan selesai
          document.body.innerHTML = originalContents;
        });





        var recordsTableUtang = 3; // Jumlah record per halaman untuk Table Utang

        var tableUtangRows = $('#tableUtang tbody tr');

        // Fungsi untuk menampilkan halaman tertentu
        function displayTableUtang(start, end) {
            tableUtangRows.hide();
            tableUtangRows.slice(start, end).show();
        }

        // Inisialisasi pagination untuk Table Utang
        var tableUtangTotalPages = Math.ceil(tableUtangRows.length / recordsTableUtang);
        $('.paginationTableUtang').append('<ul class="pagination"></ul>');
        for (var i = 1; i <= tableUtangTotalPages; i++) {
            $('.paginationTableUtang .pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        displayTableUtang(0, recordsTableUtang);

        $('.paginationTableUtang .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsTableUtang;
            var end = start + recordsTableUtang;
            displayTableUtang(start, end);
        });



        var recordsTableTransaksiPembukuan = 3; // Jumlah record per halaman untuk Table Transaksi Pembukuan

        var tableTransaksiPembukuanRows = $('#tableTransaksiPembukuan tbody tr');

        // Fungsi untuk menampilkan halaman tertentu
        function displayTableTransaksiPembukuan(start, end) {
            tableTransaksiPembukuanRows.hide();
            tableTransaksiPembukuanRows.slice(start, end).show();
        }

        // Inisialisasi pagination untuk Table Transaksi Pembukuan
        var tableTransaksiPembukuanTotalPages = Math.ceil(tableTransaksiPembukuanRows.length / recordsTableTransaksiPembukuan);
        $('.paginationTableTransaksiPembukuan').append('<ul class="pagination"></ul>');
        for (var i = 1; i <= tableTransaksiPembukuanTotalPages; i++) {
            $('.paginationTableTransaksiPembukuan .pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
        }

        displayTableTransaksiPembukuan(0, recordsTableTransaksiPembukuan);

        $('.paginationTableTransaksiPembukuan .pagination li').on('click', function() {
            var pageNum = $(this).text();
            var start = (pageNum - 1) * recordsTableTransaksiPembukuan;
            var end = start + recordsTableTransaksiPembukuan;
            displayTableTransaksiPembukuan(start, end);
        });



      });
  </script>