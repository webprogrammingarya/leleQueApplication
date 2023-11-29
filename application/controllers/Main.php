<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

    public function index()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 
        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $totalPembukuanDataWaktu = $this->getDataTotalPembukuanByMonthYear();     
        $pembukuanData = $this->getDataPembukuan();
        
        if ($userData !== null) {
            $pembukuanData = $this->sortByDate($pembukuanData);
            $pembukuanData = array_slice($pembukuanData, 0, 5);
            $this->load->view('index', ['userData' => $userData, 'pembukuanData' => $pembukuanData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function userProfile() 
    {
        $this->load->view('templates/header');
        
        $userData = $this->getDataUserProfile();
        
        if ($userData !== null) {
            $this->load->view('user_profile', ['userData' => $userData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }
        
        $this->load->view('templates/main_script_user_profile');
        $this->load->view('templates/main_footer');
    }

    public function validateChangePassword() {
        $passwordVerificationUser = $this->input->post('passwordLama');
        $changePassword = $this->input->post('passwordBaru');
        $userData = $this->getDataUserProfile();

        if (empty($passwordVerificationUser) || empty($changePassword)) {
			echo "<script>
					alert('Data tidak boleh kosong / Wajib diisi!');
					window.location.href = '" . base_url('Main/userProfile') . "'; 
				</script>";
			return false;
		}

        if (strlen($changePassword) < 8) {
			echo "<script>
					alert('Panjang karakter password kurang dari 8!');
					window.location.href = '" . base_url('Main/userProfile') . "'; 
				</script>";
			return false;
		}
        
        if(password_verify($passwordVerificationUser, $userData['password'])) {
            $this->saveNewPassword($changePassword);
        } else {
            var_dump('salah');
        }
    }

    public function saveNewPassword($newPassword) {
        $userData = $this->getDataUserProfile();

        $email = $userData['email'];

		$cUrl = curl_init();

        $result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/putUserByEmail',
			CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'email' => $email,
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ))
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

        if($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                    alert('Password berhasil diubah!');
                    window.location.href = '" . base_url('Main/userProfile') . "';
                </script>";
        }
    }

    public function getDataUserProfile() 
    {
        $username = $this->session->userdata('username');
        $url = 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataUser?username=' . urlencode($username);
        $cUrl = curl_init();
    
        $result = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true
        );
    
        curl_setopt_array($cUrl, $result);
    
        $response = curl_exec($cUrl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $data = json_decode($response, true);
    
            foreach ($data as $userData) {
                if ($userData['username'] === $username) {
                    $newUserData = [
                        'username' => isset($userData['username']) ? $userData['username'] : '',
                        'password' => isset($userData['password']) ? $userData['password'] : '',
                        'nama' => isset($userData['nama']) ? $userData['nama'] : '',
                        'nomorHP' => isset($userData['nomorHP']) ? $userData['nomorHP'] : '',
                        'email' => isset($userData['email']) ? $userData['email'] : '',
                        'tanggalLahir' => isset($userData['tanggalLahir']) ? date('Y-m-d', strtotime($userData['tanggalLahir'])) : '',
                        'jenisKelamin' => isset($userData['jenisKelamin']) ? $userData['jenisKelamin'] : '',
                        'gambar' => isset($userData['gambar']) ? $userData['gambar'] : ''
                    ];
                    return $newUserData;
                }
            }
        }
        return null;
    }

    public function saveProfile()
    {
        $id = $this->session->userdata('id');
        $nama = htmlspecialchars($_POST['nama']);
        $nomorHP = htmlspecialchars($_POST['nomorHP']);
        $email = htmlspecialchars($_POST['email']);
        $tanggalLahir = htmlspecialchars($_POST['tanggalLahir']);
        $jenisKelamin = htmlspecialchars($_POST['jenisKelamin']);
        $gambarProfile = $this->upload();

        if(!$gambarProfile) {
            return false;
        }


        if (!is_numeric($nomorHP)) {
            echo "<script>
                alert('Nomor HP harus angka!');
                window.location.href = '" . base_url('Main/userProfile') . "';
            </script>";
            return false;
        }

        $cUrl = curl_init();

        $result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/putUserProfile',
			CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'id' => $id,
                'nama' => $nama,
                'nomorHP' => $nomorHP,
                'email' => $email,
                'tanggalLahir' => $tanggalLahir,
                'jenisKelamin' => $jenisKelamin,
                'gambar' => $gambarProfile
            ))
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

        if($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                alert('Simpan berhasil!');
                window.location.href = '" . base_url('Main/userProfile') . "';
            </script>";
        }
    }

    public function upload()
    {
        $namaFile = $_FILES["gambarProfile"]["name"];
        $ukuranFile = $_FILES["gambarProfile"]["size"];
        $error = $_FILES["gambarProfile"]["error"];
        $tmpName = $_FILES["gambarProfile"]["tmp_name"];

        // cek apakah tidak ada gambar yang diupload
        if ($error === 4) {
            $userData = $this->getDataUserProfile();
            $profilLama = $userData['gambar'];
            return $profilLama; 
        }

        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = ["jpg", "jpeg", "png"];
        $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
        $ekstensiGambar = strtolower($ekstensiGambar);
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Yang anda upload bukan gambar!');
                    window.location.href = '" . base_url('Main/userProfile') . "';
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 10000000) { // 10MB dalam bytes
            echo "<script>
                    alert('Ukuran gambar terlalu besar!');
                    window.location.href = '" . base_url('Main/userProfile') . "';
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama baru
        $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

        // Path penyimpanan file gambar
        $path = 'assets/images/profile/' . $namaFileBaru;

        // Lakukan pemindahan file dari temporary folder ke folder tujuan
        if (!move_uploaded_file($tmpName, $path)) {
            echo "<script>
                    alert('Gagal mengunggah gambar!');
                    window.location.href = '" . base_url('Main/userProfile') . "';
                </script>";
            return false;
        }

        return $namaFileBaru;
    }

    public function pembukuan()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 


        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $barangData = $this->getDataStok();
        $pembukuanData = $this->getDataPembukuan();
        
        if ($userData !== null) {
            $pembukuanData = $this->sortByDate($pembukuanData);
            $this->load->view('pembukuan', ['userData' => $userData, 'barangData' => $barangData, 'pembukuanData' => $pembukuanData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function pembukuanM()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 


        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $barangData = $this->getDataStok();
        $pembukuanData = $this->getDataPembukuan();
        
        if ($userData !== null) {
            $pembukuanData = $this->sortByDate($pembukuanData);
            $this->load->view('pembukuan_m', ['userData' => $userData, 'barangData' => $barangData, 'pembukuanData' => $pembukuanData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function getDataPembukuan()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $url = 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataPembukuan?idUser=' . urlencode($id);
        $cUrl = curl_init();
    
        $result = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true
        );
    
        curl_setopt_array($cUrl, $result);
    
        $response = curl_exec($cUrl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $data = json_decode($response, true);

            $totalPengeluaran = 0;
            $totalPemasukan = 0;
            
            $pembukuanArray = [];
            foreach ($data as $pembukuanData) {
                if ($pembukuanData['idUser'] === $id) {
                    $newPembukuanData = [
                        '_id' => isset($pembukuanData['_id']) ? $pembukuanData['_id'] : '',
                        'aliran' => isset($pembukuanData['aliran']) ? $pembukuanData['aliran'] : '',
                        'kategori' => isset($pembukuanData['kategori']) ? $pembukuanData['kategori'] : '',
                        'total' => isset($pembukuanData['total']) ? $pembukuanData['total'] : '',
                        'tanggal' => isset($pembukuanData['tanggal']) ? $pembukuanData['tanggal'] : '',
                        'kategori' => isset($pembukuanData['kategori']) ? $pembukuanData['kategori'] : '',
                        'informasiOpsional' => isset($pembukuanData['informasiOpsional']) ? $pembukuanData['informasiOpsional'] : '',
                    ];
                    $pembukuanArray[] = $newPembukuanData;
                }
            }
            return $pembukuanArray;
        }
        return null;
    }

    public function sortByDate($data) {
        usort($data, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        return $data;
    }
    
    public function getDataTotalPembukuanByMonthYear()
    {
        $pembukuanTotal = $this->getDataPembukuan();

        $totalByMonthYear = [];

        foreach ($pembukuanTotal as $data) {
            $bulanTahun = date('Y-m', strtotime($data['tanggal']));

            if (!array_key_exists($bulanTahun, $totalByMonthYear)) {
                $totalByMonthYear[$bulanTahun] = [
                    'total_pengeluaran' => 0,
                    'total_pemasukan' => 0
                ];
            }

            if ($data['aliran'] === "Pengeluaran") {
                $totalByMonthYear[$bulanTahun]['total_pengeluaran'] += isset($data['total']) ? $data['total'] : 0;
            } else {
                $totalByMonthYear[$bulanTahun]['total_pemasukan'] += isset($data['total']) ? $data['total'] : 0;
            }
        }

        return $totalByMonthYear;
    }

    public function getDataTotalUtangByMonthYear()
    {
        $utangTotal = $this->getDataUtang();

        $totalByMonthYear = [];

        foreach ($utangTotal as $data) {
            $bulanTahun = date('Y-m', strtotime($data['tanggal']));

            if (!array_key_exists($bulanTahun, $totalByMonthYear)) {
                $totalByMonthYear[$bulanTahun] = [
                    'total_utang_saya' => 0,
                    'total_utang_penerima' => 0
                ];
            }

            $totalByMonthYear[$bulanTahun]['total_utang_saya'] += isset($data['jumlahDiberikan']) ? $data['jumlahDiberikan'] : 0;
            $totalByMonthYear[$bulanTahun]['total_utang_penerima'] += isset($data['jumlahMemberikan']) ? $data['jumlahMemberikan'] : 0;
            
        }

        return $totalByMonthYear;
    }

    
    public function savePembukuan() 
    {
        $idUser = $this->session->userdata('id');
        $aliran = $this->input->post('aliran');
        $kategori = $this->input->post('kategori');
        $total = $this->input->post('total');
        $barangDipilihJSON = $this->input->post('barangDipilih');
        
        // Periksa jika barangDipilihJSON kosong atau tidak ada isinya
        if (empty($barangDipilihJSON)) {
            // Lakukan penanganan jika barangDipilih kosong
            // Misalnya, set barangDipilih ke array kosong
            $barangArray = [];
        } else {
            // Jika tidak kosong, lanjutkan proses normal
            $barangDipilih = json_decode($barangDipilihJSON, true);
            
            // Membuat array asosiatif untuk setiap nama barang dan jumlah barang
            $barangArray = [];
            foreach ($barangDipilih as $barang) {
                $namaBarang = $barang['namaBarang'];
                $jumlahBarang = intval($barang['jumlahBarang']);
                $barangArray[] = array(
                    'namaBarang' => $namaBarang,
                    'jumlahBarang' => $jumlahBarang
                );
            }
        }
        
        $informasiOpsional = $this->input->post('informasiOpsional');
        $tanggal = $this->input->post('tanggal');
        
        $cUrl = curl_init();
        
        $options = array(
            CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postPembukuan',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'idUser' => $idUser,
                'aliran' => $aliran,
                'kategori' => $kategori,
                'total' => $total,
                'barangDipilih' => json_encode($barangArray), // Mengubah $barangDipilih menjadi $barangArray yang telah dibentuk sebelumnya
                'informasiOpsional' => $informasiOpsional,
                'tanggal' => $tanggal,
            ))
        );
        
        curl_setopt_array($cUrl, $options);
        
        $response = curl_exec($cUrl);
        
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $stokSaatIni = $this->getDataStok();

            // Mengurangi jumlah barang yang baru ditambahkan dari stok saat ini
            foreach ($barangArray as $barang) {
                $namaBarang = $barang['namaBarang'];
                $jumlahBarang = $barang['jumlahBarang'];
        
                // Cari barang yang sesuai dalam stok saat ini dan kurangi jumlahnya
                foreach ($stokSaatIni as $stok) {
                    if ($stok['namaBarang'] === $namaBarang) {
                        $stok['stokSaatIni'] -= $jumlahBarang;
                        if($stok['stokSaatIni'] < 0) {
                            echo "<script>
                                    alert('Jumlah stok kurang!');
                                    window.location.href = '" . base_url('Main/pembukuan') . "';
                                </script>";
                            return false;
                        }
        
                        // Memanggil fungsi untuk mengupdate data stok untuk barang tertentu
                        $this->updateDataStok($stok['_id'], $stok['stokSaatIni']);
                        break; // Keluar dari loop setelah mengurangi stok
                    }
                }
            }

            echo "<script>
                alert('Simpan berhasil!');
                window.location.href = '" . base_url('Main/pembukuan') . "';
            </script>";
        }
    }

    public function updateDataStok($id, $stokSaatIni) 
    {        
        $cUrl = curl_init();

        $result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/putStok',
			CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'id' => $id,
                'stokSaatIni' => $stokSaatIni,
            ))
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

	}

    public function utang()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 
        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $utangData = $this->getDataUtang();

        
        if ($userData !== null) {
            $this->load->view('utang', ['userData' => $userData, 'utangData' => $utangData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function utangM()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 
        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $utangData = $this->getDataUtang();

        
        if ($userData !== null) {
            $this->load->view('utang_m', ['userData' => $userData, 'utangData' => $utangData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    


    public function saveUtang()
    {
        $idUser = $this->session->userdata('id');
        
        if (isset($_POST["simpanBerikan"])) {
            $utangSiapa = $_POST["utangSiapa"];
            $namaPenerima = $_POST["namaPenerima"];
            $jumlahMemberikan = $_POST["jumlahMemberikan"];
            $informasiOpsional = $_POST["informasiOpsional"];
            $tanggal = $_POST["tanggal"];
            $namaPemberi = '';
            $jumlahDiberikan = 0;
        
            if (empty($namaPenerima) && empty($jumlahMemberikan) && empty($informasiOpsional)) {
                echo "<script>
                        alert('Mohon isikan setidaknya satu perubahan data!');
                        window.location.href = '" . base_url('Main/utang') . "';
                      </script>";
                return false;
            }
            // Lakukan proses simpan data untuk 'Memberikan'
        } elseif (isset($_POST["simpanTerima"])) {
            $utangSiapa = $_POST["utangSiapa"];
            $namaPemberi = $_POST["namaPemberi"];
            $jumlahDiberikan = $_POST["jumlahDiberikan"];
            $informasiOpsional = $_POST["informasiOpsional"];
            $tanggal = $_POST["tanggal"];
            $namaPenerima = '';
            $jumlahMemberikan = 0;
        
            if (empty($namaPemberi) && empty($jumlahDiberikan) && empty($informasiOpsional)) {
                echo "<script>
                        alert('Mohon isikan setidaknya satu perubahan data!');
                        window.location.href = '" . base_url('Main/utang') . "';
                      </script>";
                return false;
            }
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat mengirimkan formulir!');
                    window.location.href = '" . base_url('Main/utang') . "';
                  </script>";
            return false;
        }

        $cUrl = curl_init();

        $options = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postUtang',
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query(array(
				'idUser' => $idUser,
				'utangSiapa' => $utangSiapa,
				'namaPenerima' => $namaPenerima,
				'jumlahMemberikan' => $jumlahMemberikan,
				'informasiOpsional' => $informasiOpsional,
				'tanggal' => $tanggal,
				'namaPemberi' => $namaPemberi,
				'jumlahDiberikan' => $jumlahDiberikan,
			))
		);

		curl_setopt_array($cUrl, $options);

		$response = curl_exec($cUrl);

        if ($response === false) {
			echo 'Error: ' . curl_error($cUrl);
		} else {
            echo "<script>
                alert('Simpan berhasil!');
                window.location.href = '" . base_url('Main/utang') . "';
            </script>";
        }
    }

    public function laporanKeuangan()
    {
        $id = $this->session->userdata('id');

        
        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $pembukuanData = $this->getDataPembukuan();
        $totalPembukuanDataWaktu = $this->getDataTotalPembukuanByMonthYear();        
        $totalUtangDataWaktu = $this->getDataTotalUtangByMonthYear();
        $utangData = $this->getDataUtang();

        $tahunArray = []; // Membuat array kosong untuk menampung tahun-tahun unik
        $tahunArrayUt = []; // Membuat array kosong untuk menampung tahun-tahun unik

        // Iterasi melalui $totalPembukuanDataWaktu untuk mengumpulkan tahun-tahun unik
        foreach ($totalPembukuanDataWaktu as $tanggal => $data) {
            $tahun = substr($tanggal, 0, 4); // Mengambil 4 karakter pertama sebagai tahun
            if (!in_array($tahun, $tahunArray)) {
                $tahunArray[] = $tahun; // Menambahkan tahun ke dalam array jika belum ada
            }
        }

        foreach ($totalUtangDataWaktu as $tanggal => $data) {
            $tahun = substr($tanggal, 0, 4); // Mengambil 4 karakter pertama sebagai tahun
            if (!in_array($tahun, $tahunArrayUt)) {
                $tahunArrayUt[] = $tahun; // Menambahkan tahun ke dalam array jika belum ada
            }
        }

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $bulanUt = $this->input->post('bulanUt');
        $tahunUt = $this->input->post('tahunUt');

        // Cek apakah bulan dan tahun sudah dipilih
        if ($bulan && $tahun) {
            // Ubah format bulan dan tahun sesuai dengan data Anda
            $filterDate = sprintf("%04d-%02d", $tahun, $bulan);

            // Filter data berdasarkan bulan dan tahun yang dipilih
            $filteredData = [];
            foreach ($totalPembukuanDataWaktu as $tanggal => $data) {
                if (strpos($tanggal, $filterDate) !== false) {
                    $filteredData[$tanggal] = $data;
                }
            }

            // Gunakan data yang telah difilter
            $totalPembukuanDataWaktu = $filteredData;
        }

        // Cek apakah bulan dan tahun sudah dipilih
        if ($bulanUt && $tahunUt) {
            // Ubah format bulan dan tahun sesuai dengan data Anda
            $filterDate = sprintf("%04d-%02d", $tahunUt, $bulanUt);

            // Filter data berdasarkan bulan dan tahun yang dipilih
            $filteredData = [];
            foreach ($totalUtangDataWaktu as $tanggal => $data) {
                if (strpos($tanggal, $filterDate) !== false) {
                    $filteredData[$tanggal] = $data;
                }
            }

            // Gunakan data yang telah difilter
            $totalUtangDataWaktu = $filteredData;
        }

        ksort($totalPembukuanDataWaktu);
        ksort($totalUtangDataWaktu);

        if ($userData !== null) {
            $this->load->view('laporan_keuangan', ['userData' => $userData, 'totalPembukuanDataWaktu' => $totalPembukuanDataWaktu, 'totalUtangDataWaktu' => $totalUtangDataWaktu, 'tahunArray' => $tahunArray, 'tahunArrayUt' => $tahunArrayUt,'pembukuanData' => $pembukuanData, 'utangData' => $utangData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }
   


    public function getDataUtang()
    {        
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        }

        $url = 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataUtang?idUser=' . urlencode($id);
        $cUrl = curl_init();
    
        $result = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true
        );
    
        curl_setopt_array($cUrl, $result);
    
        $response = curl_exec($cUrl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $data = json_decode($response, true);

            $utangArray = [];
            foreach ($data as $utangData) {
                if ($utangData['idUser'] === $id) {
                    $newUtangData = [
                        'utangSiapa' => isset($utangData['utangSiapa']) ? $utangData['utangSiapa'] : '',
                        'namaPenerima' => isset($utangData['namaPenerima']) ? $utangData['namaPenerima'] : '',
                        'namaPemberi' => isset($utangData['namaPemberi']) ? $utangData['namaPemberi'] : '',
                        'jumlahDiberikan' => isset($utangData['jumlahDiberikan']) ? $utangData['jumlahDiberikan'] : '',
                        'jumlahMemberikan' => isset($utangData['jumlahMemberikan']) ? $utangData['jumlahMemberikan'] : '',
                        'informasiOpsional' => isset($utangData['informasiOpsional']) ? $utangData['informasiOpsional'] : '',
                        'tanggal' => isset($utangData['tanggal']) ? $utangData['tanggal'] : '',
                    ];
                    $utangArray[] = $newUtangData;
                }
            }
            return $utangArray;
        }
        return null;
    }

    public function stok()
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        $barangData = $this->getDataStok();
        $satuanData = $this->getDataSatuan();
        
        if ($userData !== null) {
            $this->load->view('stok', ['userData' => $userData, 'barangData' => $barangData, 'satuanData' => $satuanData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function saveStok()
    {
        
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $namaBarang = htmlspecialchars($_POST["namaBarang"]); 
        $hargaBarang = htmlspecialchars($_POST["hargaBarang"]); 
        $satuan = htmlspecialchars($_POST["satuan_hidden"]); 
        $stokSaatIni = htmlspecialchars($_POST["stokSaatIni"]); 
        $stokMinimum = htmlspecialchars($_POST["stokMinimum"]); 
        $deskripsi = htmlspecialchars($_POST["deskripsi"]); 

        if($namaBarang === '') {
            echo "<script>
                alert('Data gagal disimpan, nama barang wajib diisi!');
                window.location.href = '" . base_url('Main/stok') . "';
            </script>";
            return false;
        }

        $cUrl = curl_init();

        $result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postStokBarang',
			CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'idUser' => $id,
                'namaBarang' => $namaBarang,
                'hargaBarang' => $hargaBarang,
                'satuan' => $satuan,
                'stokSaatIni' => $stokSaatIni,
                'stokMinimum' => $stokMinimum,
                'deskripsi' => $deskripsi
            ))
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

        if($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                alert('Simpan berhasil!');
                window.location.href = '" . base_url('Main/stok') . "';
            </script>";
        }
    }

    public function getDataStok()
    {        
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        }

        $url = 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataStok?idUser=' . urlencode($id);
        $cUrl = curl_init();
    
        $result = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true
        );
    
        curl_setopt_array($cUrl, $result);
    
        $response = curl_exec($cUrl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $data = json_decode($response, true);

            $barangArray = [];
            foreach ($data as $barangData) {
                if ($barangData['idUser'] === $id) {
                    $newBarangData = [
                        '_id' => isset($barangData['_id']) ? $barangData['_id'] : '',
                        'namaBarang' => isset($barangData['namaBarang']) ? $barangData['namaBarang'] : '',
                        'satuan' => isset($barangData['satuan']) ? $barangData['satuan'] : '',
                        'stokSaatIni' => isset($barangData['stokSaatIni']) ? $barangData['stokSaatIni'] : '',
                    ];
                    $barangArray[] = $newBarangData;
                }
            }
            return $barangArray;
        }
        return null;
    }

    public function getDataSatuan() 
    {
        
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $url = 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataSatuan?idUser=' . urlencode($id);
        $cUrl = curl_init();
    
        $result = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true
        );
    
        curl_setopt_array($cUrl, $result);
    
        $response = curl_exec($cUrl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            $data = json_decode($response, true);

            $satuanArray = [];
            foreach ($data as $satuanData) {
                if ($satuanData['idUser'] === $id) {
                    $newSatuanData = [
                        '_id' => isset($satuanData['_id']) ? $satuanData['_id'] : '',           
                        'satuan' => isset($satuanData['satuan']) ? $satuanData['satuan'] : '',           
                    ];
                    $satuanArray[] = $newSatuanData;
                }
            }
            return $satuanArray;
        }
        return null;
    }

    public function saveSatuan()
    {        
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $idUser = $this->session->userdata('id');
        $satuan = $this->input->post('satuan');
        
        $cUrl = curl_init();
        
        $options = array(
            CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postSatuan',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'idUser' => $idUser,
                'satuan' => $satuan,
            ))
        );
        
        curl_setopt_array($cUrl, $options);
        
        $response = curl_exec($cUrl);
        
        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                alert('Simpan berhasil!');
                window.location.href = '" . base_url('Main/stok') . "';
            </script>";
        }
    }

    public function komunitas() 
    {
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        
        if ($userData !== null) {
            $this->load->view('komunitas', ['userData' => $userData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function deleteDataSatuan() 
    {
        $id = $this->input->get('id');

        $cUrl = curl_init();

        $options = array(
            CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/deleteSatuan?id='.$id,
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        );

        curl_setopt_array($cUrl, $options);

        $response = curl_exec($cUrl);

        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                    alert('Data berhasil dihapus!');
                    window.location.href = '" . base_url('Main/stok') . "';
                </script>";
        }
    }

    public function deleteDataStok() 
    {
        $id = $this->input->get('id');

        $cUrl = curl_init();

        $options = array(
            CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/deleteStokBarang?id='.$id,
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        );

        curl_setopt_array($cUrl, $options);

        $response = curl_exec($cUrl);

        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                    alert('Data berhasil dihapus!');
                    window.location.href = '" . base_url('Main/stok') . "';
                </script>";
        }
    }
    
    public function deleteDataPembukuan() 
    {
        $id = $this->input->get('id');

        $cUrl = curl_init();

        $options = array(
            CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/deletePembukuan?id='.$id,
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        );

        curl_setopt_array($cUrl, $options);

        $response = curl_exec($cUrl);

        if ($response === false) {
            echo 'Error: ' . curl_error($cUrl);
        } else {
            echo "<script>
                    alert('Data berhasil dihapus!');
                    window.location.href = '" . base_url('Main/pembukuan') . "';
                </script>";
        }
    }

    public function bantuan()
    {   
        $id = $this->session->userdata('id');

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 

        if (!isset($id)) {
            header("Location: " . base_url('Auth'));
            exit(); 
        } 
        $this->load->view('templates/header');

        $userData = $this->getDataUserProfile();
        
        if ($userData !== null) {
            $this->load->view('bantuan', ['userData' => $userData]);
        } else {
            $this->session->sess_destroy();
            header("Location: " . base_url('Auth'));
            exit();
        }

        $this->load->view('templates/main_footer');
    }

    public function keluar()
    {
        $this->session->sess_destroy();
        header("Location: " . base_url('Auth'));
    }
}