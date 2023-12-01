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
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Transaksi Pembukuan</h5>
                  </div>
                  <div>
                    <select class="form-select" id="tahunSelect">
                      <option value="" disabled selected>Pilih Tahun</option>
                    </select>
                  </div>
                </div>
                <canvas id="chart" ></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-4">Pengeluaran Terakhir</h5>
                  <ul class="timeline-widget mb-0 position-relative">
                    <?php
                      if (empty($pembukuanData) || !array_filter($pembukuanData, function($pembukuan) {
                          return $pembukuan["aliran"] === "Pengeluaran";
                      })) : ?>
                    <?php else: ?>
                      <?php foreach($pembukuanData as $pembukuan) : ?>
                        <?php if($pembukuan["aliran"] === "Pengeluaran") : ?>
                          <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-time text-dark flex-shrink-0 text-end"><?= $pembukuan["tanggal"] ?></div>
                            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                              <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                              <span class="timeline-badge-border d-block flex-shrink-0"></span>
                            </div>
                            <div class="timeline-desc fs-3 text-dark mt-n1">
                              <b><p><?= $pembukuan["kategori"]; ?></p></b>
                              <p><?= $pembukuan["informasiOpsional"]; ?></p>
                            </div>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-4">Pemasukan Terakhir</h5>
                  <ul class="timeline-widget mb-0 position-relative">
                    <?php
                      if (empty($pembukuanData) || !array_filter($pembukuanData, function($pembukuan) {
                          return $pembukuan["aliran"] === "Pemasukan";
                      })) : ?>
                    <?php else: ?>
                      <?php foreach($pembukuanData as $pembukuan) : ?>
                        <?php if($pembukuan["aliran"] === "Pemasukan") : ?>
                          <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-time text-dark flex-shrink-0 text-end"><?= $pembukuan["tanggal"] ?></div>
                            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                              <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                              <span class="timeline-badge-border d-block flex-shrink-0"></span>
                            </div>
                            <div class="timeline-desc fs-3 text-dark mt-n1">
                              <b><p><?= $pembukuan["kategori"]; ?></p></b>
                              <p><?= $pembukuan["informasiOpsional"]; ?></p>
                            </div>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>         
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/'); ?>/libs/jquery/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('chart');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
          label: 'Transaksi Bulanan (Rp)',
          data: [], // Data will be populated dynamically
          backgroundColor: [], // Colors will be set based on data positivity/negativity
          borderWidth: 1
        }]
      },
      options: {
        responsive: true, 
        aspectRatio: 1, 
        scales: {
          y: {
            beginAtZero: true,
            
          }
        },
      }
    });

    function extractYearFromDate(dateString) {
      const date = new Date(dateString);
      return date.getFullYear();
    }
    

    function updateChart(year, userId) {
      $.ajax({
        url: `https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataPembukuan`,
        type: 'GET',
        success: function(res) {
          const monthlyData = Array(12).fill(0); // Initialize array to store monthly data

          res.forEach(entry => {
            const entryYear = extractYearFromDate(entry.tanggal);
            const entryMonth = new Date(entry.tanggal).getMonth();

            if (entryYear === year && entry.aliran === 'Pemasukan' && entry.idUser === userId) {
              monthlyData[entryMonth] += entry.total;
            } else if (entryYear === year && entry.aliran === 'Pengeluaran' && entry.idUser === userId) {
              monthlyData[entryMonth] -= entry.total;
            }
          });

          const dataset = chart.data.datasets[0];
          dataset.data = monthlyData;

          // Set background color based on positivity/negativity of data
          dataset.backgroundColor = monthlyData.map(value => value >= 0 ? 'rgb(40, 167, 69)' : 'rgb(220, 53, 69)');

          chart.update();
        },
        error: function(err) {
          console.log(err);
        }
      });
    }

    $.ajax({
      url: 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataPembukuan',
      type: 'GET',
      success: function(res) {
        const userId = '<?= $this->session->userdata('id'); ?>'; // Ganti dengan ID pengguna yang ingin Anda gunakan
        
        // Filter data berdasarkan ID pengguna
        const userData = res.filter(entry => entry.idUser === userId);

        // Mendapatkan tahun-tahun unik yang terkait dengan pengguna tersebut
        const uniqueYears = {};
        userData.forEach(entry => {
          const year = new Date(entry.tanggal).getFullYear();
          uniqueYears[year] = year;
        });

        const uniqueYearList = Object.values(uniqueYears);
        const selectElement = document.getElementById('tahunSelect');

        uniqueYearList.forEach(year => {
          const option = document.createElement('option');
          option.value = year;
          option.textContent = year;
          selectElement.appendChild(option);
        });

        // Initial chart update with the first year in the list
        if (uniqueYearList.length > 0) {
          updateChart(uniqueYearList[0], userId); // Menambahkan userId sebagai parameter
        }
      },
      error: function(err) {
        console.log(err);
      }
    });

    // Event listener for year selection change
    $('#tahunSelect').on('change', function() {
      const selectedYear = parseInt($(this).val());
      const selectedUserId = '<?= $this->session->userdata('id'); ?>'; 
      updateChart(selectedYear, selectedUserId);
    });
  </script>