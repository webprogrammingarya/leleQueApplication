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
              <h5 class="card-title fw-semibold mb-4">Bantuan</h5>
              <div class="card">
                <div class="card-body">
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui ipsum nihil recusandae inventore quis praesentium repellendus neque sunt ipsam corporis, fuga esse nulla reiciendis nemo alias similique modi illo. At, atque, dicta aspernatur voluptate aliquid rerum asperiores similique excepturi vero libero amet, nulla velit! Reprehenderit enim quia laboriosam atque dolorum accusantium dicta eligendi magni, eos amet dignissimos assumenda esse est autem incidunt doloribus placeat dolorem optio quidem tempora harum sapiente? Iusto, cumque dolore hic vero dolorem, laborum qui eum sunt eaque reiciendis excepturi. Beatae totam error laudantium reiciendis aut. Omnis deserunt officia ut, placeat quam neque quaerat voluptate, rerum maiores sequi qui voluptatum provident culpa aut distinctio iste eveniet quia eum fugiat? Minus modi doloremque qui. Voluptates ut nostrum doloribus quasi deserunt quae harum, impedit fugiat ad, optio consequuntur architecto! Rem, iusto! Fugiat magni laudantium error quas temporibus est eum dolorum vero eveniet amet consectetur tempore beatae voluptatum id, architecto veniam ipsum? Voluptatem laborum cupiditate saepe, labore necessitatibus qui nam error deleniti animi beatae minima impedit dolor similique, quaerat cumque culpa harum rem repellat blanditiis alias? Laudantium delectus possimus, vel asperiores ipsum aut deserunt quidem qui impedit aperiam totam a dolorem odio, veritatis nisi atque neque! Aut explicabo ipsum tempora.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/'); ?>/libs/jquery/dist/jquery.min.js"></script>
  <!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> -->
  <!-- <script>
    var mymap = L.map('mapid').setView([-6.589728, 106.806518], 13); // Koordinat yang baru

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    var marker = L.marker([-6.589728, 106.806518]).addTo(mymap); // Menggunakan koordinat baru
    marker.bindPopup("<b>Hola!</b><br>Ini adalah lokasi perusahaan.").openPopup();
  </script> -->