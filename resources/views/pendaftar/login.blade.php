<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Portal Pendaftar - PPDB Online 2026</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js 3 -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between p-4 selection:bg-teal-500 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Glow Background (Emerald / Teal Palette) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Header Navigation -->
    <header class="max-w-5xl mx-auto w-full py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-teal-950 group-hover:scale-105 transition">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <span class="block font-black text-white text-base leading-tight">PPDB Online 2026</span>
                <span class="block text-[11px] text-teal-400 font-semibold">MA Al-Hikmah Terpadu</span>
            </div>
        </a>

        <a href="{{ route('home') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl border border-slate-700 bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Beranda Utama
        </a>
    </header>

    <!-- Main Container: Centered Floating Card -->
    <main class="my-auto py-8 flex items-center justify-center">
        <div class="w-full max-w-md">

            <!-- Floating Card Section -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl relative overflow-hidden">
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Top Badge Informasi -->
                <div class="text-center mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-extrabold bg-teal-950 border border-teal-700 text-teal-300 shadow-sm">
                        <i class="fa-solid fa-bolt mr-1.5 text-teal-400"></i> Akses Cepat Tanpa Password Ribet
                    </span>
                    <h2 class="text-2xl font-black text-white mt-3">Masuk Portal Pendaftar</h2>
                    <p class="text-xs text-slate-400 mt-1">Lanjutkan formulir, cek verifikasi berkas, atau unduh berkas kelulusan resmi Anda.</p>
                </div>

                <!-- Alert Messages (Error / Success) -->
                @if(session('error') || $errors->any())
                    <div class="mb-5 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-start space-x-3 shadow-lg">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 text-base mt-0.5 shrink-0"></i>
                        <div>{{ session('error') ?? $errors->first() }}</div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-5 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-start space-x-3 shadow-lg">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-base mt-0.5 shrink-0"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('pendaftar.login.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Field 1: NIK / Kode Registrasi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">
                            NIK Siswa (16 Digit) atau Kode Registrasi <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            <input type="text" name="identifier" required autofocus
                                   value="{{ old('identifier', old('nik', old('reg_code'))) }}"
                                   placeholder="Contoh: 3302010101080001 atau PPDB-2026-001"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition font-mono tracking-wide">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Masukkan 16 digit NIK sesuai KK atau Kode Registrasi yang didapat saat awal pendaftaran.</p>
                    </div>

                    <!-- Field 2: Tanggal Lahir Calon Siswa (Sebagai PIN Masuk) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">
                            Tanggal Lahir Siswa (PIN Keamanan) <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-calendar-days"></i>
                            </span>
                            <input type="date" name="dob" required
                                   value="{{ old('dob') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Gunakan tanggal lahir calon siswa sebagai verifikasi identitas resmi.</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-teal-700 to-emerald-600 hover:from-teal-600 hover:to-emerald-500 text-white font-extrabold text-xs shadow-xl shadow-teal-950 transition flex items-center justify-center space-x-2 group">
                            <span>Masuk ke Portal Saya</span>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>

                <!-- Footer Links & Help -->
                <div class="mt-6 pt-5 border-t border-slate-700/60 text-center space-y-3">
                    <p class="text-xs text-slate-400">
                        Belum mendaftar? 
                        <a href="{{ route('pendaftar.formulir') }}" class="font-bold text-teal-400 hover:text-teal-300 underline underline-offset-4 ml-1">
                            Klik di sini untuk Daftar (1 Menit)
                        </a>
                    </p>

                    <div class="p-3 rounded-2xl bg-slate-900/70 border border-slate-700/60 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Lupa NIK / Kode Registrasi?</span>
                        <a href="https://wa.me/6281234567890?text=Assalamu%27alaikum%20Panitia%20PPDB,%20saya%20wali%20murid%20mengalami%20kendala%20lupa%20Kode%20Pendaftaran%20/%20NIK."
                           target="_blank" class="font-bold text-emerald-400 hover:text-emerald-300 flex items-center space-x-1">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Bantuan CS WA</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Login Petugas Link -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-slate-300 transition">
                    <i class="fa-solid fa-lock mr-1"></i> Area Masuk Petugas & Panitia PPDB
                </a>
            </div>

        </div>
    </main>

    <!-- Footer Copyright -->
    <footer class="max-w-5xl mx-auto w-full py-4 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu - MA Al-Hikmah Terpadu.</p>
    </footer>

</body>
</html>
