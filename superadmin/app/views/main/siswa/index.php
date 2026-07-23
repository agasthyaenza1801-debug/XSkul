<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-black text-midnight">Database Siswa</h3>
        <p class="text-slate-400 font-medium">Kelola data seluruh siswa terdaftar</p>
    </div>
    <button onclick="openModal('modalCreate')" class="px-6 py-3 bg-admin text-white font-bold rounded-2xl shadow-lg shadow-admin/20 hover:bg-adminDark transition-all flex items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Siswa
    </button>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">NISN / Nama</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIS</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kelas</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($siswas as $s): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="font-bold text-midnight"><?= htmlspecialchars($s['nama']) ?></div>
                        <div class="text-xs text-slate-400 font-medium"><?= htmlspecialchars($s['nisn']) ?></div>
                    </td>
                    <td class="px-8 py-5 text-sm font-semibold text-slate-600"><?= htmlspecialchars($s['nis']) ?></td>
                    <td class="px-8 py-5 text-sm font-bold text-slate-600"><?= htmlspecialchars($s['kelas']) ?></td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 <?= $s['is_active'] ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' ?> text-[10px] font-black rounded-lg uppercase">
                            <?= $s['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex justify-center gap-2">
                            <button onclick="openModalEdit(<?= htmlspecialchars(json_encode($s)) ?>)" class="p-2.5 bg-slate-100 text-slate-400 hover:text-admin rounded-xl transition-all">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button onclick="openModalDelete(<?= $s['id'] ?>, '<?= htmlspecialchars($s['nama']) ?>')" class="p-2.5 bg-slate-100 text-slate-400 hover:text-red-500 rounded-xl transition-all">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="modalCreate" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 flex flex-col max-h-[90vh]">
        <div class="px-8 pt-8 pb-2"><h4 class="text-lg font-extrabold text-midnight">Tambah Siswa</h4></div>
        <form action="<?= APP_URL ?>/siswa/create" method="POST" class="flex flex-col flex-1 min-h-0" autocomplete="off">
            <div class="overflow-y-auto flex-1 px-8 pt-2 pb-4 space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">NIS</label>
                    <input type="text" name="nis" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">NISN</label>
                    <input type="text" name="nisn" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama</label>
                    <input type="text" name="nama" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kelas</label>
                    <input type="text" name="kelas" required placeholder="XII RPL 1" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Password</label>
                    <input type="password" name="password" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
            </div>
            <div class="px-8 pb-8 pt-4 border-t border-slate-100 flex gap-3">
                <button type="button" onclick="closeModal('modalCreate')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-admin text-white font-bold rounded-xl hover:bg-adminDark transition-all text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 flex flex-col max-h-[90vh]">
        <div class="px-8 pt-8 pb-2"><h4 class="text-lg font-extrabold text-midnight">Edit Siswa</h4></div>
        <form id="formEdit" action="" method="POST" class="flex flex-col flex-1 min-h-0" autocomplete="off">
            <div class="overflow-y-auto flex-1 px-8 pt-2 pb-4 space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">NIS</label>
                    <input type="text" name="nis" id="editNis" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">NISN</label>
                    <input type="text" name="nisn" id="editNisn" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama</label>
                    <input type="text" name="nama" id="editNama" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kelas</label>
                    <input type="text" name="kelas" id="editKelas" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
            </div>
            <div class="px-8 pb-8 pt-4 border-t border-slate-100 flex gap-3">
                <button type="button" onclick="closeModal('modalEdit')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-admin text-white font-bold rounded-xl hover:bg-adminDark transition-all text-sm">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div id="modalDelete" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-sm mx-4 p-8 text-center">
        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-trash text-2xl text-red-500"></i>
        </div>
        <h4 class="text-lg font-extrabold text-midnight mb-1">Hapus Siswa?</h4>
        <p class="text-slate-400 text-sm font-medium mb-6">Aksi ini tidak bisa dibatalkan. <span id="deleteNama" class="font-bold text-midnight"></span> akan dihapus permanen.</p>
        <form id="formDelete" action="" method="POST" class="flex gap-3">
            <button type="button" onclick="closeModal('modalDelete')" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
            <button type="submit" class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all text-sm">Hapus</button>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        if (id === 'modalCreate') document.getElementById('modalCreate').querySelector('form').reset();
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }
    function openModalEdit(data) {
        document.getElementById('editNis').value   = data.nis;
        document.getElementById('editNisn').value  = data.nisn;
        document.getElementById('editNama').value  = data.nama;
        document.getElementById('editKelas').value = data.kelas;
        document.getElementById('formEdit').action = '<?= APP_URL ?>/siswa/edit/' + data.id;
        openModal('modalEdit');
    }
    function openModalDelete(id, nama) {
        document.getElementById('deleteNama').textContent = nama;
        document.getElementById('formDelete').action      = '<?= APP_URL ?>/siswa/delete/' + id;
        openModal('modalDelete');
    }
</script>