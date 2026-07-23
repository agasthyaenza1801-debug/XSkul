<?php

class Ekskul extends Controller {
    private $ekskul;
    private $pembina;

    public function __construct() {
        $this->ekskul  = $this->model('Ekskul_model');
        $this->pembina = $this->model('Pembina_model');
    }

    public function index() {
        $data = [
            'title'     => 'Data Ekskul',
            'activeMenu'=> 'ekskul',
            'ekskuls'   => $this->ekskul->findAll(),
            'pembinas'  => $this->pembina->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/ekskul/index', $data);
        $this->template('main/footer');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/ekskul'); exit;
        }

        $this->ekskul->create([
            'pembina_id'         => $_POST['pembina_id'],
            'nama'               => $_POST['nama'],
            'deskripsi'          => $_POST['deskripsi'],
            'kategori'           => $_POST['kategori'],
            'ikon_emoji'         => $_POST['ikon_emoji'],
            'hari_latihan'       => $_POST['hari_latihan'],
            'jam_mulai'          => $_POST['jam_mulai'],
            'jam_selesai'        => $_POST['jam_selesai'],
            'kuota_max'          => $_POST['kuota_max'],
            'status_pendaftaran' => $_POST['status_pendaftaran'],
        ]);

        header('Location: ' . APP_URL . '/ekskul'); exit;
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/ekskul'); exit;
        }

        $this->ekskul->update($id, [
            'pembina_id'         => $_POST['pembina_id'],
            'nama'               => $_POST['nama'],
            'deskripsi'          => $_POST['deskripsi'],
            'kategori'           => $_POST['kategori'],
            'ikon_emoji'         => $_POST['ikon_emoji'],
            'hari_latihan'       => $_POST['hari_latihan'],
            'jam_mulai'          => $_POST['jam_mulai'],
            'jam_selesai'        => $_POST['jam_selesai'],
            'kuota_max'          => $_POST['kuota_max'],
            'status_pendaftaran' => $_POST['status_pendaftaran'],
        ]);

        header('Location: ' . APP_URL . '/ekskul'); exit;
    }

    public function detail($id) {
        $pendaftaran = $this->model('Pendaftaran_model');
        $sesi        = $this->model('Sesi_model');

        $data = [
            'title'          => 'Detail Ekskul',
            'activeMenu'     => 'ekskul',
            'ekskul'         => $this->ekskul->findById($id),
            'members'        => $pendaftaran->findByEkskul($id),
            'siswaAvailable' => $pendaftaran->siswaAvailable($id),
            'sesis'          => $sesi->findByEkskul($id),
        ];

        $this->template('main/header', $data);
        $this->view('main/ekskul/detail', $data);
        $this->template('main/footer');
    }

    public function buatSesi($ekskul_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/ekskul/detail/' . $ekskul_id); exit;
        }

        $ekskul = $this->ekskul->findById($ekskul_id);

        $sesi = $this->model('Sesi_model');
        $sesi->create([
            'ekskul_id'    => $ekskul_id,
            'tanggal'      => $_POST['tanggal'],
            'pertemuan_ke' => $_POST['pertemuan_ke'],
            'materi'       => $_POST['materi'],
            'catatan'      => $_POST['catatan'],
            'dibuat_oleh'  => $ekskul['pembina_id'],
        ]);

        header('Location: ' . APP_URL . '/ekskul/detail/' . $ekskul_id); exit;
    }

    public function presensi($sesi_id) {
        $sesi_model     = $this->model('Sesi_model');
        $presensi_model = $this->model('Presensi_model');
        
        $sesi   = $sesi_model->findById($sesi_id);
        $ekskul = $this->ekskul->findById($sesi['ekskul_id']);
        
        $data = [
            'title'      => 'Presensi Latihan',
            'activeMenu' => 'ekskul',
            'sesi'       => $sesi,
            'ekskul'     => $ekskul,
            'presensis'  => $presensi_model->findBySesi($sesi_id),
            'members'    => $this->model('Pendaftaran_model')->findByEkskul($sesi['ekskul_id']),
        ];

        $this->template('main/header', $data);
        $this->view('main/ekskul/presensi', $data);
        $this->template('main/footer');
    }

    public function simpanPresensi($sesi_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/ekskul'); exit;
        }

        $presensi_model = $this->model('Presensi_model');
        $sesi_model     = $this->model('Sesi_model');
        $sesi           = $sesi_model->findById($sesi_id);

        $ekskul = $this->ekskul->findById($sesi['ekskul_id']);

        foreach ($_POST['status'] as $siswa_id => $status) {
            $presensi_model->save([
                'sesi_id'     => $sesi_id,
                'siswa_id'    => $siswa_id,
                'status'      => $status,
                'keterangan'  => $_POST['keterangan'][$siswa_id] ?? '',
                'dicatat_oleh'=> $ekskul['pembina_id'],
            ]);
        }

        header('Location: ' . APP_URL . '/ekskul/detail/' . $sesi['ekskul_id']); exit;
    }

    public function tambahAnggota($ekskul_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/ekskul/detail/' . $ekskul_id); exit;
        }

        $pendaftaran = $this->model('Pendaftaran_model');
        $existing    = $pendaftaran->findBySiswaEkskul($_POST['siswa_id'], $ekskul_id);

        if ($existing) {
            $pendaftaran->updateStatus($existing['id'], 'aktif');
        } else {
            $pendaftaran->create([
                'siswa_id'       => $_POST['siswa_id'],
                'ekskul_id'      => $ekskul_id,
                'tanggal_daftar' => date('Y-m-d'),
            ]);
            $p = $pendaftaran->findBySiswaEkskul($_POST['siswa_id'], $ekskul_id);
            if ($p) $pendaftaran->updateStatus($p['id'], 'aktif');
        }

        header('Location: ' . APP_URL . '/ekskul/detail/' . $ekskul_id); exit;
    }

    public function keluarkan($pendaftaran_id) {
        $pendaftaran = $this->model('Pendaftaran_model');
        $row         = $pendaftaran->findById($pendaftaran_id);
        $pendaftaran->updateStatus($pendaftaran_id, 'keluar');
        header('Location: ' . APP_URL . '/ekskul/detail/' . $row['ekskul_id']); exit;
    }

    public function delete($id) {
        $this->ekskul->delete($id);
        header('Location: ' . APP_URL . '/ekskul'); exit;
    }
}