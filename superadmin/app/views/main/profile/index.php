<?php
$admin = $_SESSION['admin'];
$initial = strtoupper(substr($admin['nama'] ?? 'A', 0, 1));
$months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$createdTimestamp = !empty($admin['created_at']) ? strtotime($admin['created_at']) : false;
$createdAt = $createdTimestamp ? date('d', $createdTimestamp) . ' ' . $months[(int)date('n', $createdTimestamp)] . ' ' . date('Y', $createdTimestamp) : '-';
?>
<div class="max-w-3xl">
    <?php if (!empty($message)): ?><div class="mb-5 rounded-xl px-4 py-3 text-sm font-semibold <?= $message['type'] === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' ?>"><?= htmlspecialchars($message['text']) ?></div><?php endif; ?>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="h-2 w-full bg-admin"></div>
        <div class="p-6">
            <h1 class="mb-6 border-b border-slate-200 pb-2 text-lg font-bold text-slate-800">Profil Superadmin</h1>

            <div class="mb-8 flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-full border-2 border-indigo-200 bg-indigo-100 text-2xl font-bold text-indigo-600">
                <?= htmlspecialchars($initial) ?>
                </div>
                <h2 class="text-2xl font-bold uppercase text-slate-900"><?= htmlspecialchars($admin['nama'] ?? '') ?></h2>
            </div>

            <div class="mb-8 grid grid-cols-[120px_1fr] gap-y-3 text-sm">
                <div class="font-medium tracking-wide text-slate-500">USERNAME</div>
                <div class="font-semibold text-slate-800"><?= htmlspecialchars($admin['username'] ?? '-') ?></div>

                <div class="font-medium tracking-wide text-slate-500">TGL DIBUAT</div>
                <div class="font-semibold text-slate-800"><?= htmlspecialchars($createdAt) ?></div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" data-modal-target="password-modal" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium transition hover:bg-slate-50">Ubah Kata Sandi</button>
                <button type="button" data-modal-target="username-modal" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium transition hover:bg-slate-50">Ubah Username</button>
            </div>
        </div>
    </div>
</div>
<div id="username-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center"><form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl"><div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Username</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div><input name="username" value="<?= htmlspecialchars($admin['username'] ?? '') ?>" required class="w-full rounded-xl border border-slate-200 px-4 py-3"><button class="mt-5 w-full rounded-xl bg-admin py-3 text-sm font-bold text-white">Simpan Username</button></form></div>
<div id="password-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center"><form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl"><div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Password</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div><input type="hidden" name="username" value="<?= htmlspecialchars($admin['username'] ?? '') ?>"><div class="space-y-4"><input name="current_password" type="password" required placeholder="Password lama" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password" type="password" required minlength="6" placeholder="Password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password_confirmation" type="password" required minlength="6" placeholder="Konfirmasi password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"></div><button class="mt-5 w-full rounded-xl bg-admin py-3 text-sm font-bold text-white">Simpan Password</button></form></div>
<script>document.querySelectorAll('[data-modal-target]').forEach((button) => button.addEventListener('click', () => { const modal = document.getElementById(button.dataset.modalTarget); modal.classList.remove('hidden'); modal.classList.add('flex'); })); document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => { const modal = button.closest('[id$="-modal"]'); modal.classList.add('hidden'); modal.classList.remove('flex'); })); document.querySelectorAll('[id$="-modal"]').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } }));</script>
