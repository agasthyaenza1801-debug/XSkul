<?php

class Siswa_model extends Database {
    public function findAll() {
        $this->query('SELECT * FROM siswa ORDER BY nama ASC');
        return $this->resultSet();
    }

    public function findById($id) {
        $this->query('SELECT * FROM siswa WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function findByNis($nis) {
        $this->query('SELECT * FROM siswa WHERE nis = :nis LIMIT 1');
        $this->bind(':nis', $nis);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO siswa (nis, nisn, nama, kelas, password) VALUES (:nis, :nisn, :nama, :kelas, :password)');
        $this->bind(':nis',      $data['nis']);
        $this->bind(':nisn',     $data['nisn']);
        $this->bind(':nama',     $data['nama']);
        $this->bind(':kelas',    $data['kelas']);
        $this->bind(':password', $data['password']);
        $this->execute();
        return $this->rowCount();
    }

    public function update($id, $data) {
        $this->query('UPDATE siswa SET nis = :nis, nisn = :nisn, nama = :nama, kelas = :kelas WHERE id = :id');
        $this->bind(':nis',   $data['nis']);
        $this->bind(':nisn',  $data['nisn']);
        $this->bind(':nama',  $data['nama']);
        $this->bind(':kelas', $data['kelas']);
        $this->bind(':id',    $id);
        $this->execute();
        return $this->rowCount();
    }

    public function delete($id) {
        $this->query('DELETE FROM siswa WHERE id = :id');
        $this->bind(':id', $id);
        $this->execute();
        return $this->rowCount();
    }

    public function countAll() {
        $this->query('SELECT COUNT(*) FROM siswa');
        return $this->single()['COUNT(*)'];
    }
}