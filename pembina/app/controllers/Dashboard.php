<?php

class Dashboard extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $pembina_id = $_SESSION['pembina']['id'];
        $ekskul_id  = $_SESSION['pembina']['ekskul_id'];

        $ekskulModel      = $this->model('Ekskul_model');
        $pendaftaranModel = $this->model('Pendaftaran_model');
        $presensiModel    = $this->model('Presensi_model');

        $data = [
            'title'      => 'Dashboard Pembina',
            'activeMenu' => 'dashboard',
            'ekskul'     => $ekskulModel->findById($ekskul_id),
            'members'    => $pendaftaranModel->findByEkskul($ekskul_id),
            'pending'    => $pendaftaranModel->findPendingByEkskul($ekskul_id),
            'stats'      => [
                'total'      => $pendaftaranModel->countByEkskul($ekskul_id),
                'pending'    => $pendaftaranModel->countPendingByEkskul($ekskul_id),
                'attendance' => $presensiModel->getTodayPercentage($ekskul_id)
            ]
        ];

        $this->template('main/header', $data);
        $this->view('main/dashboard/index', $data);
        $this->template('main/footer');
    }
}
