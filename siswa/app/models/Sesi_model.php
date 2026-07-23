<?php

class Sesi_model extends Database {
    public function findByEkskul($ekskul_id) {
        $this->query('SELECT * FROM sesi_latihan WHERE ekskul_id = :ekskul_id ORDER BY tanggal DESC');
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function findById($id) {
        $this->query('SELECT * FROM sesi_latihan WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO sesi_latihan (ekskul_id, tanggal, pertemuan_ke, materi, catatan, dibuat_oleh) VALUES (:ekskul_id, :tanggal, :pertemuan_ke, :materi, :catatan, :dibuat_oleh)');
        $this->bind(':ekskul_id',    $data['ekskul_id']);
        $this->bind(':tanggal',      $data['tanggal']);
        $this->bind(':pertemuan_ke', $data['pertemuan_ke']);
        $this->bind(':materi',       $data['materi']);
        $this->bind(':catatan',      $data['catatan']);
        $this->bind(':dibuat_oleh',  $data['dibuat_oleh']);
        $this->execute();
        return $this->rowCount();
    }

    public function findAll() {
        $this->query('SELECT sl.*, e.nama AS nama_ekskul FROM sesi_latihan sl JOIN ekskul e ON e.id = sl.ekskul_id ORDER BY sl.tanggal DESC');
        return $this->resultSet();
    }
}