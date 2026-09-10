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

        // Cegah duplikat: satu ekskul hanya boleh satu sesi per tanggal (uq_sesi)
        if ($sesiModel->findByEkskulAndTanggal($ekskul_id, $_POST['tanggal'])) {
            $data = [
                'title'      => 'Presensi Siswa',
                'activeMenu' => 'presensi',
                'sesis'      => $sesiModel->findByEkskul($ekskul_id),
                'error'      => 'Sesi untuk tanggal ' . date('d M Y', strtotime($_POST['tanggal'])) . ' sudah ada. Gunakan tanggal lain atau edit sesi yang sudah ada.',
            ];

            $this->template('main/header', $data);
            $this->view('main/presensi/index', $data);
            $this->template('main/footer');
            return;
        }

        $sesiModel->create([
            'ekskul_id'    => $ekskul_id,
            'tanggal'      => $_POST['tanggal'],
            'pertemuan_ke' => $_POST['pertemuan_ke'],
            'materi'       => $_POST['materi'],
            'catatan'      => $_POST['catatan'],
            'dibuat_oleh'  => $_SESSION['pembina']['id'],
            'is_penilaian' => isset($_POST['is_penilaian']) ? 1 : 0,
        ]);

        // Jika sesi ini ditandai dinilai, pastikan semua presensi sesi ini ikut bernilai
        if (isset($_POST['is_penilaian'])) {
            $presensiModel = $this->model('Presensi_model');
            $presensiModel->setPenilaianBySesi($sesiModel->lastInsertId(), 1);
        }

        header('Location: ' . APP_URL . '/presensi'); exit;
    }

    public function editSesi($sesi_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $sesiModel = $this->model('Sesi_model');
        $sesi = $sesiModel->findById($sesi_id);

        // Keamanan: Pastikan sesi ini milik ekskul pembina tersebut
        if (!$sesi || $sesi['ekskul_id'] != $_SESSION['pembina']['ekskul_id']) {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $is_penilaian = isset($_POST['is_penilaian']) ? 1 : 0;

        $sesiModel->update($sesi_id, [
            'tanggal'      => $_POST['tanggal'],
            'pertemuan_ke' => $_POST['pertemuan_ke'],
            'materi'       => $_POST['materi'],
            'catatan'      => $_POST['catatan'],
            'is_penilaian' => $is_penilaian,
        ]);

        // Sinkronkan flag penilaian ke semua baris presensi milik sesi ini
        $presensiModel = $this->model('Presensi_model');
        $presensiModel->setPenilaianBySesi($sesi_id, $is_penilaian);

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

        // Sesi dinilai -> semua presensinya ikut ditandai bernilai
        $is_penilaian = !empty($sesi_id) ? (int)($this->model('Sesi_model')->findById($sesi_id)['is_penilaian'] ?? 0) : 0;

        foreach ($_POST['status'] as $siswa_id => $status) {
            $presensiModel->save([
                'sesi_id'      => $sesi_id,
                'siswa_id'     => $siswa_id,
                'status'       => $status,
                'is_penilaian' => $is_penilaian,
                'keterangan'   => $_POST['keterangan'][$siswa_id] ?? '',
                'dicatat_oleh' => $_SESSION['pembina']['id'],
            ]);
        }

        header('Location: ' . APP_URL . '/presensi/detail/' . $sesi_id); exit;
    }
}
