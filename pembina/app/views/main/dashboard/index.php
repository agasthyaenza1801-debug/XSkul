<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:border-primary/30 transition-all">
        <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.1em] mb-1">Total Anggota</p>
        <h3 class="text-3xl font-black text-midnight"><?= $stats['total'] ?> <span class="text-sm font-medium text-slate-300">/ <?= $ekskul['kuota_max'] ?></span></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:border-orange-500/30 transition-all">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.1em] mb-1">Menunggu Approval</p>
        <h3 class="text-3xl font-black text-orange-500"><?= $stats['pending'] ?></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:border-green-500/30 transition-all">
        <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform"></div>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.1em] mb-1">Kehadiran Hari Ini</p>
        <h3 class="text-3xl font-black text-green-500"><?= $stats['attendance'] ?>%</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Pendaftar Baru -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h4 class="font-black text-midnight">Pendaftar Baru</h4>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Butuh Persetujuan Anda</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-midnight text-white text-[10px] font-black px-4 py-2 rounded-xl hover:bg-slate-800 transition-colors uppercase tracking-widest">
                        Semua Pendaftar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-4 pl-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa</th>
                            <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Kelas</th>
                            <th class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php foreach ($pending as $p): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-slate-500 text-xs">
                                        <?= strtoupper(substr($p['nama_siswa'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-midnight"><?= htmlspecialchars($p['nama_siswa']) ?></div>
                                        <div class="text-[10px] text-slate-400 font-bold">NIS: <?= htmlspecialchars($p['nis']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-slate-500 font-bold text-center text-xs"><?= htmlspecialchars($p['kelas']) ?></td>
                            <td class="p-4 pr-8 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="<?= APP_URL ?>/anggota/approve/<?= $p['id'] ?>" method="POST">
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Setujui">
                                            <i class="bi bi-check-lg text-lg"></i>
                                        </button>
                                    </form>
                                    <form action="<?= APP_URL ?>/anggota/reject/<?= $p['id'] ?>" method="POST">
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                            <i class="bi bi-x-lg text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pending)): ?>
                        <tr>
                            <td colspan="3" class="p-10 text-center text-slate-400 text-xs font-bold uppercase italic tracking-widest">
                                Tidak ada pendaftar baru saat ini.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-slate-50/50 text-center border-t border-slate-50">
                <a href="<?= APP_URL ?>/anggota" class="text-[10px] font-black text-primary hover:underline italic uppercase tracking-widest">Lihat Semua Anggota</a>
            </div>
        </div>
    </div>

    <!-- Info Ekskul -->
    <div>
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center text-3xl shadow-lg shadow-primary/20">
                    <?= $ekskul['ikon_emoji'] ?>
                </div>
                <div>
                    <h4 class="font-black text-midnight"><?= htmlspecialchars($ekskul['nama']) ?></h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= htmlspecialchars($ekskul['kategori']) ?></p>
                </div>
            </div>
            
            <div class="space-y-4 pt-4 border-t border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Jadwal Latihan</p>
                        <p class="text-xs font-bold text-midnight"><?= $ekskul['hari_latihan'] ?>, <?= substr($ekskul['jam_mulai'], 0, 5) ?> - <?= substr($ekskul['jam_selesai'], 0, 5) ?> WIB</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Status Pendaftaran</p>
                        <p class="text-xs font-bold <?= $ekskul['status_pendaftaran'] === 'Terbuka' ? 'text-green-500' : 'text-red-500' ?>"><?= $ekskul['status_pendaftaran'] ?></p>
                    </div>
                </div>
            </div>

            <a href="<?= APP_URL ?>/presensi" class="block w-full bg-primary hover:bg-primaryDark text-white text-center font-bold py-3.5 rounded-2xl shadow-lg shadow-primary/20 transition-all active:scale-95 text-xs">
                Mulai Presensi Hari Ini
            </a>
        </div>
    </div>
</div>
