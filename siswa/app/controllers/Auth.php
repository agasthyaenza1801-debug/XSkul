<?php

class Auth extends Controller {
    public function index() {
        if (isset($_SESSION['siswa'])) {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $this->template('auth/header', ['title' => 'Login Siswa']);
        $this->view('auth/login');
        $this->template('auth/footer');
    }

    public function login() {
        $nis      = trim($_POST['nis'] ?? '');
        $password = $_POST['password'] ?? '';

        $siswaModel = $this->model('Siswa_model');
        $siswa      = $siswaModel->findByNis($nis);

        if ($siswa && password_verify($password, $siswa['password'])) {
            $_SESSION['siswa'] = [
                'id'    => $siswa['id'],
                'nama'  => $siswa['nama'],
                'nis'   => $siswa['nis'],
                'kelas' => $siswa['kelas']
            ];
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $this->template('auth/header', ['title' => 'Login Siswa']);
        $this->view('auth/login', ['error' => 'NIS atau password salah.']);
        $this->template('auth/footer');
    }

    public function logout() {
        session_destroy();
        header('Location: ' . APP_URL . '/auth'); exit;
    }
}
