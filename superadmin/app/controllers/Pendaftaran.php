<?php

class Pendaftaran extends Controller {
    private $pendaftaran;

    public function __construct() {
        $this->pendaftaran = $this->model('Pendaftaran_model');
    }

    public function index() {
        $data = [
            'title'      => 'Data Pendaftaran',
            'activeMenu' => 'pendaftaran',
            'pendaftarans'=> $this->pendaftaran->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/pendaftaran/index', $data);
        $this->template('main/footer');
    }
}
