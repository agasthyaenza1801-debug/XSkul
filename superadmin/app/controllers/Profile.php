<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['admin'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $this->template('main/header', [
            'title' => 'Profil Superadmin',
            'activeMenu' => 'profile'
        ]);
        $this->view('main/profile/index');
        $this->template('main/footer');
    }
}
