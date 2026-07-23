<?php

class Presensi extends Controller {
    private $presensi;

    public function __construct() {
        $this->presensi = $this->model('Presensi_model');
    }

    public function index() {
        $data = [
            'title'      => 'Data Presensi',
            'activeMenu' => 'presensi',
            'presensis'  => $this->presensi->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/presensi/index', $data);
        $this->template('main/footer');
    }
}
