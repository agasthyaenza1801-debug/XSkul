<div class="flex items-center justify-between mb-8">
    <h3 class="text-2xl font-black text-midnight">Penilaian Siswa</h3>
    <span class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-bold"><?= count($sesis) ?> Sesi Dinilai</span>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50">
        <h4 class="font-black text-midnight">Daftar Sesi Penilaian</h4>
        <p class="text-xs text-slate-400 font-medium mt-1">Hanya sesi yang ditandai "untuk penilaian" yang tampil di sini.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-4 pl-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pertemuan</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Materi</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Progres Nilai</th>
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
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black <?= $s['total_ternilai'] >= $s['total_dinilai'] && $s['total_dinilai'] > 0 ? 'text-emerald-600' : 'text-orange-500' ?> uppercase tracking-widest">
                            <i class="bi <?= $s['total_ternilai'] >= $s['total_dinilai'] && $s['total_dinilai'] > 0 ? 'bi-check-circle-fill' : 'bi-hourglass-split' ?>"></i>
                            <?= $s['total_ternilai'] ?>/<?= $s['total_dinilai'] ?> Nilai
                        </span>
                    </td>
                    <td class="p-4 pr-8 text-right">
                        <a href="<?= APP_URL ?>/penilaian/detail/<?= $s['id'] ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg hover:bg-primary hover:text-white transition-all uppercase tracking-widest">
                            Lihat Detail
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($sesis)): ?>
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada sesi penilaian. Tandai sesi di menu Presensi dengan opsi "Sesi ini untuk penilaian".</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
