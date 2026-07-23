<?php

class Presensi_model extends Database {
    public function findBySesi($sesi_id) {
        $this->query('SELECT pr.*, s.nama AS nama_siswa, s.nis, s.kelas FROM presensi pr JOIN siswa s ON s.id = pr.siswa_id WHERE pr.sesi_id = :sesi_id ORDER BY s.nama ASC');
        $this->bind(':sesi_id', $sesi_id);
        return $this->resultSet();
    }

    public function findBySiswa($siswa_id, $ekskul_id) {
        $this->query('SELECT pr.*, sl.tanggal, sl.pertemuan_ke, sl.materi FROM presensi pr JOIN sesi_latihan sl ON sl.id = pr.sesi_id WHERE pr.siswa_id = :siswa_id AND sl.ekskul_id = :ekskul_id ORDER BY sl.tanggal DESC');
        $this->bind(':siswa_id',  $siswa_id);
        $this->bind(':ekskul_id', $ekskul_id);
        return $this->resultSet();
    }

    public function save($data) {
        $this->query('INSERT INTO presensi (sesi_id, siswa_id, status, keterangan, dicatat_oleh) VALUES (:sesi_id, :siswa_id, :status, :keterangan, :dicatat_oleh) ON DUPLICATE KEY UPDATE status = VALUES(status), keterangan = VALUES(keterangan)');
        $this->bind(':sesi_id',     $data['sesi_id']);
        $this->bind(':siswa_id',    $data['siswa_id']);
        $this->bind(':status',      $data['status']);
        $this->bind(':keterangan',  $data['keterangan']);
        $this->bind(':dicatat_oleh',$data['dicatat_oleh']);
        $this->execute();
        return $this->rowCount();
    }

    public function findAll() {
        $this->query('SELECT pr.*, s.nama AS nama_siswa, s.nis, s.kelas, sl.tanggal, sl.pertemuan_ke, e.nama AS nama_ekskul FROM presensi pr JOIN siswa s ON s.id = pr.siswa_id JOIN sesi_latihan sl ON sl.id = pr.sesi_id JOIN ekskul e ON e.id = sl.ekskul_id ORDER BY sl.tanggal DESC, s.nama ASC');
        return $this->resultSet();
    }
}