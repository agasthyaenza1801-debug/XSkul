<?php

class Pendaftaran_model extends Database {
    public function siswaAvailable($ekskul_id) {
        $this->query('SELECT s.id, s.nis, s.nama, s.kelas FROM siswa s WHERE s.is_active = 1 AND s.id NOT IN (SELECT siswa_id FROM pendaftaran WHERE ekskul_id = :ekskul_id AND status = "aktif") ORDER BY s.nama ASC');
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function findPendingByEkskul($ekskul_id) {
        $this->query("SELECT p.*, s.nama AS nama_siswa, s.nis, s.kelas FROM pendaftaran p JOIN siswa s ON s.id = p.siswa_id WHERE p.ekskul_id = :ekskul_id AND p.status = 'pending' ORDER BY p.tanggal_daftar ASC");
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function countByEkskul($ekskul_id) {
        $this->query('SELECT COUNT(*) FROM pendaftaran WHERE ekskul_id = :ekskul_id AND status = "aktif"');
        $this->bind(':ekskul_id', $ekskul_id);
        return (int)$this->single()['COUNT(*)'];
    }

    public function countPendingByEkskul($ekskul_id) {
        $this->query('SELECT COUNT(*) FROM pendaftaran WHERE ekskul_id = :ekskul_id AND status = "pending"');
        $this->bind(':ekskul_id', $ekskul_id);
        return (int)$this->single()['COUNT(*)'];
    }

    public function findByEkskul($ekskul_id) {
        $this->query("SELECT p.*, s.nama AS nama_siswa, s.nis, s.kelas FROM pendaftaran p JOIN siswa s ON s.id = p.siswa_id WHERE p.ekskul_id = :ekskul_id AND p.status = 'aktif' ORDER BY p.tanggal_daftar ASC");
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function findBySiswaEkskul($siswa_id, $ekskul_id) {
        $this->query('SELECT * FROM pendaftaran WHERE siswa_id = :siswa_id AND ekskul_id = :ekskul_id LIMIT 1');
        $this->bind(':siswa_id',  $siswa_id);
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->single();
    }

    public function findBySiswa($siswa_id) {
        $this->query('SELECT p.*, e.nama AS nama_ekskul FROM pendaftaran p JOIN ekskul e ON e.id = p.ekskul_id WHERE p.siswa_id = :siswa_id LIMIT 1');
        $this->bind(':siswa_id', $siswa_id);
        return $this->single();
    }

    public function findAllBySiswa($siswa_id) {
        $this->query('SELECT p.*, e.nama AS nama_ekskul, e.kategori, e.ikon_emoji, e.hari_latihan, e.jam_mulai, e.jam_selesai FROM pendaftaran p JOIN ekskul e ON e.id = p.ekskul_id WHERE p.siswa_id = :siswa_id ORDER BY p.tanggal_daftar DESC');
        $this->bind(':siswa_id', $siswa_id);
        return $this->resultSet();
    }

    public function findById($id) {
        $this->query('SELECT * FROM pendaftaran WHERE id = :id LIMIT 1');
        $this->bind(':id', $id);
        return $this->single();
    }

    public function create($data) {
        $this->query('INSERT INTO pendaftaran (siswa_id, ekskul_id, tanggal_daftar) VALUES (:siswa_id, :ekskul_id, :tanggal_daftar)');
        $this->bind(':siswa_id',      $data['siswa_id']);
        $this->bind(':ekskul_id',     $data['ekskul_id']);
        $this->bind(':tanggal_daftar',$data['tanggal_daftar']);
        $this->execute();
        return $this->rowCount();
    }

    public function updateStatus($id, $status, $catatan = null) {
        $this->query('UPDATE pendaftaran SET status = :status, catatan = :catatan WHERE id = :id');
        $this->bind(':status',  $status);
        $this->bind(':catatan', $catatan);
        $this->bind(':id',      $id);
        $this->execute();
        return $this->rowCount();
    }

    public function countAll() {
        $this->query('SELECT COUNT(*) FROM pendaftaran WHERE status = "aktif"');
        return $this->single()['COUNT(*)'];
    }

    public function recentMembers($limit = 10) {
        $this->query('SELECT p.*, s.nama AS nama_siswa, s.kelas, e.nama AS nama_ekskul, pb.nama AS nama_pembina FROM pendaftaran p JOIN siswa s ON s.id = p.siswa_id JOIN ekskul e ON e.id = p.ekskul_id JOIN pembina pb ON pb.id = e.pembina_id WHERE p.status = "aktif" ORDER BY p.tanggal_daftar DESC LIMIT :limit');
        $this->bind(':limit', $limit);
        return $this->resultSet();
    }

    public function findAll() {
        $this->query('SELECT p.*, s.nama AS nama_siswa, s.nis, s.kelas, e.nama AS nama_ekskul FROM pendaftaran p JOIN siswa s ON s.id = p.siswa_id JOIN ekskul e ON e.id = p.ekskul_id ORDER BY p.tanggal_daftar DESC');
        return $this->resultSet();
    }
}