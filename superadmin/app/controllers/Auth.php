<?php

class Auth extends Controller {
    public function index() {
        $this->template('auth/header');
        $this->view('auth/login');
        $this->template('auth/footer');
    }

    public function login() {

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $adminModel = $this->model('SuperAdmin_model');
        $admin = $adminModel->findByUsername($username);
        

        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin'] = [
                'id'   => $admin['id'],
                'nama' => $admin['nama'],
            ];
            header("Location: " . APP_URL . '/dashboard');
        }

        $this->template('auth/header');
        $this->view('auth/login', ['error' => 'Username atau password salah.']);
        $this->template('auth/footer');
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: " . APP_URL . '/auth');
    }
}