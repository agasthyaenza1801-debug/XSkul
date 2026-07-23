<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <a href="<?= APP_URL ?>/ekskul/detail/<?= $ekskul['id'] ?>" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-admin hover:border-admin/30 transition-colors">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h3 class="text-2xl font-black text-midnight">Presensi Latihan</h3>
            <p class="text-slate-400 font-medium text-sm"><?= htmlspecialchars($ekskul['nama']) ?> — Pertemuan <?= $sesi['pertemuan_ke'] ?> (<?= date('d M Y', strtotime($sesi['tanggal'])) ?>)</p>
        </div>
    </div>
    <button form="formPresensi" type="submit" class="px-6 py-3 bg-admin text-white font-bold rounded-2xl shadow-lg shadow-admin/20 hover:bg-adminDark transition-all flex items-center gap-2">
        <i class="bi bi-check-all text-xl"></i>
        Simpan Presensi
    </button>
</div>

<div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
    <form id="formPresensi" action="<?= APP_URL ?>/ekskul/simpanPresensi/<?= $sesi['id'] ?>" method="POST">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status Kehadiran</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php 
                    // Indexing presensi by siswa_id for easy access
                    $currentPresensi = [];
                    foreach ($presensis as $p) {
                        $currentPresensi[$p['siswa_id']] = $p;
                    }

                    foreach ($members as $m): 
                        $p = $currentPresensi[$m['siswa_id']] ?? null;
                        $status = $p['status'] ?? 'H';
                    ?>
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="font-extrabold text-midnight text-sm"><?= htmlspecialchars($m['nama_siswa']) ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase"><?= htmlspecialchars($m['kelas']) ?> • <?= htmlspecialchars($m['nis']) ?></div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <?php 
                                $statusColors = [
                                    'H' => 'peer-checked:bg-green-500',
                                    'I' => 'peer-checked:bg-blue-500',
                                    'S' => 'peer-checked:bg-orange-500',
                                    'A' => 'peer-checked:bg-red-500'
                                ];
                                foreach (['H' => 'H', 'I' => 'I', 'S' => 'S', 'A' => 'A'] as $short => $label): 
                                ?>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status[<?= $m['siswa_id'] ?>]" value="<?= $short ?>" class="hidden peer" <?= $status === $short ? 'checked' : '' ?>>
                                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 font-bold text-xs border border-transparent <?= $statusColors[$short] ?> peer-checked:text-white transition-all">
                                        <?= $label ?>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <input type="text" name="keterangan[<?= $m['siswa_id'] ?>]" value="<?= htmlspecialchars($p['keterangan'] ?? '') ?>" placeholder="Catatan..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs focus:bg-white focus:ring-4 focus:ring-admin/10 focus:border-admin outline-none transition-all font-medium">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<div class="mt-8 flex flex-wrap gap-6 p-6 bg-midnight rounded-[28px] text-white">
    <div class="flex items-center gap-2">
        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
        <span class="text-[10px] font-bold uppercase tracking-widest">H: Hadir</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
        <span class="text-[10px] font-bold uppercase tracking-widest">I: Izin</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-3 h-3 bg-orange-400 rounded-full"></div>
        <span class="text-[10px] font-bold uppercase tracking-widest">S: Sakit</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
        <span class="text-[10px] font-bold uppercase tracking-widest">A: Alpa</span>
    </div>
</div>
