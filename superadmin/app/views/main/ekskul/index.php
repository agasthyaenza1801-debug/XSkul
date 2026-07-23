<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-black text-midnight">Daftar Ekstrakurikuler</h3>
        <p class="text-slate-400 font-medium">Manajemen kategori dan jadwal ekskul</p>
    </div>
    <button onclick="openModal('modalCreate')" class="px-6 py-3 bg-admin text-white font-bold rounded-2xl shadow-lg shadow-admin/20 hover:bg-adminDark transition-all flex items-center gap-2">
        <i class="bi bi-plus-lg text-lg"></i>
        Ekskul Baru
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($ekskuls as $e): ?>
    <div class="bg-white p-6 rounded-[28px] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 bg-slate-50 text-3xl flex items-center justify-center rounded-2xl group-hover:bg-admin/10 transition-colors">
                <?= htmlspecialchars($e['ikon_emoji'] ?? '🏫') ?>
            </div>
            <span class="px-2.5 py-1 text-[10px] font-black rounded-lg uppercase
                <?= $e['status_pendaftaran'] === 'Terbuka' ? 'bg-green-100 text-green-600' : ($e['status_pendaftaran'] === 'Penuh' ? 'bg-red-100 text-red-500' : 'bg-slate-100 text-slate-400') ?>">
                <?= $e['status_pendaftaran'] ?>
            </span>
        </div>

        <h5 class="font-extrabold text-midnight text-lg leading-tight"><?= htmlspecialchars($e['nama']) ?></h5>
        <p class="text-xs font-semibold text-slate-400 mt-1"><?= htmlspecialchars($e['nama_pembina']) ?></p>
        <p class="text-xs text-slate-400 mt-0.5"><?= htmlspecialchars($e['hari_latihan']) ?>, <?= substr($e['jam_mulai'], 0, 5) ?> – <?= substr($e['jam_selesai'], 0, 5) ?></p>

        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-admin"><?= $e['total_anggota'] ?> Members</span>
            <div class="flex items-center gap-1">
                <a href="<?= APP_URL ?>/ekskul/detail/<?= $e['id'] ?>" class="px-3 py-1.5 bg-slate-50 text-midnight text-[10px] font-bold rounded-lg hover:bg-admin hover:text-white transition-all uppercase tracking-wider">Detail</a>
                
                <button onclick="openModalEdit(<?= htmlspecialchars(json_encode($e)) ?>)" class="p-1.5 text-slate-300 hover:text-admin transition-colors rounded-lg hover:bg-slate-50">
                    <i class="bi bi-pencil-square text-base"></i>
                </button>
                
                <button onclick="openModalDelete(<?= $e['id'] ?>, '<?= htmlspecialchars($e['nama']) ?>')" class="p-1.5 text-slate-300 hover:text-red-500 transition-colors rounded-lg hover:bg-slate-50">
                    <i class="bi bi-trash3 text-base"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal Create -->
<div id="modalCreate" class="fixed inset-0 z-50 hidden items-center justify-center bg-midnight/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 flex flex-col max-h-[90vh]">
        <div class="px-8 pt-8 pb-2"><h4 class="text-lg font-extrabold text-midnight">Ekskul Baru</h4></div>
        <form action="<?= APP_URL ?>/ekskul/create" method="POST" class="flex flex-col flex-1 min-h-0" autocomplete="off">
            <div class="overflow-y-auto flex-1 px-8 pt-2 pb-4 space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Ekskul</label>
                    <input type="text" name="nama" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pembina</label>
                    <select name="pembina_id" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                        <option value="">-- Pilih Pembina --</option>
                        <?php foreach ($pembinas as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</label>
                        <select name="kategori" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                            <option value="Olahraga">Olahraga</option>
                            <option value="Seni & Musik">Seni & Musik</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Karakter">Karakter</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ikon Emoji</label>
                        <input type="text" name="ikon_emoji" maxlength="4" placeholder="🏀" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hari Latihan</label>
                    <input type="text" name="hari_latihan" required placeholder="Senin" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jam Selesai</label>
                        <input type="time" name="jam_selesai" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kuota Max</label>
                        <input type="number" name="kuota_max" required min="1" value="40" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</label>
                        <select name="status_pendaftaran" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                            <option value="Terbuka">Terbuka</option>
                            <option value="Tutup">Tutup</option>
                            <option value="Penuh">Penuh</option>
                        </select>
                    </div>
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
        <div class="px-8 pt-8 pb-2"><h4 class="text-lg font-extrabold text-midnight">Edit Ekskul</h4></div>
        <form id="formEdit" action="" method="POST" class="flex flex-col flex-1 min-h-0" autocomplete="off">
            <div class="overflow-y-auto flex-1 px-8 pt-2 pb-4 space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Ekskul</label>
                    <input type="text" name="nama" id="editNama" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pembina</label>
                    <select name="pembina_id" id="editPembinaId" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                        <?php foreach ($pembinas as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Deskripsi</label>
                    <textarea name="deskripsi" id="editDeskripsi" rows="2" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</label>
                        <select name="kategori" id="editKategori" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                            <option value="Olahraga">Olahraga</option>
                            <option value="Seni & Musik">Seni & Musik</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Karakter">Karakter</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ikon Emoji</label>
                        <input type="text" name="ikon_emoji" id="editIkon" maxlength="4" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hari Latihan</label>
                    <input type="text" name="hari_latihan" id="editHari" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="editJamMulai" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="editJamSelesai" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kuota Max</label>
                        <input type="number" name="kuota_max" id="editKuota" required min="1" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</label>
                        <select name="status_pendaftaran" id="editStatus" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-admin focus:ring-4 focus:ring-admin/10 outline-none font-semibold text-sm">
                            <option value="Terbuka">Terbuka</option>
                            <option value="Tutup">Tutup</option>
                            <option value="Penuh">Penuh</option>
                        </select>
                    </div>
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
            <i class="bi bi-trash3-fill text-2xl text-red-500"></i>
        </div>
        <h4 class="text-lg font-extrabold text-midnight mb-1">Hapus Ekskul?</h4>
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
        document.getElementById('editNama').value        = data.nama;
        document.getElementById('editPembinaId').value   = data.pembina_id;
        document.getElementById('editDeskripsi').value   = data.deskripsi ?? '';
        document.getElementById('editKategori').value    = data.kategori;
        document.getElementById('editIkon').value        = data.ikon_emoji ?? '';
        document.getElementById('editHari').value        = data.hari_latihan;
        document.getElementById('editJamMulai').value    = data.jam_mulai;
        document.getElementById('editJamSelesai').value  = data.jam_selesai;
        document.getElementById('editKuota').value       = data.kuota_max;
        document.getElementById('editStatus').value      = data.status_pendaftaran;
        document.getElementById('formEdit').action       = '<?= APP_URL ?>/ekskul/edit/' + data.id;
        openModal('modalEdit');
    }

    function openModalDelete(id, nama) {
        document.getElementById('deleteNama').textContent = nama;
        document.getElementById('formDelete').action      = '<?= APP_URL ?>/ekskul/delete/' + id;
        openModal('modalDelete');
    }
</script>