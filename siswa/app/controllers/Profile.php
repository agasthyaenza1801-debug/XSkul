<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['siswa'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $this->template('main/header', [
            'title' => 'Profil Siswa',
            'activeMenu' => 'profile'
        ]);
        $this->view('main/profile/index');
        $this->template('main/footer');
    }
}
