<?php

class Dashboard extends Controller {
    public function __construct() {
        if (!isset($_SESSION['siswa'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $siswa_id = $_SESSION['siswa']['id'];

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $presensiModel    = $this->model('Presensi_model');

        // Ambil pendaftaran aktif
        $myEkskuls = $pendaftaranModel->findAllBySiswa($siswa_id);
        
        // Ambil statistik kehadiran
        $statsRaw = $presensiModel->getStatsBySiswa($siswa_id);
        $stats = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0, 'total' => 0];
        foreach ($statsRaw as $s) {
            $stats[$s['status']] = (int)$s['jumlah'];
            $stats['total'] += (int)$s['jumlah'];
        }

        $data = [
            'title'      => 'Dashboard Siswa',
            'activeMenu' => 'dashboard',
            'myEkskuls'  => $myEkskuls,
            'stats'      => $stats
        ];

        $this->template('main/header', $data);
        $this->view('main/dashboard/index', $data);
        $this->template('main/footer');
    }
}
