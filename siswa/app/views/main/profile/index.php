<?php
$siswa = $_SESSION['siswa'];
$initial = strtoupper(substr($siswa['nama'], 0, 1));
$months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$createdTimestamp = !empty($siswa['created_at']) ? strtotime($siswa['created_at']) : false;
$createdAt = $createdTimestamp ? date('d', $createdTimestamp) . ' ' . $months[(int)date('n', $createdTimestamp)] . ' ' . date('Y', $createdTimestamp) : '-';
$activeEkskuls = $activeEkskuls ?? [];
?>
<div class="max-w-3xl">
    <?php if (!empty($message)): ?><div class="mb-5 rounded-xl px-4 py-3 text-sm font-semibold <?= $message['type'] === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' ?>"><?= htmlspecialchars($message['text']) ?></div><?php endif; ?>

    <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="h-2 w-full bg-primary"></div>
        <div class="p-6">
            <h1 class="mb-6 border-b border-slate-200 pb-2 text-lg font-bold text-slate-800">Profil Siswa</h1>

            <div class="mb-8 flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-full border-2 border-indigo-200 bg-indigo-100 text-2xl font-bold text-indigo-600">
                    <?= htmlspecialchars($initial) ?>
                </div>
                <h2 class="text-2xl font-bold uppercase text-slate-900"><?= htmlspecialchars($siswa['nama']) ?></h2>
            </div>

            <div class="mb-8 grid grid-cols-[100px_1fr] gap-y-3 text-sm">
                <div class="font-medium tracking-wide text-slate-500">NISN</div>
                <div class="font-semibold text-slate-800"><?= htmlspecialchars($siswa['nisn'] ?? '-') ?></div>

                <div class="font-medium tracking-wide text-slate-500">KELAS</div>
                <div class="font-semibold text-slate-800"><?= htmlspecialchars($siswa['kelas'] ?? '-') ?></div>

                <div class="font-medium tracking-wide text-slate-500">TGL DIBUAT</div>
                <div class="font-semibold text-slate-800"><?= htmlspecialchars($createdAt) ?></div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" data-modal-target="password-modal" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium transition hover:bg-slate-50">Ubah Kata Sandi</button>
                <button type="button" data-modal-target="nama-modal" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium transition hover:bg-slate-50">Ubah Nama</button>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-5 text-lg font-bold text-slate-800">Ekstrakurikuler Aktif</h2>

        <?php if (!empty($activeEkskuls)): ?>
            <div class="mb-6 flex flex-wrap gap-3">
                <?php foreach ($activeEkskuls as $index => $ekskul): ?>
                    <?php $chipColors = ['bg-orange-100 text-orange-800', 'bg-blue-100 text-blue-800', 'bg-pink-100 text-pink-800']; ?>
                    <a href="<?= APP_URL ?>/ekskul/detail/<?= (int)$ekskul['ekskul_id'] ?>" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition hover:brightness-95 <?= $chipColors[$index % count($chipColors)] ?>">
                        <span><?= htmlspecialchars($ekskul['ikon_emoji'] ?? '*') ?></span>
                        <?= htmlspecialchars($ekskul['nama_ekskul']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mb-6 text-sm text-slate-500">Belum ada ekstrakurikuler aktif.</p>
        <?php endif; ?>

        <div class="flex justify-end border-t border-slate-100 pt-4">
            <a href="<?= APP_URL ?>/ekskul" class="rounded-lg border border-indigo-200 px-4 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50">Daftar Ekskul Baru</a>
        </div>
    </div>
</div>
<div id="nama-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center">
    <form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl">
        <div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Nama</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div>
        <input name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-primary">
        <button class="mt-5 w-full rounded-xl bg-primary py-3 text-sm font-bold text-white">Simpan Nama</button>
    </form>
</div>
<div id="password-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center">
    <form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl">
        <div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Password</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div>
        <input type="hidden" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>">
        <div class="space-y-4"><input name="current_password" type="password" required placeholder="Password lama" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password" type="password" required minlength="6" placeholder="Password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password_confirmation" type="password" required minlength="6" placeholder="Konfirmasi password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"></div>
        <button class="mt-5 w-full rounded-xl bg-primary py-3 text-sm font-bold text-white">Simpan Password</button>
    </form>
</div>
<script>
document.querySelectorAll('[data-modal-target]').forEach((button) => button.addEventListener('click', () => { const modal = document.getElementById(button.dataset.modalTarget); modal.classList.remove('hidden'); modal.classList.add('flex'); }));
document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => { const modal = button.closest('[id$="-modal"]'); modal.classList.add('hidden'); modal.classList.remove('flex'); }));
document.querySelectorAll('[id$="-modal"]').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } }));
</script>
