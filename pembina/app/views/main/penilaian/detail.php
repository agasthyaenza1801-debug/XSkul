<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <a href="<?= APP_URL ?>/penilaian" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary/30 transition-colors">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h3 class="text-2xl font-black text-midnight">Input Penilaian</h3>
            <p class="text-slate-400 font-medium text-sm">Pertemuan <?= $sesi['pertemuan_ke'] ?> — <?= date('d M Y', strtotime($sesi['tanggal'])) ?></p>
        </div>
    </div>
    <button form="formPenilaian" type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primaryDark transition-all flex items-center gap-2">
        <i class="bi bi-check-all text-xl"></i>
        Simpan Penilaian
    </button>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <form id="formPenilaian" action="<?= APP_URL ?>/penilaian/simpan/<?= $sesi['id'] ?>" method="POST">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Presensi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Nilai</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($members as $m): ?>
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-xs">
                                    <?= strtoupper(substr($m['nama'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-extrabold text-midnight text-sm"><?= htmlspecialchars($m['nama']) ?></div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase"><?= htmlspecialchars($m['kelas']) ?> • <?= htmlspecialchars($m['nis']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <?php if ($m['presensi_status']): ?>
                            <?php
                            $presensiBadge = [
                                'H' => 'bg-green-100 text-green-600',
                                'I' => 'bg-blue-100 text-blue-600',
                                'S' => 'bg-orange-100 text-orange-600',
                                'A' => 'bg-red-100 text-red-600'
                            ];
                            $presensiLabel = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
                            ?>
                            <span class="px-2.5 py-1 <?= $presensiBadge[$m['presensi_status']] ?> text-[10px] font-black rounded-md uppercase tracking-widest"><?= $presensiLabel[$m['presensi_status']] ?></span>
                            <?php else: ?>
                            <span class="text-slate-300 text-xs font-bold">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5">
                            <?php if ($m['presensi_id']): ?>
                            <input type="number" name="nilai[<?= $m['presensi_id'] ?>]" min="0" max="100" step="0.01" value="<?= $m['nilai'] !== null ? htmlspecialchars($m['nilai'] + 0) : '' ?>"
                                placeholder="0-100"
                                class="w-24 mx-auto bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs text-center focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all font-bold">
                            <?php else: ?>
                            <span class="text-slate-300 text-xs font-bold italic">Belum diabsen</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5">
                            <?php if ($m['presensi_id']): ?>
                            <input type="text" name="keterangan[<?= $m['presensi_id'] ?>]" value="<?= htmlspecialchars($m['penilaian_keterangan'] ?? '') ?>"
                                placeholder="Catatan penilaian..."
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all font-medium">
                            <?php else: ?>
                            <span class="text-slate-300 text-xs font-bold italic">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada anggota aktif di ekskul ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<div class="mt-8 flex flex-wrap gap-6 p-6 bg-midnight rounded-[2rem] text-white">
    <div class="flex items-center gap-2">
        <i class="bi bi-info-circle text-primary"></i>
        <span class="text-[10px] font-bold uppercase tracking-widest">Nilai dalam rentang 0-100. Kosongkan nilai lalu simpan untuk menghapus penilaian.</span>
    </div>
</div>
