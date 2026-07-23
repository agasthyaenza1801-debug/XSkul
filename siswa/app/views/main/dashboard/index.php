<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Kehadiran (H)</p>
        <h3 class="text-3xl font-black text-green-500"><?= $stats['H'] ?></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Izin (I)</p>
        <h3 class="text-3xl font-black text-blue-500"><?= $stats['I'] ?></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Sakit (S)</p>
        <h3 class="text-3xl font-black text-orange-500"><?= $stats['S'] ?></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Alpa (A)</p>
        <h3 class="text-3xl font-black text-red-500"><?= $stats['A'] ?></h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- My Ekskuls -->
    <div class="lg:col-span-2 space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-black text-midnight uppercase tracking-wider">Ekskul Saya</h3>
            <a href="<?= APP_URL ?>/ekskul" class="text-xs font-bold text-primary hover:underline">Cari Ekskul Lain</a>
        </div>

        <?php if (empty($myEkskuls)): ?>
        <div class="bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200 p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-search text-3xl"></i>
            </div>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-4">Kamu belum bergabung dengan ekskul manapun</p>
            <a href="<?= APP_URL ?>/ekskul" class="inline-block bg-primary text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-transform text-sm">Lihat Katalog</a>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($myEkskuls as $e): ?>
            <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        <?= $e['ikon_emoji'] ?>
                    </div>
                    <div>
                        <h4 class="font-black text-midnight line-clamp-1"><?= htmlspecialchars($e['nama_ekskul']) ?></h4>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[8px] font-black rounded uppercase tracking-widest"><?= $e['status'] ?></span>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <i class="bi bi-calendar-event text-primary"></i>
                        <span>setiap <?= $e['hari_latihan'] ?></span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <i class="bi bi-clock text-primary"></i>
                        <span><?= substr($e['jam_mulai'], 0, 5) ?> - <?= substr($e['jam_selesai'], 0, 5) ?> WIB</span>
                    </div>
                </div>

                <a href="<?= APP_URL ?>/ekskul/detail/<?= $e['ekskul_id'] ?>" class="block w-full py-2.5 bg-slate-50 text-slate-500 font-bold rounded-xl text-center text-[10px] uppercase tracking-widest hover:bg-primary hover:text-white transition-all">Lihat Detail & Presensi</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Info -->
    <div class="space-y-6">
        <h3 class="text-lg font-black text-midnight uppercase tracking-wider">Info Penting</h3>
        <div class="bg-gradient-to-br from-primary to-indigo-600 rounded-[2rem] p-8 text-white shadow-xl shadow-primary/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-4">Sistem Presensi</p>
            <p class="text-sm font-bold leading-relaxed mb-6">Pastikan kamu selalu hadir tepat waktu. Absensi dilakukan langsung oleh Pembina di lapangan.</p>
            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                <i class="bi bi-info-circle-fill text-xl"></i>
            </div>
        </div>
    </div>
</div>
