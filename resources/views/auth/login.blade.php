<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun Panitia & Kasir - PPDB Online</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 selection:bg-emerald-500 selection:text-white relative overflow-hidden">

    <!-- Ambient Glow Background (Emerald / Teal) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md">

        <!-- Logo & Header Branding -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 p-0.5 shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-emerald-400">
                        <i class="fa-solid fa-shield-halved text-xl"></i>
                    </div>
                </div>
                <div class="text-left">
                    <span class="block text-lg font-black text-white tracking-tight">PPDB ONLINE</span>
                    <span class="block text-xs font-semibold text-emerald-400 tracking-wider uppercase">Portal Panitia & Kasir</span>
                </div>
            </a>
            <h1 class="text-2xl font-extrabold text-white mt-6">Masuk Petugas</h1>
            <p class="text-slate-400 text-xs mt-1">Admin, Verifikator Berkas, dan Bendahara Kasir Loket</p>
        </div>

        <!-- Main Card Form -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl">

            <!-- Flash Error Notification -->
            @if(session('error') || $errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base mt-0.5 shrink-0"></i>
                    <div>{{ session('error') ?? $errors->first() }}</div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Username / Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">
                        Username / Email Petugas <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="email" required autofocus
                               value="{{ old('email') }}"
                               placeholder="admin / verifikator / bendahara"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">
                        Kata Sandi Petugas <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs shadow-lg shadow-emerald-950 transition flex items-center justify-center gap-2">
                        <span>Masuk ke Dashboard</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Akun Pengujian Quick Reference -->
            <div class="mt-6 pt-5 border-t border-slate-700/60">
                <span class="text-[10px] uppercase tracking-wider font-extrabold text-slate-400 block mb-2">Akun Pengujian (Demo):</span>
                <div class="grid grid-cols-3 gap-1.5 text-[10px] text-slate-300 font-mono">
                    <div class="p-2 bg-slate-900/60 rounded-lg border border-slate-700/50">
                        <span class="text-emerald-400 font-bold block font-sans">Admin</span>
                        <span>admin</span>
                    </div>
                    <div class="p-2 bg-slate-900/60 rounded-lg border border-slate-700/50">
                        <span class="text-blue-400 font-bold block font-sans">Verifikator</span>
                        <span>verifikator</span>
                    </div>
                    <div class="p-2 bg-slate-900/60 rounded-lg border border-slate-700/50">
                        <span class="text-amber-400 font-bold block font-sans">Bendahara</span>
                        <span>bendahara</span>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 text-center mt-2 font-mono">Password: <span class="text-slate-200 font-bold">password</span></p>
            </div>

        </div>

        <div class="text-center mt-6">
            <a href="{{ route('pendaftar.login') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Portal Masuk Calon Siswa
            </a>
        </div>

    </div>

</body>
</html>
