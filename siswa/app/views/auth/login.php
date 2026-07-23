<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-[420px] relative">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-midnight rounded-full opacity-5"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-primary rounded-full opacity-10 blur-2xl"></div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
            <div class="bg-midnight p-10 pb-14 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary opacity-20 -mr-16 -mt-16 rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                        <i class="bi bi-person-badge text-2xl text-primary"></i>
                    </div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">Portal Siswa</h1>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-[0.2em] mt-1">Eksplorasi & Presensi</p>
                </div>
            </div>

            <div class="p-8 md:p-10 -mt-8 bg-white rounded-[2.5rem] relative z-20">
                <?php if (isset($error)): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-600 text-sm font-bold animate-shake">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= $error ?>
                </div>
                <?php endif; ?>

                <form action="<?= APP_URL ?>/auth/login" method="POST" class="space-y-5">
                    <div>
                        <label class="text-xs font-bold text-midnight/40 ml-1 uppercase tracking-widest">NIS Siswa</label>
                        <input type="text" name="nis" required
                            class="w-full mt-1.5 px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-midnight focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none transition-all duration-300 font-semibold"
                            placeholder="Masukkan NIS">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-midnight/40 ml-1 uppercase tracking-widest">Kata Sandi</label>
                        <input type="password" name="password" required
                            class="w-full mt-1.5 px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-midnight focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none transition-all duration-300 font-semibold"
                            placeholder="••••••••">
                    </div>

                    <button type="submit" 
                        class="w-full mt-4 bg-midnight hover:bg-slate-800 text-white font-bold py-4 rounded-2xl shadow-xl shadow-midnight/20 transition-all duration-300 flex items-center justify-center gap-3 group">
                        <span class="group-hover:text-primary transition-colors">Masuk Sekarang</span>
                        <i class="bi bi-arrow-right text-primary group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">
                        Digital X-Skul Portal
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
</style>
