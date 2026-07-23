<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { admin: '#4F46E5', adminDark: '#4338CA', midnight: '#0F172A' },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex antialiased">

    <aside class="w-64 bg-midnight text-white flex flex-col h-screen sticky top-0 hidden md:flex">
        <div class="p-6 border-b border-white/5">
            <h1 class="text-xl font-extrabold tracking-tighter text-white">XSKUL</h1>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Superadmin</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
            <a href="<?= APP_URL ?>/dashboard" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'dashboard' ? 'bg-admin text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors">
                <i class="bi bi-grid text-lg"></i>
                Overview
            </a>
            <div class="pt-4 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Data Management</div>
            <a href="<?= APP_URL ?>/pembina" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'pembina' ? 'bg-admin text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors">
                <i class="bi bi-person-badge text-lg"></i>
                Data Pembina
            </a>
            <a href="<?= APP_URL ?>/siswa" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'siswa' ? 'bg-admin text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors">
                <i class="bi bi-people text-lg"></i>
                Data Siswa
            </a>
            <a href="<?= APP_URL ?>/ekskul" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'ekskul' ? 'bg-admin text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors">
                <i class="bi bi-trophy text-lg"></i>
                Data Ekskul
            </a>
        </nav>
        <div class="p-4 border-t border-white/5">
            <a href="<?= APP_URL ?>/auth/logout" class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-red-400 rounded-xl font-medium transition-colors text-sm">
                <i class="bi bi-box-arrow-left text-lg"></i>
                Keluar
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">
        <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100 sticky top-0 z-30">
            <h2 class="text-xl font-extrabold text-midnight"><?= $title ?? 'Dashboard' ?></h2>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-midnight hidden sm:block"><?= htmlspecialchars($_SESSION['admin']['nama'] ?? '') ?></span>
                <span class="px-3 py-1 bg-admin text-white text-[10px] font-black rounded-lg uppercase">Super Admin</span>
            </div>
        </header>

        <div class="p-8">