<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="text-2xl font-black text-midnight tracking-tight uppercase">Katalog Ekstrakurikuler</h2>
        <p class="text-sm text-slate-500 font-medium">Temukan minat dan bakatmu di sini.</p>
    </div>
    <div class="relative w-full sm:w-64 text-sm font-semibold">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" id="searchEkskul" placeholder="Cari ekskul..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
    </div>
</div>

<div class="space-y-4">
    <?php 
    // Indexing registrations for easy status check
    $regStatus = [];
    foreach ($myRegistrations as $reg) {
        $regStatus[$reg['ekskul_id']] = $reg;
    }

    foreach ($ekskuls as $e): 
        $myReg = $regStatus[$e['id']] ?? null;
    ?>
    <div class="ekskul-item bg-white p-6 rounded-[2rem] border <?= $myReg && $myReg['status'] === 'aktif' ? 'border-primary border-2 shadow-md' : 'border-slate-100 shadow-sm' ?> flex flex-col md:flex-row md:items-center gap-6 relative transition-all group hover:shadow-md">
        <?php if ($myReg && $myReg['status'] === 'aktif'): ?>
        <div class="absolute -top-3 left-6 px-3 py-1 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-md shadow-sm">Ekskul Kamu</div>
        <?php endif; ?>

        <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-50 rounded-2xl flex items-center justify-center text-4xl flex-shrink-0 group-hover:scale-110 transition-transform">
            <?= $e['ikon_emoji'] ?>
        </div>
        
        <div class="flex-1 space-y-1.5 min-w-0">
            <div class="flex items-center gap-3">
                <h5 class="font-extrabold text-midnight text-xl tracking-tight truncate"><?= htmlspecialchars($e['nama']) ?></h5>
                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-bold rounded uppercase tracking-widest"><?= htmlspecialchars($e['kategori']) ?></span>
                <?php if ($myReg): ?>
                    <?php 
                    $statusColor = 'bg-slate-100 text-slate-500';
                    if ($myReg['status'] === 'aktif') $statusColor = 'bg-green-100 text-green-600';
                    if ($myReg['status'] === 'pending') $statusColor = 'bg-orange-100 text-orange-600';
                    if ($myReg['status'] === 'ditolak') $statusColor = 'bg-red-100 text-red-600';
                    ?>
                    <span class="px-2 py-0.5 <?= $statusColor ?> text-[9px] font-bold rounded uppercase tracking-widest"><?= $myReg['status'] ?></span>
                <?php endif; ?>
            </div>
            <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 italic">"<?= htmlspecialchars($e['deskripsi']) ?>"</p>
            <div class="flex flex-wrap gap-4 pt-1">
                <div class="flex items-center gap-2 text-slate-400 text-xs">
                    <i class="bi bi-calendar-event text-primary"></i>
                    <span class="font-bold"><?= $e['hari_latihan'] ?></span>
                </div>
                <div class="flex items-center gap-2 text-slate-400 text-xs">
                    <i class="bi bi-clock text-primary"></i>
                    <span class="font-bold"><?= substr($e['jam_mulai'], 0, 5) ?> - <?= substr($e['jam_selesai'], 0, 5) ?></span>
                </div>
            </div>
        </div>

        <div class="md:w-48 flex-shrink-0">
            <?php if ($myReg): ?>
                <a href="<?= APP_URL ?>/ekskul/detail/<?= $e['id'] ?>" class="block w-full py-3 bg-slate-100 text-slate-500 font-bold rounded-xl text-center text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all">Lihat Detail</a>
            <?php elseif ($e['status_pendaftaran'] === 'Terbuka'): ?>
                <form action="<?= APP_URL ?>/ekskul/daftar/<?= $e['id'] ?>" method="POST" onsubmit="return confirm('Yakin ingin mendaftar ke ekskul ini?')">
                    <button type="submit" class="w-full py-3 bg-midnight text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-midnight/10 active:scale-95">Daftar Sekarang</button>
                </form>
            <?php else: ?>
                <button disabled class="w-full py-3 bg-slate-50 text-slate-300 font-bold rounded-xl border border-slate-100 text-xs uppercase tracking-widest cursor-not-allowed italic">Pendaftaran Tutup</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    document.getElementById('searchEkskul').addEventListener('input', function(e) {
        const q = e.target.value.toLowerCase();
        document.querySelectorAll('.ekskul-item').forEach(item => {
            const text = item.innerText.toLowerCase();
            item.style.display = text.includes(q) ? 'flex' : 'none';
        });
    });
</script>
