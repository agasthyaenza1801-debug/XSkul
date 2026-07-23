<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pembina</p>
        <h4 class="text-3xl font-black text-midnight"><?= $totalPembina ?></h4>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Siswa</p>
        <h4 class="text-3xl font-black text-midnight"><?= $totalSiswa ?></h4>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Member</p>
        <h4 class="text-3xl font-black text-midnight"><?= $totalMember ?></h4>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Ekskul</p>
        <h4 class="text-3xl font-black text-midnight"><?= $totalEkskul ?></h4>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h4 class="font-bold text-midnight">Manajemen Member Terbaru</h4>
        <a href="<?= APP_URL ?>/member" class="px-4 py-2 bg-slate-50 text-admin font-bold text-xs rounded-xl hover:bg-admin hover:text-white transition-all border border-admin/10">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Member</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ekskul</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembina</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($recentMembers as $member): ?>
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-bold text-midnight text-sm"><?= htmlspecialchars($member['nama_siswa']) ?></div>
                        <div class="text-[10px] text-slate-400 font-medium"><?= htmlspecialchars($member['kelas']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-bold rounded-full"><?= htmlspecialchars($member['nama_ekskul']) ?></span>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-600"><?= htmlspecialchars($member['nama_pembina']) ?></td>
                    <td class="px-6 py-4 text-center">
                        <a href="<?= APP_URL ?>/member/hapus/<?= $member['id'] ?>" class="p-2 text-slate-400 hover:text-red-500 inline-block" onclick="return confirm('Keluarkan member ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>