<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['siswa'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
        if (!isset($_SESSION['siswa']['username'])) {
            $_SESSION['siswa']['username'] = $_SESSION['siswa']['nis'] ?? $_SESSION['siswa']['nama'] ?? '';
        }
    }

    public function index() {
        $message = $_SESSION['profile_message'] ?? null;
        unset($_SESSION['profile_message']);
        $siswaModel = $this->model('Siswa_model');
        $currentSiswa = $siswaModel->findById($_SESSION['siswa']['id']);
        if ($currentSiswa) {
            $_SESSION['siswa']['nisn'] = $currentSiswa['nisn'];
            $_SESSION['siswa']['created_at'] = $currentSiswa['created_at'];
        }
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $this->template('main/header', [
            'title' => 'Profil Siswa',
            'activeMenu' => 'profile',
            'message' => $message
        ]);
        $this->view('main/profile/index', [
            'activeEkskuls' => $pendaftaranModel->findActiveBySiswa($_SESSION['siswa']['id'])
        ]);
        $this->template('main/footer');
    }

    public function update() {
        $model = $this->model('Siswa_model');
        $current = $model->findById($_SESSION['siswa']['id']);
        $nama = trim($_POST['nama'] ?? '');
        $old = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirmation = $_POST['new_password_confirmation'] ?? '';
        $existing = $model->findByUsername($nama);

        if ($nama === '') $text = 'Nama tidak boleh kosong.';
        elseif ($existing && (int) $existing['id'] !== (int) $current['id']) $text = 'Nama sudah digunakan.';
        elseif ($new !== '' && !password_verify($old, $current['password'])) $text = 'Password lama salah.';
        elseif ($new !== '' && strlen($new) < 6) $text = 'Password baru minimal 6 karakter.';
        elseif ($new !== '' && $new !== $confirmation) $text = 'Konfirmasi password tidak cocok.';
        else {
            $model->updateCredentials($current['id'], $nama, $new !== '' ? password_hash($new, PASSWORD_DEFAULT) : null);
            $_SESSION['siswa']['username'] = $nama;
            $_SESSION['siswa']['nama'] = $nama;
            $_SESSION['profile_message'] = ['type' => 'success', 'text' => 'Profil berhasil diperbarui.'];
            header('Location: ' . APP_URL . '/profile'); exit;
        }
        $_SESSION['profile_message'] = ['type' => 'error', 'text' => $text];
        header('Location: ' . APP_URL . '/profile'); exit;
    }
}
