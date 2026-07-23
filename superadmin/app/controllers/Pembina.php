<?php

class Pembina extends Controller {
    private $pembina;

    public function __construct() {
        $this->pembina = $this->model('Pembina_model');
    }

    public function index() {
        $data = [
            'title'      => 'Data Pembina',
            'activeMenu' => 'pembina',
            'pembinas'   => $this->pembina->findAll(),
        ];

        $this->template('main/header', $data);
        $this->view('main/pembina/index', $data);
        $this->template('main/footer');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('Location: ' . APP_URL . '/pembina');

        $this->pembina->create([
            'nip'      => $_POST['nip'],
            'nama'     => $_POST['nama'],
            'no_hp'    => $_POST['no_hp'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        ]);

        header('Location: ' . APP_URL . '/pembina'); exit;
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('Location: ' . APP_URL . '/pembina');

        $this->pembina->update($id, [
            'nip'   => $_POST['nip'],
            'nama'  => $_POST['nama'],
            'no_hp' => $_POST['no_hp'],
        ]);

        header('Location: ' . APP_URL . '/pembina');
    }

    public function delete($id) {
        $this->pembina->delete($id);
        header('Location: ' . APP_URL . '/pembina');
    }
}