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
                    <td class="p-4 pr-8 text-right">
                        <a href="<?= APP_URL ?>/presensi/detail/<?= $s['id'] ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg hover:bg-primary hover:text-white transition-all uppercase tracking-widest">
                            Catat Absen
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($sesis)): ?>
                <tr>
                    <td colspan="4" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada riwayat sesi latihan.</td>
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
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalSesi').classList.add('hidden');" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-midnight text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm">Buat Sesi</button>
            </div>
        </form>
    </div>
</div>
