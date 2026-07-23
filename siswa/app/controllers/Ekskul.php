<?php

class Ekskul extends Controller {
    public function __construct() {
        if (!isset($_SESSION['siswa'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $siswa_id = $_SESSION['siswa']['id'];
        $ekskulModel      = $this->model('Ekskul_model');
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $data = [
            'title'      => 'Katalog Ekskul',
            'activeMenu' => 'ekskul',
            'ekskuls'    => $ekskulModel->findAll(),
            'myRegistrations' => $pendaftaranModel->findAllBySiswa($siswa_id)
        ];

        $this->template('main/header', $data);
        $this->view('main/ekskul/index', $data);
        $this->template('main/footer');
    }

    public function daftar($ekskul_id) {
        $siswa_id = $_SESSION['siswa']['id'];
        $pendaftaranModel = $this->model('Pendaftaran_model');
        $ekskulModel      = $this->model('Ekskul_model');

        // Cek apakah sudah mendaftar
        $existing = $pendaftaranModel->findBySiswaEkskul($siswa_id, $ekskul_id);
        if ($existing) {
            header('Location: ' . APP_URL . '/ekskul'); exit;
        }

        // Cek kuota
        $ekskul = $ekskulModel->findById($ekskul_id);
        $count  = $pendaftaranModel->countByEkskul($ekskul_id);

        if ($count < $ekskul['kuota_max'] && $ekskul['status_pendaftaran'] === 'Terbuka') {
            $pendaftaranModel->create([
                'siswa_id'       => $siswa_id,
                'ekskul_id'      => $ekskul_id,
                'tanggal_daftar' => date('Y-m-d')
            ]);
        }

        header('Location: ' . APP_URL . '/ekskul'); exit;
    }
    
    public function detail($ekskul_id) {
        $siswa_id = $_SESSION['siswa']['id'];
        $ekskulModel   = $this->model('Ekskul_model');
        $presensiModel = $this->model('Presensi_model');
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $data = [
            'title'      => 'Detail Ekskul',
            'activeMenu' => 'ekskul',
            'ekskul'     => $ekskulModel->findById($ekskul_id),
            'presensis'  => $presensiModel->findBySiswa($siswa_id, $ekskul_id),
            'registration' => $pendaftaranModel->findBySiswaEkskul($siswa_id, $ekskul_id)
        ];

        $this->template('main/header', $data);
        $this->view('main/ekskul/detail', $data);
        $this->template('main/footer');
    }
}
