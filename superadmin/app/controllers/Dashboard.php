<?php

class Dashboard extends Controller {
    public function index() {
        $pembina     = $this->model('Pembina_model');
        $siswa       = $this->model('Siswa_model');
        $ekskul      = $this->model('Ekskul_model');
        $pendaftaran = $this->model('Pendaftaran_model');

        $data = [
            'title'         => 'Main Overview',
            'activeMenu'    => 'dashboard',
            'totalPembina'  => $pembina->countAll(),
            'totalSiswa'    => $siswa->countAll(),
            'totalMember'   => $pendaftaran->countAll(),
            'totalEkskul'   => $ekskul->countAll(),
            'recentMembers' => $pendaftaran->recentMembers(10),
        ];

        $this->template('main/header', $data);
        $this->view('main/dashboard/index', $data);
        $this->template('main/footer');
    }
}