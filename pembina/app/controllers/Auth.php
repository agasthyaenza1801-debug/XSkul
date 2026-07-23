<?php

class Auth extends Controller {
    public function index() {
        if (isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $this->template('auth/header', ['title' => 'Login Pembina']);
        $this->view('auth/login');
        $this->template('auth/footer');
    }

    public function login() {
        $nip      = trim($_POST['nip'] ?? '');
        $password = $_POST['password'] ?? '';

        $pembinaModel = $this->model('Pembina_model');
        $pembina      = $pembinaModel->findByNip($nip);

        if ($pembina && password_verify($password, $pembina['password'])) {
            // Cek apakah pembina ini punya ekskul
            $ekskulModel = $this->model('Ekskul_model');
            $ekskul      = $ekskulModel->findByPembina($pembina['id']);

            if (!$ekskul) {
                $this->template('auth/header', ['title' => 'Login Pembina']);
                $this->view('auth/login', ['error' => 'Akun Pembina aktif, namun belum ditugaskan ke ekskul mana pun. Hubungi Superadmin.']);
                $this->template('auth/footer');
                return;
            }

            session_start();
            $_SESSION['pembina'] = [
                'id'        => $pembina['id'],
                'nama'      => $pembina['nama'],
                'nip'       => $pembina['nip'],
                'ekskul_id' => $ekskul['id'],
                'ekskul'    => $ekskul['nama']
            ];
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $this->template('auth/header', ['title' => 'Login Pembina']);
        $this->view('auth/login', ['error' => 'NIP atau password salah.']);
        $this->template('auth/footer');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . APP_URL . '/auth'); exit;
    }
}
