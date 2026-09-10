<?php

class Penilaian extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $penilaianModel = $this->model('Penilaian_model');

        $data = [
            'title'      => 'Penilaian Siswa',
            'activeMenu' => 'penilaian',
            'sesis'      => $penilaianModel->findGradedSessionsByEkskul($ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/penilaian/index', $data);
        $this->template('main/footer');
    }

    public function detail($sesi_id) {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $penilaianModel = $this->model('Penilaian_model');
        $sesiModel      = $this->model('Sesi_model');

        $sesi = $sesiModel->findById($sesi_id);

        // Keamanan: Pastikan sesi ini milik ekskul pembina tersebut dan ditandai dinilai
        if (!$sesi || $sesi['ekskul_id'] != $ekskul_id || !$sesi['is_penilaian']) {
            header('Location: ' . APP_URL . '/penilaian'); exit;
        }

        $data = [
            'title'      => 'Input Penilaian',
            'activeMenu' => 'penilaian',
            'sesi'       => $sesi,
            'members'    => $penilaianModel->findBySesi($sesi_id, $ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/penilaian/detail', $data);
        $this->template('main/footer');
    }

    public function simpan($sesi_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/penilaian'); exit;
        }

        $ekskul_id      = $_SESSION['pembina']['ekskul_id'];
        $penilaianModel = $this->model('Penilaian_model');
        $sesiModel      = $this->model('Sesi_model');

        $sesi = $sesiModel->findById($sesi_id);

        // Keamanan: Pastikan sesi ini milik ekskul pembina tersebut dan ditandai dinilai
        if (!$sesi || $sesi['ekskul_id'] != $ekskul_id || !$sesi['is_penilaian']) {
            header('Location: ' . APP_URL . '/penilaian'); exit;
        }

        foreach ($_POST['nilai'] ?? [] as $presensi_id => $nilai) {
            $nilai       = trim($nilai);
            $keterangan  = trim($_POST['keterangan'][$presensi_id] ?? '');

            if ($nilai === '') {
                // Input kosong -> hapus penilaian
                if ($keterangan === '') {
                    $penilaianModel->deleteByPresensi($presensi_id);
                }
                continue;
            }

            // Validasi rentang nilai 0-100
            if (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
                continue;
            }

            $penilaianModel->save($presensi_id, $nilai, $keterangan !== '' ? $keterangan : null);
        }

        header('Location: ' . APP_URL . '/penilaian/detail/' . $sesi_id); exit;
    }
}
