<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
        if (!isset($_SESSION['pembina']['username'])) {
            $_SESSION['pembina']['username'] = $_SESSION['pembina']['nip'] ?? $_SESSION['pembina']['nama'] ?? '';
        }
    }

    public function index() {
        $message = $_SESSION['profile_message'] ?? null;
        unset($_SESSION['profile_message']);
        $this->template('main/header', [
            'title' => 'Profil Pembina',
            'activeMenu' => 'profile',
            'message' => $message
        ]);
        $this->view('main/profile/index');
        $this->template('main/footer');
    }

    public function update() {
        $model = $this->model('Pembina_model');
        $current = $model->findById($_SESSION['pembina']['id']);
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
            $_SESSION['pembina']['username'] = $nama;
            $_SESSION['pembina']['nama'] = $nama;
            $_SESSION['profile_message'] = ['type' => 'success', 'text' => 'Profil berhasil diperbarui.'];
            header('Location: ' . APP_URL . '/profile'); exit;
        }
        $_SESSION['profile_message'] = ['type' => 'error', 'text' => $text];
        header('Location: ' . APP_URL . '/profile'); exit;
    }
}
