<?php

class Sesi_model extends Database {
    public function findByEkskul($ekskul_id) {
        $this->query('SELECT * FROM sesi_latihan WHERE ekskul_id = :ekskul_id ORDER BY tanggal ASC');
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function findById($id) {
        $this->query('SELECT * FROM sesi_latihan WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function findByEkskulAndTanggal($ekskul_id, $tanggal) {
        $this->query('SELECT * FROM sesi_latihan WHERE ekskul_id = :ekskul_id AND tanggal = :tanggal LIMIT 1');
        $this->bind(':ekskul_id', $ekskul_id, PDO::PARAM_INT);
        $this->bind(':tanggal',   $tanggal);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO sesi_latihan (ekskul_id, tanggal, pertemuan_ke, materi, catatan, dibuat_oleh, is_penilaian) VALUES (:ekskul_id, :tanggal, :pertemuan_ke, :materi, :catatan, :dibuat_oleh, :is_penilaian)');
        $this->bind(':ekskul_id',     $data['ekskul_id']);
        $this->bind(':tanggal',       $data['tanggal']);
        $this->bind(':pertemuan_ke',  $data['pertemuan_ke']);
        $this->bind(':materi',        $data['materi']);
        $this->bind(':catatan',       $data['catatan']);
        $this->bind(':dibuat_oleh',   $data['dibuat_oleh']);
        $this->bind(':is_penilaian',  $data['is_penilaian'], PDO::PARAM_INT);
        $this->execute();
        return $this->rowCount();
    }

    public function update($id, $data) {
        $this->query('UPDATE sesi_latihan SET tanggal = :tanggal, pertemuan_ke = :pertemuan_ke, materi = :materi, catatan = :catatan, is_penilaian = :is_penilaian WHERE id = :id');
        $this->bind(':id',            $id, PDO::PARAM_INT);
        $this->bind(':tanggal',       $data['tanggal']);
        $this->bind(':pertemuan_ke',  $data['pertemuan_ke'], PDO::PARAM_INT);
        $this->bind(':materi',        $data['materi']);
        $this->bind(':catatan',       $data['catatan']);
        $this->bind(':is_penilaian',  $data['is_penilaian'], PDO::PARAM_INT);
        $this->execute();
        return $this->rowCount();
    }

    public function findAll() {
        $this->query('SELECT sl.*, e.nama AS nama_ekskul FROM sesi_latihan sl JOIN ekskul e ON e.id = sl.ekskul_id ORDER BY sl.tanggal DESC');
        return $this->resultSet();
    }
}