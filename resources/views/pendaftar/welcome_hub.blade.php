<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Hub - Selamat Anda Dinyatakan LULUS PPDB 2026</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Plus Jakarta Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen py-8 px-4">

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Top Bar -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-950">
                    <i class="fa-solid fa-graduation-cap"></i>
                </a>
                <div>
                    <h1 class="font-extrabold text-white text-base">Welcome Hub PPDB 2026</h1>
                    <p class="text-xs text-slate-400">Kode Registrasi: <span class="text-emerald-400 font-mono font-bold">{{ $applicant->reg_code }}</span></p>
                </div>
            </div>

            <form action="{{ route('pendaftar.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-bold px-3 py-1.5 rounded-lg border border-rose-900/60 bg-rose-950/40 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                </button>
            </form>
        </div>

        <!-- Hero Celebration Banner -->
        <div class="bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 rounded-3xl border-2 border-emerald-500/50 p-6 sm:p-10 shadow-2xl relative overflow-hidden text-center sm:text-left">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 relative z-10">
                <div>
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-black bg-emerald-400 text-emerald-950 uppercase tracking-widest shadow-sm">
                        <i class="fa-solid fa-trophy mr-1.5"></i> Dinyatakan Lulus
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-white mt-3 leading-tight">
                        Ahlan Wa Sahlan, Selamat Bergabung!<br>
                        <span class="text-emerald-300">{{ $applicant->full_name }}</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-xl leading-relaxed">
                        Anda telah resmi diterima sebagai Peserta Didik Baru Tahun Ajaran 2026/2027 pada <span class="text-white font-bold">{{ $applicant->cluster?->name ?? 'Klaster Terpilih' }}</span>.
                    </p>
                </div>

                <div class="shrink-0 w-28 h-28 sm:w-36 sm:h-36 rounded-3xl bg-emerald-800/40 border border-emerald-400/30 flex items-center justify-center text-5xl text-emerald-300 shadow-inner">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
        </div>

        <!-- Komunitas WhatsApp Paguyuban Wali Santri -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-800 rounded-3xl border border-emerald-600/40 p-6 sm:p-7 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-emerald-700 flex items-center justify-center text-2xl font-bold shadow-md shrink-0">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-sm sm:text-base text-white">Komunitas Wali Santri Baru 2026</h4>
                    <p class="text-xs text-emerald-100 mt-0.5">Silakan bergabung ke grup koordinasi resmi madrasah untuk informasi persiapan masuk.</p>
                </div>
            </div>
            <a href="https://chat.whatsapp.com" target="_blank" class="shrink-0 px-5 py-3 rounded-2xl bg-emerald-400 hover:bg-emerald-300 text-emerald-950 font-black text-xs transition shadow flex items-center space-x-2">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Gabung ke Grup WhatsApp Paguyuban</span>
            </a>
        </div>

        <!-- Petunjuk Seragam & Perlengkapan -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-xl">
            <h3 class="text-base font-extrabold text-white flex items-center space-x-2 mb-4">
                <i class="fa-solid fa-shirt text-emerald-400"></i>
                <span>Petunjuk Seragam & Atribut Madrasah</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/60">
                    <strong class="text-white block font-bold text-sm mb-1">Seragam Putih - Abu-Abu Resmi</strong>
                    <p class="text-slate-400 leading-relaxed">Digunakan pada hari Senin dan Selasa lengkap dengan peci/jilbab putih dan ikat pinggang berlogo.</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/60">
                    <strong class="text-white block font-bold text-sm mb-1">Seragam Khas Batik & Pramuka</strong>
                    <p class="text-slate-400 leading-relaxed">Batik khas madrasah digunakan Rabu - Kamis, serta seragam Pramuka lengkap pada hari Jumat - Sabtu.</p>
                </div>
            </div>
        </div>

        <!-- Action Center: Unduh Dokumen Resmi PDF -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-xl">
            <div class="border-b border-slate-700 pb-4 mb-6">
                <h3 class="text-base font-extrabold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-download text-emerald-400"></i>
                    <span>Pusat Berkas & Dokumen Digital Resmi</span>
                </h3>
                <p class="text-xs text-slate-400 mt-1">Unduh dokumen berkas resmi ber-QR Code untuk kelengkapan administrasi dan daftar ulang fisik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- 1. Unduh SK Lulus PDF -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-950 text-emerald-400 flex items-center justify-center font-bold text-lg mb-3">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <h4 class="font-bold text-sm text-white">SK Keterangan Lulus</h4>
                        <p class="text-[11px] text-slate-400 mt-1">Surat resmi keputusan penerimaan siswa baru ber-QR Code digital.</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-800">
                        <a href="{{ route('kuitansi.pdf', $applicant->id) }}" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition flex items-center justify-center space-x-2 shadow">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh SK (PDF)</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Unduh Kuitansi Resmi PDF -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-950 text-blue-400 flex items-center justify-center font-bold text-lg mb-3">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <h4 class="font-bold text-sm text-white">Kuitansi Pembayaran Lunas</h4>
                        <p class="text-[11px] text-slate-400 mt-1">Tanda bukti pembayaran sah berstempel & validasi keaslian.</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-800">
                        <a href="{{ route('kuitansi.pdf', $applicant->id) }}" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition flex items-center justify-center space-x-2 shadow">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Unduh Kuitansi (PDF)</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Unduh Kartu Stopmap / Kartu Ujian PDF -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-950 text-amber-400 flex items-center justify-center font-bold text-lg mb-3">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        <h4 class="font-bold text-sm text-white">Lembar Stopmap 1-Halaman</h4>
                        <p class="text-[11px] text-slate-400 mt-1">Ringkasan biodata & checklist dokumen fisik untuk map pendaftaran.</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-800">
                        <a href="{{ route('stopmap.pdf', $applicant->id) }}" class="w-full py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs transition flex items-center justify-center space-x-2 shadow">
                            <i class="fa-solid fa-print"></i>
                            <span>Cetak Stopmap (PDF)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Orientasi / MATSAMA -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-xl">
            <h3 class="text-base font-extrabold text-white flex items-center space-x-2 mb-4">
                <i class="fa-solid fa-calendar-check text-emerald-400"></i>
                <span>Agenda Penting Selanjutnya (MATSAMA & Masuk Asrama)</span>
            </h3>

            <div class="space-y-3">
                <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-700/60 flex items-start space-x-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-950 text-emerald-400 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">1</span>
                    <div>
                        <h4 class="font-bold text-xs text-white">Daftar Ulang & Verifikasi Fisik Dokumen</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Bawa Lembar Cetak Stopmap dan fotokopi KK, Akta Kelahiran, serta SKL ke Loket Sekretariat PPDB.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-700/60 flex items-start space-x-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-950 text-emerald-400 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">2</span>
                    <div>
                        <h4 class="font-bold text-xs text-white">Kedatangan Santri Mukim ke Asrama (Check-in Pesantren)</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Pemeriksaan perlengkapan santri, pembagian kamar asrama, dan silaturahmi wali santri.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-700/60 flex items-start space-x-3">
                    <span class="w-7 h-7 rounded-lg bg-emerald-950 text-emerald-400 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">3</span>
                    <div>
                        <h4 class="font-bold text-xs text-white">Masa Ta'aruf Siswa Madrasah (MATSAMA 2026)</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Pengenalan budaya madrasah, pembagian jadwal kelas, dan pengenalan ustadz/ustadzah.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="mt-12 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu.</p>
    </footer>

</body>
</html>
