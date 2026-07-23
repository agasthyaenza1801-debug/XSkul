<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#6366F1', primaryDark: '#4F46E5', midnight: '#0F172A' },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex antialiased">

    <!-- Sidebar -->
    <aside class="w-64 bg-midnight text-white flex flex-col hidden md:flex h-screen sticky top-0 overflow-hidden">
        <div class="p-6 pb-2">
            <h1 class="text-xl font-extrabold tracking-tight flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shadow-lg shadow-primary/20">
                    <i class="bi bi-mortarboard-fill text-white"></i>
                </div>
                Portal Siswa
            </h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
            <a href="<?= APP_URL ?>/dashboard" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'dashboard' ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors text-sm">
                <i class="bi bi-grid-1x2-fill text-lg"></i>
                Dashboard
            </a>
            <a href="<?= APP_URL ?>/ekskul" class="flex items-center gap-3 px-4 py-3 <?= $activeMenu === 'ekskul' ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:bg-white/5 hover:text-white font-medium' ?> rounded-xl transition-colors text-sm">
                <i class="bi bi-compass-fill text-lg"></i>
                Katalog Ekskul
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
        
        <!-- Top Header -->
        <header class="bg-white px-8 py-5 flex items-center justify-between border-b border-slate-100">
            <div>
                <h2 class="text-xl font-bold text-midnight">Halo, <?= explode(' ', $_SESSION['siswa']['nama'])[0] ?>! 👋</h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">NIS: <?= $_SESSION['siswa']['nis'] ?> • <?= $_SESSION['siswa']['kelas'] ?></p>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center font-bold border border-primary/20">
                    <?= strtoupper(substr($_SESSION['siswa']['nama'], 0, 1)) ?>
                </div>
            </div>
        </header>

        <div class="p-8">
