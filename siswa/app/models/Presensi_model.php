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

    public function getTodayPercentage($ekskul_id) {
        $today = date('Y-m-d');
        $this->query('SELECT id FROM sesi_latihan WHERE ekskul_id = :ekskul_id AND tanggal = :today LIMIT 1');
        $this->bind(':ekskul_id', $ekskul_id);
        $this->bind(':today', $today);
        $sesi = $this->single();

        if (!$sesi) return 0;

        $this->query('SELECT COUNT(*) as total FROM presensi WHERE sesi_id = :sesi_id AND status = "H"');
        $this->bind(':sesi_id', $sesi['id']);
        $hadir = $this->single()['total'];

        $this->query('SELECT COUNT(*) as total FROM pendaftaran WHERE ekskul_id = :ekskul_id AND status = "aktif"');
        $this->bind(':ekskul_id', $ekskul_id);
        $total_anggota = $this->single()['total'];

        if ($total_anggota == 0) return 0;
        return round(($hadir / $total_anggota) * 100);
    }

    public function getStatsBySiswa($siswa_id) {
        $this->query('SELECT status, COUNT(*) as jumlah FROM presensi WHERE siswa_id = :siswa_id GROUP BY status');
        $this->bind(':siswa_id', $siswa_id);
        return $this->resultSet();
    }

    public function findAll() {
        $this->query('SELECT pr.*, s.nama AS nama_siswa, s.nis, s.kelas, sl.tanggal, sl.pertemuan_ke, e.nama AS nama_ekskul FROM presensi pr JOIN siswa s ON s.id = pr.siswa_id JOIN sesi_latihan sl ON sl.id = pr.sesi_id JOIN ekskul e ON e.id = sl.ekskul_id ORDER BY sl.tanggal DESC, s.nama ASC');
        return $this->resultSet();
    }
}