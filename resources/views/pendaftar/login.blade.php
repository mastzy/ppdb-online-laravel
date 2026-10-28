<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Portal Pendaftar - PPDB Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 selection:bg-teal-500 selection:text-white"
      x-data="{ loginType: 'nik_dob' }">

    <!-- Ambient Glow Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md">
        <!-- Logo & Branding -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-500 to-emerald-400 p-0.5 shadow-lg shadow-teal-500/20 group-hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div class="text-left">
                    <span class="block text-lg font-bold text-white tracking-tight">PPDB ONLINE</span>
                    <span class="block text-xs font-medium text-teal-400 tracking-wider uppercase">Portal Calon Siswa</span>
                </div>
            </a>
            <h1 class="text-2xl font-bold text-white mt-6">Cek & Masuk Pendaftaran</h1>
            <p class="text-slate-400 text-sm mt-1">Zero-Friction UX: Masuk instan tanpa perlu mengingat password</p>
        </div>

        <!-- Main Card -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl">
            <!-- Flash Errors -->
            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Method Switcher Tab -->
            <div class="grid grid-cols-2 p-1 bg-slate-900/80 rounded-xl mb-6 border border-slate-700/50">
                <button type="button" 
                        @click="loginType = 'nik_dob'" 
                        :class="loginType === 'nik_dob' ? 'bg-teal-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'"
                        class="py-2.5 px-3 text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    NIK + Tgl Lahir
                </button>
                <button type="button" 
                        @click="loginType = 'reg_code'" 
                        :class="loginType === 'reg_code' ? 'bg-teal-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'"
                        class="py-2.5 px-3 text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    Kode Registrasi
                </button>
            </div>

            <!-- Login Form -->
            <form action="{{ route('pendaftar.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="login_type" :value="loginType">

                <!-- Tab 1: NIK & Date of Birth -->
                <div x-show="loginType === 'nik_dob'" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="nik" 
                                   maxlength="16"
                                   pattern="\d{16}"
                                   inputmode="numeric"
                                   placeholder="Contoh: 3201012345670001"
                                   value="{{ old('nik') }}"
                                   :required="loginType === 'nik_dob'"
                                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all font-mono text-sm tracking-wide">
                            <span class="absolute right-3.5 top-3.5 text-xs text-slate-500 font-mono">16 Digit</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Sesuai data Kartu Keluarga (KK) calon siswa</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               name="dob" 
                               value="{{ old('dob') }}"
                               :required="loginType === 'nik_dob'"
                               class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Pilih tanggal lahir atau format DDMMYYYY</p>
                    </div>
                </div>

                <!-- Tab 2: Reg Code -->
                <div x-show="loginType === 'reg_code'" class="space-y-4" style="display: none;">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                            Kode Registrasi PPDB
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="reg_code" 
                                   placeholder="Contoh: PPDB-2026-001"
                                   value="{{ old('reg_code') }}"
                                   :required="loginType === 'reg_code'"
                                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all uppercase font-mono font-bold text-sm tracking-wider">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Diberikan saat pendaftaran awal (Step 1)</p>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full mt-6 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-teal-500/20 hover:shadow-teal-500/30 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2 text-sm sm:text-base">
                    <span>Masuk ke Dashboard Pendaftaran</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Quick Navigation -->
            <div class="mt-8 pt-6 border-t border-slate-700/60 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-3">
                <a href="{{ route('daftar') }}" class="text-teal-400 hover:text-teal-300 font-semibold inline-flex items-center gap-1">
                    <span>Belum mendaftar? Formulir Baru</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('home') }}" class="hover:text-slate-200">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            Pusat Bantuan PPDB: WhatsApp Panitia <span class="text-teal-400 font-mono font-semibold">+62 812-3456-7890</span>
        </p>
    </div>
</body>
</html>
