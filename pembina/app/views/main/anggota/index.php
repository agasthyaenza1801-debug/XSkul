<div class="flex items-center justify-between mb-8">
    <h3 class="text-2xl font-black text-midnight">Daftar Anggota Ekskul</h3>
    <span class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-bold"><?= count($members) ?> Anggota Aktif</span>
</div>

<div class="space-y-8">
    <!-- Section Pending (Hanya muncul jika ada) -->
    <?php if (!empty($pending)): ?>
    <div class="bg-white rounded-[2rem] border border-orange-100 shadow-sm overflow-hidden">
        <div class="p-6 bg-orange-50/50 border-b border-orange-100">
            <h4 class="font-black text-orange-600 flex items-center gap-2">
                <i class="bi bi-clock-history"></i>
                Menunggu Persetujuan
            </h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <tbody class="divide-y divide-orange-50">
                    <?php foreach ($pending as $p): ?>
                    <tr class="hover:bg-orange-50/20 transition-colors">
                        <td class="p-6 pl-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center font-bold">
                                    <?= strtoupper(substr($p['nama_siswa'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_siswa']) ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold">NIS: <?= htmlspecialchars($p['nis']) ?> • <?= htmlspecialchars($p['kelas']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-right pr-8">
                            <div class="flex justify-end gap-3">
                                <form action="<?= APP_URL ?>/anggota/approve/<?= $p['id'] ?>" method="POST">
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white text-[10px] font-black rounded-lg hover:bg-green-600 transition-colors uppercase tracking-widest">Setujui</button>
                                </form>
                                <form action="<?= APP_URL ?>/anggota/reject/<?= $p['id'] ?>" method="POST">
                                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-500 text-[10px] font-black rounded-lg hover:bg-red-100 transition-colors uppercase tracking-widest">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section Anggota Aktif -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <h4 class="font-black text-midnight">Anggota Aktif</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-4 pl-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                        <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Kelas</th>
                        <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Bergabung</th>
                        <th class="p-4 pr-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($members as $m): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-8">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-xs">
                                    <?= strtoupper(substr($m['nama_siswa'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-bold text-midnight text-sm"><?= htmlspecialchars($m['nama_siswa']) ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold">NIS: <?= htmlspecialchars($m['nis']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-slate-600 font-bold text-center text-xs"><?= htmlspecialchars($m['kelas']) ?></td>
                        <td class="p-4 text-slate-500 font-medium text-xs"><?= date('d M Y', strtotime($m['tanggal_daftar'])) ?></td>
                        <td class="p-4 pr-8 text-right">
                            <form action="<?= APP_URL ?>/anggota/keluarkan/<?= $m['id'] ?>" method="POST" onsubmit="return confirm('Yakin ingin mengeluarkan siswa ini?')">
                                <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                    <i class="bi bi-person-x text-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada anggota aktif.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
