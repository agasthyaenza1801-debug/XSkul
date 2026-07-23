# XSkul - Sistem Manajemen Ekstrakurikuler Sekolah

XSkul adalah platform digital terintegrasi yang dirancang khusus untuk memodernisasi tata kelola kegiatan Ekstrakurikuler (Ekskul) di lingkungan sekolah menengah.

---

## Apa itu Ekstrakurikuler?
Ekstrakurikuler (Ekskul) adalah kegiatan non-akademik di luar jam pelajaran standar sekolah yang bertujuan untuk mengembangkan minat, bakat, kepribadian, dan kepemimpinan siswa. Melalui ekskul, siswa difasilitasi untuk mengeksplorasi potensi diri yang tidak selalu terakomodasi dalam kurikulum formal di kelas, seperti olahraga (basket, futsal), seni (tari, teater), hingga keilmuan dan teknologi (programming, robotik).

## Latar Belakang: Mengapa Aplikasi Ini Diciptakan?
Secara tradisional, pengelolaan kegiatan ekstrakurikuler di banyak sekolah masih menghadapi berbagai kendala administratif:
1. **Pendaftaran Manual yang Merepotkan**: Siswa harus mencari pembina atau mengisi formulir kertas yang rentan hilang atau rusak.
2. **Rekap Presensi Tidak Akurat**: Pembina masih menggunakan buku presensi manual. Sering terjadi "titip absen" atau data yang tidak terbaca, menyulitkan evaluasi keaktifan siswa di akhir semester.
3. **Minimnya Transparansi**: Siswa tidak bisa melihat grafik kehadiran mereka sendiri, dan pihak manajemen sekolah (kepala sekolah/kesiswaan) kesulitan memantau ekskul mana yang aktif dan mana yang vakum.

## Solusi yang Ditawarkan
**XSkul** hadir sebagai solusi sentralisasi data untuk mendigitalkan seluruh ekosistem ekstrakurikuler. Sistem ini memecahkan masalah di atas dengan cara:
*   **Pendaftaran Digital (Siswa)**: Memberikan etalase (Katalog) digital yang memungkinkan siswa mengeksplorasi dan mendaftar ekskul hanya dengan sekali klik.
*   **Absensi Real-Time & Akurat (Pembina)**: Pembina dapat melakukan *check-in* kehadiran siswa (Hadir, Izin, Sakit, Alpa) langsung dari perangkat genggam mereka (HP/Tablet) saat di lapangan. Data langsung tersimpan di database.
*   **Monitoring Komprehensif (Superadmin)**: Memberikan otoritas sekolah pandangan mata elang *(bird's-eye view)* untuk memantau aktivitas semua pembina, jumlah anggota tiap ekskul, hingga persentase kehadiran siswa.

---

## Alur Aplikasi & Arsitektur Sistem

Sistem XSkul dibagi menjadi 3 portal terpisah dengan hak akses (*roles*) yang spesifik:

### 1. Portal Superadmin (Manajemen Sekolah/Kesiswaan)
*Akses:* `/superadmin/public`
*   **Peran**: Pengendali pusat seluruh data master.
*   **Alur Utama**:
    1. Superadmin *login* dan menambahkan daftar Guru Pembina yang bertugas.
    2. Superadmin membuat dan mendaftarkan Ekstrakurikuler baru beserta kuota maksimalnya, lalu mengalokasikan satu Guru Pembina untuk ekskul tersebut.
    3. Superadmin mengelola *database* Siswa.
    4. Dapat memantau log presensi dari seluruh ekskul tanpa terkecuali.

### 2. Portal Pembina (Guru Penanggung Jawab Ekskul)
*Akses:* `/pembina/public`
*   **Peran**: Pengelola lapangan dan eksekutor kegiatan.
*   **Alur Utama**:
    1. Pembina *login* menggunakan NIP.
    2. Di *Dashboard*, Pembina melihat notifikasi jika ada siswa baru yang mendaftar ke ekskulnya. Pembina berhak menekan **Approve (Terima)** atau **Reject (Tolak)**.
    3. Pada hari latihan, Pembina membuat **Sesi Latihan Baru** (Mencatat Pertemuan ke-berapa, Tanggal, dan Materi yang diajarkan).
    4. Pembina mencatat presensi *(H/I/S/A)* seluruh anggota yang hadir pada sesi tersebut dan menyimpannya.

### 3. Portal Siswa
*Akses:* `/siswa/public`
*   **Peran**: Pengguna layanan (Peserta Ekskul).
*   **Alur Utama**:
    1. Siswa *login* menggunakan NIS.
    2. Mengunjungi **Katalog Ekskul** untuk mencari minat bakat mereka.
    3. Jika pendaftaran ekskul berstatus "Terbuka" dan kuota belum penuh, siswa menekan tombol **Daftar Sekarang**.
    4. Setelah di-*approve* oleh Pembina, ekskul tersebut akan muncul di **Dashboard Siswa**.
    5. Siswa tidak perlu mengabsen dirinya sendiri (mencegah kecurangan). Mereka hanya perlu hadir, dan sistem akan menampilkan rekapitulasi kehadiran (Statistik Presensi) mereka secara *real-time* di Dashboard berdasarkan inputan Pembina.

---

## Teknologi yang Digunakan
*   **Arsitektur**: PHP Native dengan pola desain Model-View-Controller (MVC) murni.
*   **Database**: MySQL dengan PDO (PHP Data Objects).
*   **Desain Antarmuka**: Tailwind CSS (Skema warna berbeda untuk setiap *role*: Hitam untuk Superadmin, Biru untuk Pembina, Indigo untuk Siswa).
*   **Routing**: Clean URL Routing menggunakan manipulasi `.htaccess`.
