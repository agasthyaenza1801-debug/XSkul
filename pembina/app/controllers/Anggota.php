<?php

class Anggota extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $data = [
            'title'      => 'Daftar Anggota',
            'activeMenu' => 'anggota',
            'members'    => $pendaftaranModel->findByEkskul($ekskul_id),
            'pending'    => $pendaftaranModel->findPendingByEkskul($ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/anggota/index', $data);
        $this->template('main/footer');
    }

    public function approve($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'aktif');
        
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? (APP_URL . '/dashboard')); exit;
    }

    public function reject($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'ditolak');
        
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? (APP_URL . '/dashboard')); exit;
    }

    public function keluarkan($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'keluar');
        
        header('Location: ' . APP_URL . '/anggota'); exit;
    }
}
