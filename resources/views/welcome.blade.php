<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online Modern - Tahun Ajaran 2026/2027</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#0f766e">
<meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f766e',
                        secondary: '#1e293b',
                        accent: '#f59e0b',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-teal-500 selection:text-white" x-data="{ simpleMode: false, showStatusModal: false }">

    <!-- TOP ANNOUNCEMENT BAR -->
    <div class="bg-emerald-800 text-emerald-100 text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-inner flex justify-between items-center max-w-7xl mx-auto rounded-b-xl">
        <div class="flex items-center gap-2 mx-auto">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-500 text-white animate-pulse">
                <i class="fa-solid fa-circle text-[8px] mr-1"></i> Pendaftaran Dibuka
            </span>
            <span>Gelombang 1: Sisa Kuota Terbuka <strong>148 Kursi</strong> (Total 288)</span>
        </div>
        <button @click="simpleMode = !simpleMode" class="hidden md:flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-600 text-white px-3 py-1 rounded-lg text-xs font-semibold transition">
            <i class="fa-solid fa-glasses"></i>
            <span x-text="simpleMode ? 'Mode Normal' : 'Mode Teks Besar (Sederhana)'"></span>
        </button>
    </div>

    <!-- NAVBAR -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-teal-700 text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-teal-700/30">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 tracking-tight leading-none text-lg" :class="simpleMode ? 'text-2xl' : 'text-lg'">
                        PPDB ONLINE <span class="text-teal-700">MA / YAYASAN</span>
                    </h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Tahun Ajaran 2026/2027 • Kurikulum Merdeka</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="#cek-status" @click="showStatusModal = true" class="hidden sm:inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-sm transition">
                    <i class="fa-solid fa-magnifying-glass text-teal-600"></i> Cek Status
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-md shadow-teal-700/20 transition transform active:scale-95">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Akun
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative py-12 md:py-20 overflow-hidden bg-gradient-to-b from-teal-50/50 via-white to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block px-4 py-1.5 bg-teal-100 text-teal-800 rounded-full font-bold text-xs sm:text-sm mb-4 border border-teal-200 shadow-sm">
                    ✨ Pendaftaran Mandiri Tanpa Ribet & Bebas Biaya Admin
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-6" :class="simpleMode ? 'text-4xl sm:text-6xl' : ''">
                    Daftar Sekolah Cukup <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-700 to-emerald-600">1 Menit Dari HP</span>
                </h2>
                <p class="text-slate-600 text-base sm:text-lg mb-8 leading-relaxed font-normal" :class="simpleMode ? 'text-xl font-medium' : ''">
                    Sistem pendaftaran PPDB modern tanpa antre. Daftarkan putra-putri Anda dalam 1 menit dengan alur zero-friction dan transparansi beasiswa.
                </p>

                <!-- CTA BUTTONS -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('pendaftar.formulir') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-lg px-8 py-4 rounded-2xl shadow-lg shadow-teal-700/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                        <i class="fa-solid fa-file-pen text-xl"></i>
                        <span>Daftar Sekarang (1 Menit)</span>
                    </a>
                    <button @click="showStatusModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-white hover:bg-slate-100 text-slate-800 font-bold text-lg px-8 py-4 rounded-2xl border border-slate-200 shadow-sm transition">
                        <i class="fa-solid fa-magnifying-glass text-teal-700"></i>
                        <span>Cek Status Pendaftaran</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 ALUR LENGKAP CARD SECTION -->
    <section class="py-12 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-bold text-slate-900">4 Langkah Mudah Mendaftar</h3>
                <p class="text-slate-500 text-sm mt-1">Proses cepat tanpa perlu fotokopi berkas berulang kali</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- STEP 1 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80 hover:border-teal-300 transition hover:shadow-lg group">
                    <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-teal-700 group-hover:text-white transition">
                        01
                    </div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Form 1-Menit</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Kunci kursi Anda kurang dari 60 detik hanya bermodal NIK & HP.</p>
                </div>

                <!-- STEP 2 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80 hover:border-teal-300 transition hover:shadow-lg group">
                    <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-teal-700 group-hover:text-white transition">
                        02
                    </div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Pilih Klaster</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Pilihan klaster spesifik: Keagamaan, STEM, Soshum, atau Vokasi.</p>
                </div>

                <!-- STEP 3 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80 hover:border-teal-300 transition hover:shadow-lg group">
                    <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-teal-700 group-hover:text-white transition">
                        03
                    </div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Foto Berkas</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Foto berkas langsung dari kamera tanpa perlu scanner fotokopi.</p>
                </div>

                <!-- STEP 4 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80 hover:border-teal-300 transition hover:shadow-lg group">
                    <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center font-bold text-xl mb-4 group-hover:bg-teal-700 group-hover:text-white transition">
                        04
                    </div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Hasil & Kartu QR</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Pantau verifikasi dan cetak kartu resmi dengan QR Code terintegrasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL CEK STATUS FAST SEARCH -->
    <div x-show="showStatusModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div @click.away="showStatusModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative border border-slate-100 animate-in fade-in zoom-in duration-200">
            <button @click="showStatusModal = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 p-2">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-teal-100 text-teal-700 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl font-bold">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Pencarian Tanpa Login</h3>
                <p class="text-xs text-slate-500 mt-1">Masukkan Nomor Induk Kependudukan (NIK 16 Digit) calon siswa atau Kode Registrasi (contoh: PPDB-2026-001).</p>
            </div>

            <form action="{{ route('pendaftar.cek-status') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK ATAU KODE PPDB</label>
                    <input type="text" name="search" required placeholder="Contoh: 3302010101080001" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-semibold text-slate-800 placeholder-slate-400">
                </div>

                <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-teal-700/30 transition">
                    Cek Status Pendaftaran
                </button>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 text-center text-xs">
        <div class="max-w-7xl mx-auto px-4">
            <p>© 2026 Panitia PPDB Online Madrasah Aliyah & Yayasan. All rights reserved.</p>
        </div>
    </footer>

<!-- Service Worker registration -->
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js');
    }
</script>

<!-- PWA install banner -->
<div x-data="{ deferredPrompt: null, showBanner: false }" x-init="
    window.addEventListener('beforeinstallprompt', e => {
        e.preventDefault();
        deferredPrompt = e;
        showBanner = true;
    });
">
    <div x-show="showBanner" class="fixed bottom-4 left-1/2 -translate-x-1/2 bg-teal-700 text-white rounded-lg shadow-lg flex items-center space-x-3 px-4 py-2 z-50">
        <span class="font-medium">Pasang Aplikasi PPDB</span>
        <button @click="deferredPrompt.prompt(); deferredPrompt.userChoice.then(choice => { if (choice.outcome === 'accepted') { console.log('PWA installed'); } showBanner = false; deferredPrompt = null; });" class="bg-white text-teal-700 rounded px-2 py-1 text-sm">Install</button>
    </div>
</div>
</body>
</html>