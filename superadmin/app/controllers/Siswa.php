<?php

class Siswa extends Controller {
    private $siswa;

    public function __construct() {
        $this->siswa = $this->model('Siswa_model');
    }

    public function index() {
        $data = [
            'title'      => 'Data Siswa',
            'activeMenu' => 'siswa',
            'siswas'     => $this->siswa->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/siswa/index', $data);
        $this->template('main/footer');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/siswa'); exit;
        }

        $this->siswa->create([
            'nis'      => $_POST['nis'],
            'nisn'     => $_POST['nisn'],
            'nama'     => $_POST['nama'],
            'kelas'    => $_POST['kelas'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        ]);

        header('Location: ' . APP_URL . '/siswa'); exit;
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/siswa'); exit;
        }

        $this->siswa->update($id, [
            'nis'   => $_POST['nis'],
            'nisn'  => $_POST['nisn'],
            'nama'  => $_POST['nama'],
            'kelas' => $_POST['kelas'],
        ]);

        header('Location: ' . APP_URL . '/siswa'); exit;
    }

    public function delete($id) {
        $this->siswa->delete($id);
        header('Location: ' . APP_URL . '/siswa'); exit;
    }
}