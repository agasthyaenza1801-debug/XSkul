<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-black text-midnight">Data Pendaftaran</h3>
        <p class="text-slate-400 font-medium">Riwayat pendaftaran siswa ke ekstrakurikuler</p>
    </div>
</div>

<div class="bg-white rounded-[28px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ekskul</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Daftar</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($pendaftarans as $p): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_siswa']) ?></div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase"><?= htmlspecialchars($p['nis']) ?> • <?= htmlspecialchars($p['kelas']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_ekskul']) ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-500">
                        <?= date('d M Y', strtotime($p['tanggal_daftar'])) ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-[10px] font-black rounded-lg uppercase
                            <?= $p['status'] === 'aktif' ? 'bg-green-100 text-green-600' : ($p['status'] === 'keluar' ? 'bg-red-100 text-red-500' : 'bg-slate-100 text-slate-400') ?>">
                            <?= $p['status'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($pendaftarans)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic">Belum ada data pendaftaran.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
