<?php

class Penilaian_model extends Database {
    /**
     * Sesi yang ditandai untuk penilaian (is_penilaian = 1) milik satu ekskul.
     * total_dinilai  = jumlah siswa yang presensinya ditandai dinilai
     * total_ternilai = jumlah siswa yang sudah punya baris nilai
     */
    public function findGradedSessionsByEkskul($ekskul_id) {
        $this->query("SELECT sl.id, sl.ekskul_id, sl.tanggal, sl.pertemuan_ke, sl.materi, sl.is_penilaian,
                             COUNT(pr.id) AS total_dinilai,
                             COUNT(pn.id) AS total_ternilai
                      FROM sesi_latihan sl
                      LEFT JOIN presensi pr ON pr.sesi_id = sl.id AND pr.is_penilaian = 1
                      LEFT JOIN penilaian pn ON pn.presensi_id = pr.id
                      WHERE sl.is_penilaian = 1 AND sl.ekskul_id = :ekskul_id
                      GROUP BY sl.id
                      ORDER BY sl.tanggal DESC, sl.pertemuan_ke DESC");
        $this->bind(':ekskul_id', $ekskul_id, PDO::PARAM_INT);
        return $this->resultSet();
    }

    /**
     * Detail penilaian satu sesi: satu baris per anggota aktif ekskul, urut nama ascending.
     * Data presensi & nilai di-LEFT JOIN supaya anggota yang belum dicatat presensinya tetap tampil.
     */
    public function findBySesi($sesi_id, $ekskul_id) {
        $this->query("SELECT s.nama, s.nis, s.kelas,
                             pr.id AS presensi_id, pr.status AS presensi_status, pr.is_penilaian,
                             pn.nilai, pn.keterangan AS penilaian_keterangan
                      FROM pendaftaran pd
                      JOIN siswa s ON s.id = pd.siswa_id
                      LEFT JOIN presensi pr ON pr.sesi_id = :sesi_id AND pr.siswa_id = pd.siswa_id
                      LEFT JOIN penilaian pn ON pn.presensi_id = pr.id
                      WHERE pd.ekskul_id = :ekskul_id AND pd.status = 'aktif'
                      ORDER BY s.nama ASC");
        $this->bind(':sesi_id',   $sesi_id, PDO::PARAM_INT);
        $this->bind(':ekskul_id', $ekskul_id, PDO::PARAM_INT);
        return $this->resultSet();
    }

    /**
     * Upsert satu baris penilaian (satu baris per presensi_id, dijamin UNIQUE KEY).
     */
    public function save($presensi_id, $nilai, $keterangan) {
        $this->query('INSERT INTO penilaian (presensi_id, nilai, keterangan) VALUES (:presensi_id, :nilai, :keterangan) ON DUPLICATE KEY UPDATE nilai = VALUES(nilai), keterangan = VALUES(keterangan)');
        $this->bind(':presensi_id', $presensi_id, PDO::PARAM_INT);
        $this->bind(':nilai',       $nilai);
        $this->bind(':keterangan',  $keterangan);
        $this->execute();
        return $this->rowCount();
    }

    /**
     * Hapus baris penilaian (dipakai saat input nilai dikosongkan).
     */
    public function deleteByPresensi($presensi_id) {
        $this->query('DELETE FROM penilaian WHERE presensi_id = :presensi_id');
        $this->bind(':presensi_id', $presensi_id, PDO::PARAM_INT);
        $this->execute();
        return $this->rowCount();
    }
}
