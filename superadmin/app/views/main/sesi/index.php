<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-black text-midnight">Sesi Latihan</h3>
        <p class="text-slate-400 font-medium">Daftar seluruh sesi latihan ekstrakurikuler</p>
    </div>
</div>

<div class="bg-white rounded-[28px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ekskul</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Materi</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($sesis as $s): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($s['nama_ekskul']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight">Pertemuan <?= $s['pertemuan_ke'] ?></div>
                        <div class="text-xs font-semibold text-slate-400"><?= date('d M Y', strtotime($s['tanggal'])) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-midnight"><?= htmlspecialchars($s['materi']) ?></div>
                        <div class="text-[10px] text-slate-400 italic line-clamp-1"><?= htmlspecialchars($s['catatan'] ?? '-') ?></div>
                    </td>
                    <td class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <?= htmlspecialchars($s['dibuat_oleh']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($sesis)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada data sesi latihan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
