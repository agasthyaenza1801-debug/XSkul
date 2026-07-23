<?php

class Presensi extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $sesiModel = $this->model('Sesi_model');

        $data = [
            'title'      => 'Presensi Siswa',
            'activeMenu' => 'presensi',
            'sesis'      => $sesiModel->findByEkskul($ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/presensi/index', $data);
        $this->template('main/footer');
    }

    public function buatSesi() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $sesiModel = $this->model('Sesi_model');

        $sesiModel->create([
            'ekskul_id'    => $ekskul_id,
            'tanggal'      => $_POST['tanggal'],
            'pertemuan_ke' => $_POST['pertemuan_ke'],
            'materi'       => $_POST['materi'],
            'catatan'      => $_POST['catatan'],
            'dibuat_oleh'  => $_SESSION['pembina']['id'],
        ]);

        header('Location: ' . APP_URL . '/presensi'); exit;
    }

    public function detail($sesi_id) {
        $sesiModel     = $this->model('Sesi_model');
        $presensiModel = $this->model('Presensi_model');
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $sesi = $sesiModel->findById($sesi_id);
        
        // Keamanan: Pastikan sesi ini milik ekskul pembina tersebut
        if ($sesi['ekskul_id'] != $_SESSION['pembina']['ekskul_id']) {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $data = [
            'title'      => 'Catat Presensi',
            'activeMenu' => 'presensi',
            'sesi'       => $sesi,
            'members'    => $pendaftaranModel->findByEkskul($sesi['ekskul_id']),
            'presensis'  => $presensiModel->findBySesi($sesi_id)
        ];

        $this->template('main/header', $data);
        $this->view('main/presensi/detail', $data);
        $this->template('main/footer');
    }

    public function simpan($sesi_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $presensiModel = $this->model('Presensi_model');

        foreach ($_POST['status'] as $siswa_id => $status) {
            $presensiModel->save([
                'sesi_id'     => $sesi_id,
                'siswa_id'    => $siswa_id,
                'status'      => $status,
                'keterangan'  => $_POST['keterangan'][$siswa_id] ?? '',
                'dicatat_oleh'=> $_SESSION['pembina']['id'],
            ]);
        }

        header('Location: ' . APP_URL . '/presensi/detail/' . $sesi_id); exit;
    }
}
