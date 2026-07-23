<?php

class Ekskul_model extends Database {
    public function findAll() {
        $this->query('SELECT e.*, p.nama AS nama_pembina, COUNT(pd.id) AS total_anggota FROM ekskul e JOIN pembina p ON p.id = e.pembina_id LEFT JOIN pendaftaran pd ON pd.ekskul_id = e.id AND pd.status = "aktif" GROUP BY e.id ORDER BY e.nama ASC');
        return $this->resultSet();
    }

    public function findByPembina($pembina_id) {
        $this->query('SELECT * FROM ekskul WHERE pembina_id = :pembina_id LIMIT 1');
        $this->bind(':pembina_id', $pembina_id);
        return $this->single();
    }

    public function findById($id) {
        $this->query('SELECT e.*, p.nama AS nama_pembina FROM ekskul e JOIN pembina p ON p.id = e.pembina_id WHERE e.id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO ekskul (pembina_id, nama, deskripsi, kategori, ikon_emoji, hari_latihan, jam_mulai, jam_selesai, kuota_max, status_pendaftaran) VALUES (:pembina_id, :nama, :deskripsi, :kategori, :ikon_emoji, :hari_latihan, :jam_mulai, :jam_selesai, :kuota_max, :status_pendaftaran)');
        $this->bind(':pembina_id',        $data['pembina_id']);
        $this->bind(':nama',              $data['nama']);
        $this->bind(':deskripsi',         $data['deskripsi']);
        $this->bind(':kategori',          $data['kategori']);
        $this->bind(':ikon_emoji',        $data['ikon_emoji']);
        $this->bind(':hari_latihan',      $data['hari_latihan']);
        $this->bind(':jam_mulai',         $data['jam_mulai']);
        $this->bind(':jam_selesai',       $data['jam_selesai']);
        $this->bind(':kuota_max',         $data['kuota_max']);
        $this->bind(':status_pendaftaran',$data['status_pendaftaran']);
        $this->execute();
        return $this->rowCount();
    }

    public function update($id, $data) {
        $this->query('UPDATE ekskul SET pembina_id = :pembina_id, nama = :nama, deskripsi = :deskripsi, kategori = :kategori, ikon_emoji = :ikon_emoji, hari_latihan = :hari_latihan, jam_mulai = :jam_mulai, jam_selesai = :jam_selesai, kuota_max = :kuota_max, status_pendaftaran = :status_pendaftaran WHERE id = :id');
        $this->bind(':pembina_id',        $data['pembina_id']);
        $this->bind(':nama',              $data['nama']);
        $this->bind(':deskripsi',         $data['deskripsi']);
        $this->bind(':kategori',          $data['kategori']);
        $this->bind(':ikon_emoji',        $data['ikon_emoji']);
        $this->bind(':hari_latihan',      $data['hari_latihan']);
        $this->bind(':jam_mulai',         $data['jam_mulai']);
        $this->bind(':jam_selesai',       $data['jam_selesai']);
        $this->bind(':kuota_max',         $data['kuota_max']);
        $this->bind(':status_pendaftaran',$data['status_pendaftaran']);
        $this->bind(':id',                $id);
        $this->execute();
        return $this->rowCount();
    }

    public function delete($id) {
        $this->query('DELETE FROM ekskul WHERE id = :id');
        $this->bind(':id', $id);
        $this->execute();
        return $this->rowCount();
    }

    public function countAll() {
        $this->query('SELECT COUNT(*) FROM ekskul');
        return $this->single()['COUNT(*)'];
    }
}