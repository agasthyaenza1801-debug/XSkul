<?php
$admin = $_SESSION['admin'];
$initial = strtoupper(substr($admin['nama'] ?? 'A', 0, 1));
?>
<div class="max-w-3xl mx-auto">
    <?php if (!empty($message)): ?><div class="mb-5 rounded-xl px-4 py-3 text-sm font-semibold <?= $message['type'] === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' ?>"><?= htmlspecialchars($message['text']) ?></div><?php endif; ?>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="bg-admin px-8 py-10 text-white">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-3xl font-extrabold border-4 border-white/30">
                <?= htmlspecialchars($initial) ?>
            </div>
            <h1 class="mt-5 text-2xl font-extrabold"><?= htmlspecialchars($admin['nama'] ?? '') ?></h1>
            <p class="mt-1 text-sm text-white/75">Profil Superadmin</p>
        </div>
        <div class="p-8">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Username</p>
            <p class="mt-1 font-bold text-midnight"><?= htmlspecialchars($admin['username'] ?? '') ?></p>
        </div>
        <div class="px-8 pb-8 flex flex-wrap gap-3">
            <button type="button" data-modal-target="username-modal" class="px-4 py-2.5 rounded-xl bg-admin text-white text-sm font-bold hover:bg-adminDark">Ubah Username</button>
            <button type="button" data-modal-target="password-modal" class="px-4 py-2.5 rounded-xl border border-slate-200 text-midnight text-sm font-bold hover:bg-slate-50">Ubah Password</button>
        </div>
    </div>
</div>
<div id="username-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center"><form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl"><div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Username</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div><input name="username" value="<?= htmlspecialchars($admin['username'] ?? '') ?>" required class="w-full rounded-xl border border-slate-200 px-4 py-3"><button class="mt-5 w-full rounded-xl bg-admin py-3 text-sm font-bold text-white">Simpan Username</button></form></div>
<div id="password-modal" class="hidden fixed inset-0 z-50 bg-midnight/50 p-4 items-center justify-center"><form method="post" action="<?= APP_URL ?>/profile/update" class="relative w-full max-w-md bg-white rounded-2xl p-6 shadow-xl"><div class="mb-5"><h2 class="text-lg font-extrabold text-midnight">Ubah Password</h2><button type="button" data-modal-close aria-label="Tutup popup" title="Tutup" class="absolute top-3 right-3 text-slate-400 text-2xl leading-none hover:text-midnight">&times;</button></div><input type="hidden" name="username" value="<?= htmlspecialchars($admin['username'] ?? '') ?>"><div class="space-y-4"><input name="current_password" type="password" required placeholder="Password lama" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password" type="password" required minlength="6" placeholder="Password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"><input name="new_password_confirmation" type="password" required minlength="6" placeholder="Konfirmasi password baru" class="w-full rounded-xl border border-slate-200 px-4 py-3"></div><button class="mt-5 w-full rounded-xl bg-admin py-3 text-sm font-bold text-white">Simpan Password</button></form></div>
<script>document.querySelectorAll('[data-modal-target]').forEach((button) => button.addEventListener('click', () => { const modal = document.getElementById(button.dataset.modalTarget); modal.classList.remove('hidden'); modal.classList.add('flex'); })); document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => { const modal = button.closest('[id$="-modal"]'); modal.classList.add('hidden'); modal.classList.remove('flex'); })); document.querySelectorAll('[id$="-modal"]').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } }));</script>
