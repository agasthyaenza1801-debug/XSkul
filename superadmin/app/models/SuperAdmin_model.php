<?php

class SuperAdmin_model extends Database {
    public function findByUsername($username) {
        $this->query('SELECT * FROM super_admin WHERE username = :username LIMIT 1');
        $this->bind(':username', $username);
        return $this->single();
    }

    public function findById($id) {
        $this->query('SELECT * FROM super_admin WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function updateCredentials($id, $username, $password = null) {
        $query = 'UPDATE super_admin SET username = :username' . ($password !== null ? ', password = :password' : '') . ' WHERE id = :id';
        $this->query($query);
        $this->bind(':username', $username);
        if ($password !== null) $this->bind(':password', $password);
        $this->bind(':id', $id);
        $this->execute();
    }
}