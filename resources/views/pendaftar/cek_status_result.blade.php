<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cek Status Pendaftaran - PPDB Online 2026</title>
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
<body class="bg-slate-900 text-slate-100 min-h-screen py-10 px-4 flex flex-col justify-between">

    <div class="max-w-2xl mx-auto w-full">
        <!-- Back to Home Link -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda Utama
            </a>
        </div>

        @if(!$registration)
            <!-- State: Data Tidak Ditemukan -->
            <div class="bg-slate-800/80 backdrop-blur border border-slate-700 rounded-3xl p-8 text-center shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-rose-500/20 text-rose-400 mx-auto flex items-center justify-center text-2xl mb-4 border border-rose-500/30">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h2 class="text-xl font-extrabold text-white">Data Pendaftar Tidak Ditemukan</h2>
                <p class="text-sm text-slate-400 mt-2">
                    Tidak ditemukan data registrasi dengan kata kunci: <span class="font-mono text-amber-300 font-bold">"{{ $search }}"</span>.
                </p>
                <div class="mt-6 p-4 rounded-xl bg-slate-900/60 border border-slate-700/50 text-xs text-slate-400 text-left space-y-1.5">
                    <p><i class="fa-solid fa-circle-info text-emerald-400 mr-1.5"></i> Pastikan NIK 16 digit yang dimasukkan sesuai dengan Kartu Keluarga.</p>
                    <p><i class="fa-solid fa-circle-info text-emerald-400 mr-1.5"></i> Jika menggunakan Kode Pendaftaran, formatnya adalah: <span class="text-emerald-300 font-mono">PPDB-2026-XXX</span>.</p>
                </div>
                <div class="mt-6 flex justify-center gap-3">
                    <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs transition">
                        Cari Ulang
                    </a>
                    <a href="{{ route('pendaftar.formulir') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition">
                        Daftar Baru Sekarang
                    </a>
                </div>
            </div>
        @else
            <!-- State: Data Berhasil Ditemukan -->
            <div class="bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
                
                <!-- Header Banner Card -->
                <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-800 via-slate-800 to-slate-750 border-b border-slate-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-emerald-400 bg-emerald-950/80 border border-emerald-800/60 px-3 py-1 rounded-full mb-2">
                                Kartu Registrasi Resmi
                            </span>
                            <h1 class="text-2xl font-extrabold text-white">{{ $registration->full_name }}</h1>
                            <p class="text-xs text-slate-400 mt-1">
                                NIK: <span class="font-mono text-slate-200 font-semibold">{{ substr($registration->nik, 0, 6) }}******{{ substr($registration->nik, -4) }}</span>
                                <span class="mx-2">•</span>
                                Kode: <span class="font-mono text-emerald-400 font-bold">{{ $registration->reg_code }}</span>
                            </p>
                        </div>

                        <!-- Status Badge -->
                        <div class="sm:text-right">
                            @if(in_array($registration->status, ['approved', 'lunas', 'paid']))
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse mr-2"></span>
                                    LUNAS / DITERIMA
                                </span>
                            @elseif(in_array($registration->status, ['revision_needed']))
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30 shadow-sm">
                                    <i class="fa-solid fa-triangle-exclamation mr-2 text-rose-400"></i>
                                    PERLU REVISI BERKAS
                                </span>
                            @elseif(in_array($registration->status, ['rejected']))
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold bg-rose-600/30 text-rose-200 border border-rose-600/40">
                                    <i class="fa-solid fa-circle-xmark mr-2 text-rose-400"></i>
                                    TIDAK LOLOS
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 mr-2"></span>
                                    DALAM VERIFIKASI / MENUNGGU PEMBAYARAN
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 space-y-6">

                    <!-- Visual Progress Bar Status Stepper -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Tracking Tahapan Registrasi</h4>
                        <div class="grid grid-cols-4 gap-2 text-center">
                            <!-- 1. Terdaftar -->
                            <div class="p-3 rounded-xl border {{ $registration->id ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                                <i class="fa-solid fa-clipboard-check text-sm mb-1 block"></i>
                                <span class="text-[10px] sm:text-xs font-bold">1. Terdaftar</span>
                            </div>

                            <!-- 2. Pembayaran -->
                            <div class="p-3 rounded-xl border {{ in_array($registration->status, ['paid', 'lunas', 'approved']) || $registration->latestPayment ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                                <i class="fa-solid fa-receipt text-sm mb-1 block"></i>
                                <span class="text-[10px] sm:text-xs font-bold">2. Pembayaran</span>
                            </div>

                            <!-- 3. Verifikasi Berkas -->
                            <div class="p-3 rounded-xl border {{ in_array($registration->status, ['approved', 'lunas']) ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : ($registration->status === 'revision_needed' ? 'bg-rose-950/40 border-rose-500/50 text-rose-300' : 'bg-slate-900 border-slate-700 text-slate-500') }}">
                                <i class="fa-solid fa-stamp text-sm mb-1 block"></i>
                                <span class="text-[10px] sm:text-xs font-bold">3. Verifikasi</span>
                            </div>

                            <!-- 4. Lulus -->
                            <div class="p-3 rounded-xl border {{ in_array($registration->status, ['approved', 'lunas']) ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                                <i class="fa-solid fa-graduation-cap text-sm mb-1 block"></i>
                                <span class="text-[10px] sm:text-xs font-bold">4. Lulus</span>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Box Khusus Revision Needed -->
                    @if($registration->status === 'revision_needed')
                        <div class="p-5 rounded-2xl bg-rose-500/10 border-2 border-rose-500/40 text-rose-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-base mt-0.5">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-extrabold text-sm text-rose-300">Perhatian: Berkas Membutuhkan Perbaikan!</h4>
                                    <p class="text-xs text-rose-200 mt-1 leading-relaxed">
                                        {{ $registration->catatan_koreksi ?? 'Terdapat berkas yang buram atau tidak sesuai. Harap segera masuk ke portal pendaftar untuk memperbarui foto dokumen.' }}
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{ route('pendaftar.login') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition shadow">
                                            <i class="fa-solid fa-upload mr-1.5"></i> Perbaiki Dokumen Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Pendaftar Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-900/60 p-5 rounded-2xl border border-slate-700/60">
                        <div>
                            <span class="text-[11px] text-slate-400 block">Pilihan Klaster Kurikulum Merdeka:</span>
                            <span class="text-sm font-bold text-emerald-400">
                                {{ $registration->cluster?->name ?? 'Belum Dipilih' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block">Program Tempat Tinggal:</span>
                            <span class="text-sm font-bold text-slate-200">
                                {{ $registration->is_boarding ? 'Santri Mukim (Asrama)' : 'Non-Mukim (Reguler PP)' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block">Gelombang:</span>
                            <span class="text-sm font-bold text-slate-200">{{ $registration->wave_name ?? 'Gelombang 1' }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 block">Status Pembayaran:</span>
                            <span class="text-sm font-bold {{ in_array($registration->status, ['paid', 'lunas', 'approved']) ? 'text-emerald-400' : 'text-amber-400' }}">
                                {{ in_array($registration->status, ['paid', 'lunas', 'approved']) ? 'LUNAS' : 'Belum Diverifikasi / Belum Bayar' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-700">
                        @if(in_array($registration->status, ['approved', 'lunas']))
                            <a href="{{ route('kuitansi.pdf', $registration->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-lg shadow-emerald-950">
                                <i class="fa-solid fa-file-arrow-down mr-2"></i> Unduh Kuitansi PDF
                            </a>
                        @endif

                        <a href="{{ route('pendaftar.login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs transition">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk ke Portal Siswa
                        </a>

                        <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 hover:bg-slate-800 text-slate-300 font-bold text-xs transition">
                            Cek NIK Lain
                        </a>
                    </div>

                </div>
            </div>
        @endif
    </div>

    <!-- Footer Copyright -->
    <footer class="mt-12 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu.</p>
    </footer>

</body>
</html>

