<?php

class Sesi extends Controller {
    private $sesi;

    public function __construct() {
        $this->sesi = $this->model('Sesi_model');
    }

    public function index() {
        $data = [
            'title'      => 'Data Sesi Latihan',
            'activeMenu' => 'sesi',
            'sesis'      => $this->sesi->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/sesi/index', $data);
        $this->template('main/footer');
    }
}
