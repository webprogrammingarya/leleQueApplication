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
              <h5 class="card-title fw-semibold mb-4 ">Komunitas Diskusi</h5>  
              <div id="list-chats">
                  
              </div>
              <div class="mt-3 text-end">
                <form id="form-send">
                  <div class="row g-0 align-items-center">
                      <div class="col-md-11">
                          <div class="chat-container">
                              <textarea class="form-control" rows="1" id="chat" placeholder="Ketik Pesan" required></textarea>
                          </div>
                      </div>
                      <div class="col-md-1 col-12 mt-3 mt-sm-0">
                          <button type="submit" class="btn btn-success w-100">Kirim</button>
                      </div>
                  </div>
                </form>
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
        // Mengatur tinggi textarea sesuai dengan kontennya
        $('#chat').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (Math.min(this.scrollHeight, 200)) + 'px';
        });

        function currentDate() {
            var date = new Date();

            return date.toUTCString();
        }

        $('#form-send').submit(function () {
            pengirim = '<?= $userData["username"]; ?>';
            event.preventDefault(); // Menghentikan perilaku default pengiriman formulir
            $.ajax({
                url: 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postObrolan',
                type: 'POST',
                data: {
                    pengirim: pengirim,
                    waktu: currentDate(),
                    obrolan: $('#chat').val(),
                },
                success: function (res) {
                    load_chat();
                },
                error: function (err) {
                    console.log(err);
                }
            });
            $('#chat').val('');
            return false;
        })
        

        function load_chat() {
            $.ajax({
                url: 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataObrolan',
                type: 'GET',   
                beforeSend: function() {
                    $('#list-chats').
                    html(`
                        <div class="card">
                            <div class="card-body">
                                Loading...
                            </div>
                        </div>`
                    );
                },
                success: function(res) {
                    var view = '';
                    var currentUser = '<?= $userData["username"]; ?>'; // Mendapatkan username pengguna saat ini

                    res.forEach(data => {
                        if (data.pengirim === currentUser) {
                            // Pesan yang dikirim oleh pengguna saat ini
                            view += `
                                <div class="row justify-content-end">
                                    <div class="card mb-3 col-md-6" style="background-color: #DFF0D8;">
                                        <div class="card-body">
                                            <h5 class="card-title">saya</h5>
                                            <p class="text-dark">${data.obrolan}</p>
                                            <div class="text-end"><small>${data.waktu}</small></div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        } else {
                            // Pesan dari pengirim lain
                            view += `
                                <div class="row">
                                    <div class="card mb-3 col-md-6" style="background-color: #FFFFFF;">
                                        <div class="card-body">
                                            <h5 class="card-title">${data.pengirim}</h5>
                                            <p>${data.obrolan}</p>
                                            <div class="text-end"><small>${data.waktu}</small></div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        }
                    });

                    $('#list-chats').html(view);
                    $('#list-chats').scrollTop($('#list-chats')[0].scrollHeight); 
                    $('html, body').scrollTop($('html, body')[0].scrollHeight); 
                },
                error: function(err) {
                    console.log(err);
                    $('#list-chats').
                    html(`
                        <div class="card">
                            <div class="card-body">
                                Fetch Error...
                                <div class="text-end text-muted">${currentDate()}</div>
                            </div>
                        </div>
                        `);
                }

            });
        }
        load_chat();

        });

  </script>