<?php

class SuperAdmin_model extends Database {
    public function findByUsername($username) {
        $this->query('SELECT * FROM super_admin WHERE username = :username LIMIT 1');
        $this->bind(':username', $username);
        return $this->single();
    }
}