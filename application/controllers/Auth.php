<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	public function index()
	{
		$id = $this->session->userdata('id');

        if (isset($id)) {
            header("Location: " . base_url('Main'));
            exit(); 
        } 
		$this->load->view('templates/header');
		$this->load->view('auth/login');
		$this->load->view('templates/auth_footer');
	}

	public function registrasi()
	{
		$id = $this->session->userdata('id');

        if (isset($id)) {
            header("Location: " . base_url('Main'));
            exit(); 
        } 
		$this->load->view('templates/header');
		$this->load->view('auth/registrasi');
		$this->load->view('templates/auth_footer');
	}

	public function saveRegistrasi()
	{
		$id = $this->session->userdata('id');

        if (isset($id)) {
            header("Location: " . base_url('Main'));
            exit(); 
        } 

		$cUrl = curl_init();

		$email = htmlspecialchars($_POST["email"]);
		$username = htmlspecialchars(strtolower(stripslashes($_POST["username"])));
		$password = htmlspecialchars($_POST["password"]);
		$password2 = htmlspecialchars($_POST["password2"]);


		if (empty($_POST["email"]) === '' || empty($_POST["username"]) === '' || empty($_POST["password"]) || empty($_POST["password2"])) {
			echo "<script>
					alert('Data tidak boleh kosong / Wajib diisi!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				</script>";
			return false;
		}

		// Validasi karakter khusus dalam nama pengguna
		if (!preg_match("/^[a-zA-Z0-9_\-][a-zA-Z0-9_\-\.]*$/", $username)) {
			echo "<script>
					alert('Username hanya boleh berisi huruf, angka, garis bawah, dan tanda titik, tetapi tidak boleh di awal!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				  </script>";
			return false;
		}


		$result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataUser',
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_RETURNTRANSFER => true
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

		if ($response === false) {
			echo 'Error: ' . curl_error($cUrl);
		} else {
			$data = json_decode($response, true);

			$usernameExists = false;
			foreach ($data as $userData) {
				if (isset($userData['username']) && $userData['username'] === $username) {
					$usernameExists = true;
					break;
				}
			}

			$emailExists = false;
			foreach ($data as $userData) {
				if (isset($userData['email']) && $userData['email'] === $email) {
					$emailExists = true;
					break;
				}
			}

			if ($usernameExists) {
				echo "<script>
					alert('Username sudah ada!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				</script>";
				return false;
			}

			if ($emailExists) {
				echo "<script>
					alert('Email sudah ada!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				</script>";
				return false;
			}
		}

		if (strlen($password) < 8) {
			echo "<script>
					alert('Panjang karakter password kurang dari 8!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				</script>";
			return false;
		}

		if ($password !== $password2) {
			echo "<script>
					alert('Konfirmasi password tidak sesuai!');
					window.location.href = '" . base_url('Auth/registrasi') . "'; 
				</script>";
			return false;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);


		$options = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/postNewUser',
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => http_build_query(array(
				'username' => $username,
				'password' => $password,
				'nama' => '',
				'nomorHP' => '',
				'email' => $email,
				'tanggalLahir' => '',
				'jenisKelamin' => '',
				'gambar' => ''
			))
		);

		curl_setopt_array($cUrl, $options);

		$response = curl_exec($cUrl);

		echo "<script>
				alert('Registrasi berhasil!');
				window.location.href = '" . base_url('Auth/index') . "';
			</script>";
	}

	public function signIn()
	{
		$id = $this->session->userdata('id');

        if (isset($id)) {
            header("Location: " . base_url('Main'));
            exit(); 
        } 
		
		$cUrl = curl_init();

		$username = $_POST["username"];
		$password = $_POST["password"];

		$options = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataUser',
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_RETURNTRANSFER => true,
		);

		curl_setopt_array($cUrl, $options);

		$response = curl_exec($cUrl);

		if ($response === false) {
			echo 'Error: ' . curl_error($cUrl);
		} else {
			$data = json_decode($response, true);

			$usernamePasswordExists = false;
			$roleAdmin = false;
			foreach ($data as $userData) {
				if ($userData['username'] === $username) {
					if (password_verify($password, $userData["password"])) {
						$usernamePasswordExists = true;
						$this->session->set_userdata('id', $userData["_id"]);
						$this->session->set_userdata('username', $userData["username"]);
					}
					break;
				}
			}

			if ($usernamePasswordExists) {
				echo "<script>
					alert('Berhasil login!'); 
					window.location.href = '" . base_url('Main') . "'; 
				</script>";
			} else {
				echo "<script>
					alert('Gagal login!'); 
					window.location.href = '" . base_url('Auth') . "'; 
				</script>";
			}
		}
	}

	public function lupaPassword()
	{
		$id = $this->session->userdata('id');

        if (isset($id)) {
            header("Location: " . base_url('Main'));
            exit(); 
        }

		$this->load->view('templates/header');
		$this->load->view('auth/lupa_password');
		$this->load->view('templates/auth_footer');
	}

	public function sendResetPassword() {
		$email = $_POST["email"];
		$cUrl = curl_init();
		
		$options = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/getAllDataUser',
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_RETURNTRANSFER => true,
		);

		curl_setopt_array($cUrl, $options);

		$response = curl_exec($cUrl);

		if ($response === false) {
			echo 'Error: ' . curl_error($cUrl);
		} else {
			$data = json_decode($response, true);
			$emailExists = false;
			foreach ($data as $userData) {
				if(isset($userData['email']) && $userData['email'] === $email) {
					$emailExists = true;
				}
			}

			if ($emailExists) {
				$this->load->library('email');

				$this->email->from('adminleleque@chat.com', 'Admin LeleQue');
				$this->email->to($this->input->post('email'));
				$password = rand();
				$this->email->subject('Lupa Password');
				$this->email->message('Password baru Anda adalah <b>.'.$password.'.</b>. Silahkan aktifkan password baru Anda dengan mengklik link <a href="'.base_url('Auth/active/'.urlencode(base64_encode($this->input->post('email'))).'/'.$password).'">di sini</a>');

				$this->email->send();

				redirect('Auth');
			} else {
				echo "<script>
					alert('Email tidak ditemukan!'); 
					window.location.href = '" . base_url('Auth/lupaPassword') . "'; 
				</script>";
			}
		}
	}

	public function active($email, $password) 
	{
		$email = base64_decode(urldecode($email));
		$cUrl = curl_init();

        $result = array(
			CURLOPT_URL => 'https://asia-south1.gcp.data.mongodb-api.com/app/leleque-web-ifjzs/endpoint/putUserByEmail',
			CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ))
		);

		curl_setopt_array($cUrl, $result);

		$response = curl_exec($cUrl);

		redirect('Auth');
	}
}
