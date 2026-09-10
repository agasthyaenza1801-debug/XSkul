<?php

class Presensi extends Controller {
    public function __construct() {
        if (!isset($_SESSION['pembina'])) {
            header('Location: ' . APP_URL . '/auth'); exit;
        }
    }

    public function index() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $sesiModel = $this->model('Sesi_model');

        $data = [
            'title'      => 'Presensi Siswa',
            'activeMenu' => 'presensi',
            'sesis'      => $sesiModel->findByEkskul($ekskul_id),
        ];

        $this->template('main/header', $data);
        $this->view('main/presensi/index', $data);
        $this->template('main/footer');
    }

    public function export_rekap_excel() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        if (ob_get_level()) { ob_end_clean(); }

        $sesis = $this->model('Sesi_model')->findByEkskul($ekskul_id);
        $members = $this->model('Pendaftaran_model')->findByEkskul($ekskul_id);
        $allPresensi = $this->model('Presensi_model')->findAllRekapByEkskul($ekskul_id);

        $matrix = [];
        foreach ($allPresensi as $p) {
            $matrix[$p['siswa_id']][$p['sesi_id']] = strtoupper(substr($p['status'], 0, 1));
        }

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Rekap_Matrix_Presensi.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        echo "<tr style='background-color: #f2f2f2;'><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th>";
        foreach ($sesis as $s) {
            echo "<th>P-".$s['pertemuan_ke']."<br>(".$s['tanggal'].")</th>";
        }
        echo "</tr>";

        $no = 1;
        foreach ($members as $m) {
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td style='mso-number-format:\"\\@\";'>".$m['nis']."</td>";
            echo "<td>".$m['nama_siswa']."</td>";
            echo "<td>".$m['kelas']."</td>";
            foreach ($sesis as $s) {
                $status = $matrix[$m['siswa_id']][$s['id']] ?? '-';
                echo "<td style='text-align:center;'>".$status."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }

    public function export_rekap_pdf() {
        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        if (ob_get_level()) { ob_end_clean(); }

        $sesis = $this->model('Sesi_model')->findByEkskul($ekskul_id);
        $members = $this->model('Pendaftaran_model')->findByEkskul($ekskul_id);
        $allPresensi = $this->model('Presensi_model')->findAllRekapByEkskul($ekskul_id);

        $matrix = [];
        foreach ($allPresensi as $p) {
            $matrix[$p['siswa_id']][$p['sesi_id']] = strtoupper(substr($p['status'], 0, 1));
        }

        echo "<html><head><title>Rekap Matriks Presensi</title><style>
            body { font-family: sans-serif; font-size: 11px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
            th { background-color: #f2f2f2; text-align: center; }
            .text-center { text-align: center; }
        </style></head><body>";
        echo "<h2>Rekapitulasi Presensi Matrix Ekstrakurikuler</h2>";
        echo "<table>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th>";
        foreach ($sesis as $s) {
            echo "<th>P-".$s['pertemuan_ke']."<br>".$s['tanggal']."</th>";
        }
        echo "</tr>";

        $no = 1;
        foreach ($members as $m) {
            echo "<tr>";
            echo "<td class='text-center'>".$no++."</td>";
            echo "<td>".$m['nis']."</td>";
            echo "<td>".$m['nama_siswa']."</td>";
            echo "<td class='text-center'>".$m['kelas']."</td>";
            foreach ($sesis as $s) {
                $status = $matrix[$m['siswa_id']][$s['id']] ?? '-';
                echo "<td class='text-center'><b>".$status."</b></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<script>window.print();</script>";
        echo "</body></html>";
        exit;
    }

    public function export_sesi_excel($sesi_id) {
        if (ob_get_level()) { ob_end_clean(); }
        $sesi = $this->model('Sesi_model')->findById($sesi_id);
        $data = $this->model('Presensi_model')->findBySesi($sesi_id);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Pertemuan_".$sesi['pertemuan_ke']."_".$sesi['tanggal'].".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<h3>Presensi Pertemuan ".$sesi['pertemuan_ke']." (Tanggal: ".$sesi['tanggal'].") - Materi: ".$sesi['materi']."</h3>";
        echo "<table border='1'>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Absen (H/I/S/A)</th><th>Keterangan</th></tr>";
        $no = 1;
        foreach($data as $row) {
            $status_kode = strtoupper(substr($row['status'], 0, 1));
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td style='mso-number-format:\"\\@\";'>".$row['nis']."</td>";
            echo "<td>".$row['nama_siswa']."</td>";
            echo "<td>".$row['kelas']."</td>";
            echo "<td style='text-align:center;'>".$status_kode."</td>";
            echo "<td>".$row['keterangan']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }

    public function export_sesi_pdf($sesi_id) {
        if (ob_get_level()) { ob_end_clean(); }
        $sesi = $this->model('Sesi_model')->findById($sesi_id);
        $data = $this->model('Presensi_model')->findBySesi($sesi_id);

        echo "<html><head><title>Pertemuan ".$sesi['pertemuan_ke']."</title><style>
            body { font-family: sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
            th { background-color: #f2f2f2; }
            .text-center { text-align: center; }
        </style></head><body>";
        echo "<h2>Presensi Pertemuan ".$sesi['pertemuan_ke']."</h2>";
        echo "<p><b>Tanggal:</b> ".$sesi['tanggal']." | <b>Materi:</b> ".$sesi['materi']."</p>";
        echo "<table>";
        echo "<tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th class='text-center'>Absen</th><th>Keterangan</th></tr>";
        $no = 1;
        foreach($data as $row) {
            $status_kode = strtoupper(substr($row['status'], 0, 1));
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$row['nis']."</td>";
            echo "<td>".$row['nama_siswa']."</td>";
            echo "<td>".$row['kelas']."</td>";
            echo "<td class='text-center'><b>".$status_kode."</b></td>";
            echo "<td>".$row['keterangan']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<script>window.print();</script>";
        echo "</body></html>";
        exit;
    }

    public function buatSesi() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $ekskul_id = $_SESSION['pembina']['ekskul_id'];
        $sesiModel = $this->model('Sesi_model');

        $sesiModel->create([
            'ekskul_id'    => $ekskul_id,
            'tanggal'      => $_POST['tanggal'],
            'pertemuan_ke' => $_POST['pertemuan_ke'],
            'materi'       => $_POST['materi'],
            'catatan'      => $_POST['catatan'],
            'dibuat_oleh'  => $_SESSION['pembina']['id'],
        ]);

        header('Location: ' . APP_URL . '/presensi'); exit;
    }

    public function detail($sesi_id) {
        $sesiModel     = $this->model('Sesi_model');
        $presensiModel = $this->model('Presensi_model');
        $pendaftaranModel = $this->model('Pendaftaran_model');

        $sesi = $sesiModel->findById($sesi_id);
        
        // Keamanan: Pastikan sesi ini milik ekskul pembina tersebut
        if ($sesi['ekskul_id'] != $_SESSION['pembina']['ekskul_id']) {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $data = [
            'title'      => 'Catat Presensi',
            'activeMenu' => 'presensi',
            'sesi'       => $sesi,
            'members'    => $pendaftaranModel->findByEkskul($sesi['ekskul_id']),
            'presensis'  => $presensiModel->findBySesi($sesi_id)
        ];

        $this->template('main/header', $data);
        $this->view('main/presensi/detail', $data);
        $this->template('main/footer');
    }

    public function simpan($sesi_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/presensi'); exit;
        }

        $presensiModel = $this->model('Presensi_model');

        foreach ($_POST['status'] as $siswa_id => $status) {
            $presensiModel->save([
                'sesi_id'     => $sesi_id,
                'siswa_id'    => $siswa_id,
                'status'      => $status,
                'keterangan'  => $_POST['keterangan'][$siswa_id] ?? '',
                'dicatat_oleh'=> $_SESSION['pembina']['id'],
            ]);
        }

        header('Location: ' . APP_URL . '/presensi/detail/' . $sesi_id); exit;
    }
}
