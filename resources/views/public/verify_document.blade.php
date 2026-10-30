<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Keabsahan Dokumen Resmi - PPDB Online 2026</title>
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
<body class="bg-slate-900 text-slate-100 min-h-screen py-12 px-4 flex flex-col justify-between">

    <div class="max-w-xl mx-auto w-full">

        <!-- Top Brand Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white mx-auto flex items-center justify-center text-2xl shadow-xl shadow-emerald-950 mb-3">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="text-lg font-black text-white">Sistem Validasi Dokumen Resmi</h1>
            <p class="text-xs text-slate-400">Verifikasi Integritas & Keaslian Dokumen PPDB 2026</p>
        </div>

        <!-- Verification Card -->
        <div class="bg-slate-800 border-2 border-emerald-500/50 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Validated Badge -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 mx-auto flex items-center justify-center text-3xl mb-3 shadow-inner">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <span class="inline-block px-3.5 py-1 rounded-full text-xs font-black bg-emerald-500 text-emerald-950 uppercase tracking-widest">
                    DOKUMEN TERVERIFIKASI RESMI
                </span>
                <h2 class="text-lg font-extrabold text-white mt-2">Kuitansi / SK Penerimaan Sah</h2>
                <p class="text-xs text-slate-400 mt-1">Dokumen ini diterbitkan secara elektronik oleh Sistem Informasi PPDB.</p>
            </div>

            <!-- Detail Record Table -->
            <div class="bg-slate-900/80 rounded-2xl border border-slate-700/70 p-5 space-y-3.5 text-xs mb-6">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Nama Siswa:</span>
                    <strong class="text-white text-sm font-bold">{{ $registration->full_name }}</strong>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Kode Pendaftaran:</span>
                    <span class="font-mono text-emerald-400 font-bold">{{ $registration->reg_code }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Nomor Induk (NIK):</span>
                    <span class="font-mono text-slate-300 font-semibold">{{ substr($registration->nik, 0, 6) }}******{{ substr($registration->nik, -4) }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Peminatan Klaster:</span>
                    <strong class="text-slate-200">{{ $registration->cluster?->name ?? 'Klaster Terpilih' }}</strong>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Program Asrama:</span>
                    <span class="text-slate-200">{{ $registration->is_boarding ? 'Santri Mukim (Asrama)' : 'Non-Mukim' }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400">Status Dokumen:</span>
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                        {{ strtoupper($registration->status) }}
                    </span>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <span class="text-slate-400">Waktu Diterbitkan:</span>
                    <span class="text-slate-300 font-mono text-[11px]">{{ $registration->created_at->format('d F Y, H:i') }} WIB</span>
                </div>
            </div>

            <!-- Stempel Digital / Keabsahan Footer -->
            <div class="p-4 rounded-xl bg-slate-900 border border-slate-700/50 flex items-center space-x-3 text-xs text-slate-400">
                <i class="fa-solid fa-certificate text-emerald-400 text-xl"></i>
                <div>
                    <span class="font-bold text-slate-300 block">Stempel Digital Terverifikasi</span>
                    <span class="text-[11px] leading-tight block">Tanda tangan elektronik bersertifikat sistem PPDB Online Madrasah/Sekolah.</span>
                </div>
            </div>

            <!-- Kembali ke Beranda -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300 transition">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Menuju Portal Utama PPDB
                </a>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <footer class="mt-8 text-center text-xs text-slate-600">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu.</p>
    </footer>

</body>
</html>

