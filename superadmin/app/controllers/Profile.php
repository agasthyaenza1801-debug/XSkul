<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['admin'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $message = $_SESSION['profile_message'] ?? null;
        unset($_SESSION['profile_message']);
        $model = $this->model('SuperAdmin_model');
        $currentAdmin = $model->findById($_SESSION['admin']['id']);
        if ($currentAdmin) {
            $_SESSION['admin']['nama'] = $currentAdmin['nama'];
            $_SESSION['admin']['username'] = $currentAdmin['username'];
            $_SESSION['admin']['created_at'] = $currentAdmin['created_at'];
        }
        $this->template('main/header', [
            'title' => 'Profil Superadmin',
            'activeMenu' => 'profile',
            'message' => $message
        ]);
        $this->view('main/profile/index');
        $this->template('main/footer');
    }

    public function update() {
        $model = $this->model('SuperAdmin_model');
        $current = $model->findById($_SESSION['admin']['id']);
        $username = trim($_POST['username'] ?? '');
        $old = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirmation = $_POST['new_password_confirmation'] ?? '';
        $existing = $model->findByUsername($username);

        if ($username === '') $text = 'Username tidak boleh kosong.';
        elseif ($existing && (int) $existing['id'] !== (int) $current['id']) $text = 'Username sudah digunakan.';
        elseif ($new !== '' && !password_verify($old, $current['password'])) $text = 'Password lama salah.';
        elseif ($new !== '' && strlen($new) < 6) $text = 'Password baru minimal 6 karakter.';
        elseif ($new !== '' && $new !== $confirmation) $text = 'Konfirmasi password tidak cocok.';
        else {
            $model->updateCredentials($current['id'], $username, $new !== '' ? password_hash($new, PASSWORD_DEFAULT) : null);
            $_SESSION['admin']['username'] = $username;
            $_SESSION['profile_message'] = ['type' => 'success', 'text' => 'Profil berhasil diperbarui.'];
            header('Location: ' . APP_URL . '/profile'); exit;
        }
        $_SESSION['profile_message'] = ['type' => 'error', 'text' => $text];
        header('Location: ' . APP_URL . '/profile'); exit;
    }
}
