<?php

class Anggota extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $data = [
            'title'      => 'Daftar Anggota',
            'activeMenu' => 'anggota',
            'members'    => $pendaftaranModel->findByEkskul($ekskul_id),
            'pending'    => $pendaftaranModel->findPendingByEkskul($ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/anggota/index', $data);
        $this->template('main/footer');
    }

    public function approve($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'aktif');
        
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? (APP_URL . '/dashboard')); exit;
    }

    public function reject($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'ditolak');
        
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? (APP_URL . '/dashboard')); exit;
    }

    public function keluarkan($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/dashboard'); exit;
        }

        $pendaftaranModel = $this->model('Pendaftaran_model');
        $pendaftaranModel->updateStatus($id, 'keluar');
        
        header('Location: ' . APP_URL . '/anggota'); exit;
    }

    // Export Excel Data Anggota Aktif
    public function excel($ekskul_id) {
        // Bersihkan buffer output agar tidak ada spasi/error yang ikut terunduh
        if (ob_get_level()) {
            ob_end_clean();
        }

        $data = $this->model('Pendaftaran_model')->findByEkskul($ekskul_id);
        
        // Header untuk mendownload file Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_Anggota_Ekskul_$ekskul_id.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        echo "<table border='1'>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Tanggal Daftar</th></tr>";
        $no = 1;
        foreach($data as $row) {
            echo "<tr>";
            echo "<td>".$no++."</td>";
            // Menggunakan mso-number-format agar NIS terbaca sebagai teks (tidak hilang angka 0 di depan)
            echo "<td style='mso-number-format:\"\\@\";'>".$row['nis']."</td>";
            echo "<td>".$row['nama_siswa']."</td>";
            echo "<td>".$row['kelas']."</td>";
            echo "<td>".$row['tanggal_daftar']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }

    // Export PDF Data Anggota Aktif (Format HTML-to-Print sederhana / DOMPDF)
    public function pdf($ekskul_id) {
        $data = $this->model('Pendaftaran_model')->findByEkskul($ekskul_id);
        
        // Menggunakan window.print() bawaan browser agar kompatibel tanpa install library berat
        echo "<html><head><title>Print Data Anggota</title><style>
            body { font-family: sans-serif; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
        </style></head><body>";
        echo "<h2>Laporan Data Anggota Ekstrakurikuler</h2>";
        echo "<table>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Tanggal Daftar</th></tr>";
        $no = 1;
        foreach($data as $row) {
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$row['nis']."</td>";
            echo "<td>".$row['nama_siswa']."</td>";
            echo "<td>".$row['kelas']."</td>";
            echo "<td>".$row['tanggal_daftar']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<script>window.print();</script>";
        echo "</body></html>";
        exit;
    }
}
