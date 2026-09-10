<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $this->template('main/header', [
            'title' => 'Profil Pembina',
            'activeMenu' => 'profile'
        ]);
        $this->view('main/profile/index');
        $this->template('main/footer');
    }
}
