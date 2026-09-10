<?php if (isset($error)): ?>
<div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-xs font-bold flex items-center gap-3">
    <i class="bi bi-exclamation-circle-fill text-base"></i>
    <?= $error ?>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-8">
    <h3 class="text-2xl font-black text-midnight">Presensi Siswa</h3>
    <button onclick="document.getElementById('modalSesi').classList.remove('hidden'); document.getElementById('modalSesi').classList.add('flex')" 
        class="px-5 py-2.5 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm flex items-center gap-2">
        <i class="bi bi-calendar-plus text-base"></i>
        Buat Sesi Baru
    </button>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50">
        <h4 class="font-black text-midnight">Riwayat Sesi Latihan</h4>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-4 pl-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pertemuan</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Materi</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Penilaian</th>
                    <th class="p-4 pr-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($sesis as $s): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-4 pl-8">
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-md uppercase">Pertemuan <?= $s['pertemuan_ke'] ?></span>
                    </td>
                    <td class="p-4 text-midnight font-bold text-sm"><?= date('d M Y', strtotime($s['tanggal'])) ?></td>
                    <td class="p-4 text-slate-500 font-medium text-sm"><?= htmlspecialchars($s['materi']) ?></td>
                    <td class="p-4 text-center">
                        <?php if (!empty($s['is_penilaian'])): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-md uppercase tracking-widest">
                            <i class="bi bi-star-fill text-[8px]"></i>
                            Dinilai
                        </span>
                        <?php else: ?>
                        <span class="text-slate-300 text-xs font-bold">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 pr-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="bukaEditSesi(<?= $s['id'] ?>, '<?= $s['tanggal'] ?>', <?= $s['pertemuan_ke'] ?>, '<?= htmlspecialchars($s['materi'], ENT_QUOTES) ?>', '<?= htmlspecialchars($s['catatan'] ?? '', ENT_QUOTES) ?>', <?= !empty($s['is_penilaian']) ? 'true' : 'false' ?>)" 
                                class="p-2 text-slate-300 hover:text-primary transition-colors" title="Edit Sesi">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </button>
                            <a href="<?= APP_URL ?>/presensi/detail/<?= $s['id'] ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg hover:bg-primary hover:text-white transition-all uppercase tracking-widest">
                                Catat Absen
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($sesis)): ?>
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada riwayat sesi latihan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Sesi Baru -->
<div id="modalSesi" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 p-8">
        <h4 class="text-lg font-extrabold text-midnight mb-6">Buat Sesi Latihan Baru</h4>
        <form action="<?= APP_URL ?>/presensi/buatSesi" method="POST" class="space-y-4" autocomplete="off">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</label>
                    <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pertemuan Ke-</label>
                    <input type="number" name="pertemuan_ke" required value="<?= count($sesis) + 1 ?>" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Materi Latihan</label>
                <input type="text" name="materi" required placeholder="Contoh: Teknik Dasar Dribbling" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="2" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm resize-none"></textarea>
            </div>
            <label class="flex items-center gap-3 p-4 bg-primary/5 border border-primary/20 rounded-xl cursor-pointer">
                <input type="checkbox" name="is_penilaian" value="1" class="w-4 h-4 accent-primary">
                <span class="text-xs font-bold text-midnight">Sesi ini untuk penilaian <span class="text-slate-400 font-medium">(muncul di menu Penilaian)</span></span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalSesi').classList.add('hidden');" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm">Buat Sesi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Sesi -->
<div id="modalEditSesi" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 p-8">
        <h4 class="text-lg font-extrabold text-midnight mb-6">Edit Sesi Latihan</h4>
        <form id="formEditSesi" action="" method="POST" class="space-y-4" autocomplete="off">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</label>
                    <input type="date" name="tanggal" id="editTanggal" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pertemuan Ke-</label>
                    <input type="number" name="pertemuan_ke" id="editPertemuan" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Materi Latihan</label>
                <input type="text" name="materi" id="editMateri" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" id="editCatatan" rows="2" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none font-semibold text-sm resize-none"></textarea>
            </div>
            <label class="flex items-center gap-3 p-4 bg-primary/5 border border-primary/20 rounded-xl cursor-pointer">
                <input type="checkbox" name="is_penilaian" value="1" id="editPenilaian" class="w-4 h-4 accent-primary">
                <span class="text-xs font-bold text-midnight">Sesi ini untuk penilaian <span class="text-slate-400 font-medium">(muncul di menu Penilaian)</span></span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalEditSesi').classList.add('hidden');" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaEditSesi(id, tanggal, pertemuan, materi, catatan, isPenilaian) {
    const modal = document.getElementById('modalEditSesi');
    document.getElementById('formEditSesi').action = '<?= APP_URL ?>/presensi/editSesi/' + id;
    document.getElementById('editTanggal').value = tanggal;
    document.getElementById('editPertemuan').value = pertemuan;
    document.getElementById('editMateri').value = materi;
    document.getElementById('editCatatan').value = catatan;
    document.getElementById('editPenilaian').checked = isPenilaian;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
