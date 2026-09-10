<?php
$siswa = $_SESSION['siswa'];
$initial = strtoupper(substr($siswa['nama'], 0, 1));
?>
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="bg-primary px-8 py-10 text-white">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-3xl font-extrabold border-4 border-white/30">
                <?= htmlspecialchars($initial) ?>
            </div>
            <h1 class="mt-5 text-2xl font-extrabold"><?= htmlspecialchars($siswa['nama']) ?></h1>
            <p class="mt-1 text-sm text-white/75">Profil Siswa</p>
        </div>
        <div class="p-8 grid gap-5 sm:grid-cols-2">
            <div><p class="text-xs font-bold uppercase tracking-wider text-slate-400">NIS</p><p class="mt-1 font-bold text-midnight"><?= htmlspecialchars($siswa['nis']) ?></p></div>
            <div><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Kelas</p><p class="mt-1 font-bold text-midnight"><?= htmlspecialchars($siswa['kelas']) ?></p></div>
        </div>
    </div>
</div>
