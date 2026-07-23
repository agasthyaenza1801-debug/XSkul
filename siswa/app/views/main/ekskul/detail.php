<div class="flex items-center gap-4 mb-8">
    <a href="<?= APP_URL ?>/ekskul" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary/30 transition-colors">
        <i class="bi bi-chevron-left"></i>
    </a>
    <div>
        <h3 class="text-2xl font-black text-midnight uppercase tracking-tight">Detail Ekstrakurikuler</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Riwayat Kehadiran -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50">
                <h4 class="font-black text-midnight uppercase tracking-widest text-xs">Riwayat Presensi Saya</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-4 pl-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sesi</th>
                            <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Materi</th>
                            <th class="p-4 pr-8 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($presensis as $p): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-8">
                                <div class="font-bold text-midnight text-xs">Pertemuan <?= $p['pertemuan_ke'] ?></div>
                                <div class="text-[10px] text-slate-400 font-bold"><?= date('d M Y', strtotime($p['tanggal'])) ?></div>
                            </td>
                            <td class="p-4 text-slate-500 font-medium text-xs"><?= htmlspecialchars($p['materi'] ?: '-') ?></td>
                            <td class="p-4 pr-8 text-center">
                                <?php 
                                $colors = [
                                    'H' => 'bg-green-100 text-green-600',
                                    'I' => 'bg-blue-100 text-blue-600',
                                    'S' => 'bg-orange-100 text-orange-600',
                                    'A' => 'bg-red-100 text-red-600'
                                ];
                                $labels = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
                                ?>
                                <span class="px-2.5 py-1 <?= $colors[$p['status']] ?? 'bg-slate-100 text-slate-400' ?> text-[10px] font-black rounded-md uppercase">
                                    <?= $labels[$p['status']] ?? $p['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($presensis)): ?>
                        <tr>
                            <td colspan="3" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic tracking-widest">
                                Belum ada riwayat kehadiran di ekskul ini.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm text-center">
            <div class="w-20 h-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center text-5xl mx-auto mb-6">
                <?= $ekskul['ikon_emoji'] ?>
            </div>
            <h4 class="text-xl font-black text-midnight mb-1"><?= htmlspecialchars($ekskul['nama']) ?></h4>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6"><?= htmlspecialchars($ekskul['kategori']) ?></p>
            
            <div class="text-left space-y-4 pt-6 border-t border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-primary">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Status Kamu</p>
                        <p class="text-xs font-black text-midnight uppercase"><?= $registration['status'] ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-primary">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Jadwal Latihan</p>
                        <p class="text-xs font-black text-midnight"><?= $ekskul['hari_latihan'] ?>, <?= substr($ekskul['jam_mulai'], 0, 5) ?> WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
