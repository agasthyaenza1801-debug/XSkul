<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-black text-midnight">Data Presensi</h3>
        <p class="text-slate-400 font-medium">Monitoring kehadiran siswa dalam latihan</p>
    </div>
</div>

<div class="bg-white rounded-[28px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ekskul / Sesi</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($presensis as $p): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_siswa']) ?></div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase"><?= htmlspecialchars($p['nis']) ?> • <?= htmlspecialchars($p['kelas']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_ekskul']) ?></div>
                        <div class="text-xs font-semibold text-slate-400">Pertemuan <?= $p['pertemuan_ke'] ?> • <?= date('d M Y', strtotime($p['tanggal'])) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-[10px] font-black rounded-lg uppercase
                            <?= $p['status'] === 'Hadir' ? 'bg-green-100 text-green-600' : ($p['status'] === 'Alpa' ? 'bg-red-100 text-red-500' : 'bg-amber-100 text-amber-600') ?>">
                            <?= $p['status'] ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-400 font-medium">
                        <?= htmlspecialchars($p['keterangan'] ?: '-') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($presensis)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada data presensi.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
