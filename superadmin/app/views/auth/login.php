<div class="w-full max-w-[420px]">
    <div class="bg-white rounded-[32px] shadow-2xl shadow-admin/10 border border-slate-100 p-10 relative overflow-hidden">
        <div class="relative z-10">
            <div class="w-16 h-16 bg-admin/10 rounded-2xl flex items-center justify-center mb-8 mx-auto">
                <i class="bi bi-shield-lock text-3xl text-admin"></i>
            </div>

            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-midnight tracking-tight">Super Admin</h2>
                <p class="text-slate-400 font-medium mt-2">Control Panel Access</p>
            </div>

            <?php if (isset($error)): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-xs font-bold flex items-center gap-3">
                <i class="bi bi-exclamation-circle-fill text-base"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/auth/login" method="POST" class="space-y-5">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Admin ID</label>
                    <input type="text" name="username" required class="w-full mt-1.5 px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none transition-all font-semibold" placeholder="Username/ID">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <input type="password" name="password" required class="w-full mt-1.5 px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none transition-all font-semibold" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full mt-4 bg-admin hover:bg-adminDark text-white font-bold py-4 rounded-2xl shadow-xl shadow-admin/20 transition-all flex items-center justify-center gap-3 group">
                    Enter Dashboard
                    <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</div>