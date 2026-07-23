<?php

class Pembina_model extends Database {
    public function findAll() {
        $this->query('SELECT * FROM pembina ORDER BY nama ASC');
        return $this->resultSet();
    }

    public function findById($id) {
        $this->query('SELECT * FROM pembina WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function findByNip($nip) {
        $this->query('SELECT * FROM pembina WHERE nip = :nip LIMIT 1');
        $this->bind(':nip', $nip);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO pembina (nip, nama, no_hp, password) VALUES (:nip, :nama, :no_hp, :password)');
        $this->bind(':nip',      $data['nip']);
        $this->bind(':nama',     $data['nama']);
        $this->bind(':no_hp',    $data['no_hp']);
        $this->bind(':password', $data['password']);
        $this->execute();
        return $this->rowCount();
    }

    public function update($id, $data) {
        $this->query('UPDATE pembina SET nip = :nip, nama = :nama, no_hp = :no_hp WHERE id = :id');
        $this->bind(':nip',  $data['nip']);
        $this->bind(':nama', $data['nama']);
        $this->bind(':no_hp',$data['no_hp']);
        $this->bind(':id',   $id);
        $this->execute();
        return $this->rowCount();
    }

    public function delete($id) {
        $this->query('DELETE FROM pembina WHERE id = :id');
        $this->bind(':id', $id);
        $this->execute();
        return $this->rowCount();
    }

    public function countAll() {
        $this->query('SELECT COUNT(*) FROM pembina');
        return $this->single()['COUNT(*)'];
    }
}