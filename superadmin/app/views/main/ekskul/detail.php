<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <a href="<?= APP_URL ?>/ekskul" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-admin hover:border-admin/30 transition-colors">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <h3 class="text-2xl font-black text-midnight"><?= htmlspecialchars($ekskul['nama']) ?></h3>
            </div>
            <p class="text-slate-400 font-medium text-sm">Data Ekskul → Detail</p>
        </div>
    </div>
    <div class="flex gap-3">
        <button onclick="openModal('modalSesi')" class="px-5 py-2.5 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm flex items-center gap-2">
            <i class="bi bi-calendar-plus text-base"></i>
            Sesi Baru
        </button>
        <button onclick="openModal('modalTambah')" class="px-5 py-2.5 bg-admin text-white font-bold rounded-xl hover:bg-adminDark transition-all text-sm shadow-lg shadow-admin/20 flex items-center gap-2">
            <i class="bi bi-person-plus-fill text-base"></i>
            Tambah Anggota
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Kiri: Info & Anggota -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Anggota</p>
                <h4 class="text-3xl font-black text-midnight"><?= count($members) ?> <span class="text-sm font-medium text-slate-300">/ <?= $ekskul['kuota_max'] ?></span></h4>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jadwal Rutin</p>
                <h4 class="text-base font-black text-midnight leading-tight mt-1"><?= htmlspecialchars($ekskul['hari_latihan']) ?><br>
                    <span class="text-slate-400 font-semibold text-sm"><?= substr($ekskul['jam_mulai'], 0, 5) ?> – <?= substr($ekskul['jam_selesai'], 0, 5) ?> WIB</span>
                </h4>
            </div>
        </div>

        <!-- Tabel anggota -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-bold text-midnight">Daftar Anggota Aktif</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama / NIS</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($members as $m): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-midnight text-sm"><?= htmlspecialchars($m['nama_siswa']) ?></div>
                                <div class="text-[10px] text-slate-400 font-medium"><?= htmlspecialchars($m['kelas']) ?> • NIS: <?= htmlspecialchars($m['nis']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openModalKeluarkan(<?= $m['id'] ?>, '<?= htmlspecialchars($m['nama_siswa']) ?>')"
                                    class="p-2 text-slate-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50">
                                    <i class="bi bi-trash3 text-base"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($members)): ?>
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-slate-400 text-sm font-medium">Belum ada anggota aktif.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Sesi Latihan & Presensi -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h4 class="font-bold text-midnight">Riwayat Sesi Latihan</h4>
            </div>
            <div class="p-6 space-y-4">
                <?php foreach ($sesis as $s): ?>
                <a href="<?= APP_URL ?>/ekskul/presensi/<?= $s['id'] ?>" class="block p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-admin/30 hover:bg-white transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-0.5 bg-admin/10 text-admin text-[10px] font-black rounded-md uppercase">Pertemuan <?= $s['pertemuan_ke'] ?></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase"><?= date('d M Y', strtotime($s['tanggal'])) ?></span>
                    </div>
                    <h5 class="font-extrabold text-midnight text-sm group-hover:text-admin transition-colors"><?= htmlspecialchars($s['materi']) ?></h5>
                    <p class="text-[10px] text-slate-400 mt-1 line-clamp-1 font-medium italic"><?= htmlspecialchars($s['catatan'] ?: 'Tidak ada catatan') ?></p>
                </a>
                <?php endforeach; ?>
                
                <?php if (empty($sesis)): ?>
                <div class="py-10 text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <i class="bi bi-calendar-x text-2xl"></i>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Belum ada sesi latihan.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sesi Baru -->
<div id="modalSesi" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 p-8">
        <h4 class="text-lg font-extrabold text-midnight mb-6">Buat Sesi Baru</h4>
        <form action="<?= APP_URL ?>/ekskul/buatSesi/<?= $ekskul['id'] ?>" method="POST" class="space-y-4" autocomplete="off">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</label>
                    <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pertemuan Ke-</label>
                    <input type="number" name="pertemuan_ke" required value="<?= count($sesis) + 1 ?>" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Materi Latihan</label>
                <input type="text" name="materi" required placeholder="Contoh: Dasar-dasar HTML" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Catatan (Opsional)</label>
                <textarea name="catatan" rows="2" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalSesi')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm">Buat Sesi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Anggota -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-sm mx-4 p-8">
        <h4 class="text-lg font-extrabold text-midnight mb-6">Tambah Anggota</h4>
        <form action="<?= APP_URL ?>/ekskul/tambahAnggota/<?= $ekskul['id'] ?>" method="POST" class="space-y-4" autocomplete="off">
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pilih Siswa</label>
                <select name="siswa_id" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    <option value="">-- Pilih Siswa --</option>
                    <?php foreach ($siswaAvailable as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?> — <?= htmlspecialchars($s['kelas']) ?> (<?= htmlspecialchars($s['nis']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalTambah')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-admin text-white font-bold rounded-xl hover:bg-adminDark transition-all text-sm">Tambah</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Keluarkan -->
<div id="modalKeluarkan" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-sm mx-4 p-8 text-center">
        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-box-arrow-right text-2xl text-red-500"></i>
        </div>
        <h4 class="text-lg font-extrabold text-midnight mb-1">Keluarkan Anggota?</h4>
        <p class="text-slate-400 text-sm font-medium mb-6"><span id="keluarkanNama" class="font-bold text-midnight"></span> akan dikeluarkan dari ekskul ini.</p>
        <form id="formKeluarkan" action="" method="POST" class="flex gap-3">
            <button type="button" onclick="closeModal('modalKeluarkan')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
            <button type="submit" class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all text-sm">Keluarkan</button>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        if (id === 'modalTambah') document.getElementById('modalTambah').querySelector('form').reset();
        if (id === 'modalSesi') document.getElementById('modalSesi').querySelector('form').reset();
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openModalKeluarkan(id, nama) {
        document.getElementById('keluarkanNama').textContent  = nama;
        document.getElementById('formKeluarkan').action       = '<?= APP_URL ?>/ekskul/keluarkan/' + id;
        openModal('modalKeluarkan');
    }
</script>