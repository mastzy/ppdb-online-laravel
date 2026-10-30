<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Kasir Offline (Bendahara PPDB) - PPDB Online 2026</title>
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold shadow-md shadow-amber-200">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Mode Kasir Offline (Loket PPDB)</h1>
                    <p class="text-xs text-slate-500">Penerimaan Pembayaran Tunai & Cetak Kuitansi Langsung</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('verifikator.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Panitia
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 text-sm" title="Keluar">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Transaksi Tunai Berhasil Diproses!</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Peringatan:</h4>
                    <p class="mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Form Pencarian Cepat Pendaftar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider mb-2">Cari Calon Siswa di Loket</h3>
                    <p class="text-xs text-slate-400 mb-4">Ketikkan NIK 16 digit atau Kode Pendaftaran siswa.</p>

                    <form action="{{ route('bendahara.kasir.search') }}" method="GET" class="space-y-3">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="q" required value="{{ request('q') }}"
                                   placeholder="Contoh: PPDB-2026-001 / NIK"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-md shadow-amber-200 transition">
                            Cari Data Tagihan
                        </button>
                    </form>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-lg border border-slate-700">
                    <div class="flex items-center space-x-3 mb-3">
                        <i class="fa-solid fa-circle-info text-amber-400 text-lg"></i>
                        <h4 class="font-bold text-xs text-amber-300 uppercase tracking-wider">SOP Kasir PPDB</h4>
                    </div>
                    <ul class="text-[11px] text-slate-300 space-y-2 list-disc list-inside leading-relaxed">
                        <li>Terima uang tunai fisik sesuai nominal tagihan resmi.</li>
                        <li>Klik <strong>[Proses Pembayaran Tunai]</strong> untuk menerbitkan stempel & nomor kuitansi resmi.</li>
                        <li>Cetak Kuitansi Resmi PDF untuk diserahkan ke wali murid sebagai bukti sah.</li>
                    </ul>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Tagihan & Eksekusi Bayar Tunai -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <h3 class="font-black text-slate-900 text-base mb-1">Rincian Pembayaran & Validasi Kasir</h3>
                    <p class="text-xs text-slate-400 mb-6">Pendaftar yang ditemukan akan ditampilkan di bawah ini.</p>

                    @if(isset($registration) && $registration)
                        @php
                            $fee = $registration->has_sibling_discount ? 240000 : 300000;
                        @endphp

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4 mb-4">
                                <div>
                                    <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full uppercase">Pendaftar Ditemukan</span>
                                    <h4 class="font-black text-slate-900 text-lg mt-1">{{ $registration->full_name }}</h4>
                                    <p class="text-xs text-slate-500 font-mono">Kode: {{ $registration->reg_code }} | NIK: {{ $registration->nik }}</p>
                                </div>
                                <div>
                                    @if(in_array($registration->status, ['paid', 'lunas', 'approved']))
                                        <span class="px-3 py-1 rounded-xl bg-emerald-100 text-emerald-800 font-bold text-xs">
                                            <i class="fa-solid fa-circle-check mr-1"></i> STATUS: LUNAS
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-xl bg-amber-100 text-amber-800 font-bold text-xs">
                                            <i class="fa-solid fa-clock mr-1"></i> BELUM LUNAS
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-xs mb-4">
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Klaster Peminatan:</span>
                                    <strong class="text-slate-800">{{ $registration->cluster?->name ?? 'Belum memilih' }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Program Asrama:</span>
                                    <strong class="text-slate-800">{{ $registration->is_boarding ? 'Santri Mukim (Asrama)' : 'Non-Mukim' }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Potongan Sibling:</span>
                                    <strong class="text-slate-800">{{ $registration->has_sibling_discount ? 'Diskon 20% (Saudara Kandung)' : 'Tidak Ada' }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Nominal Tagihan Kasir:</span>
                                    <strong class="text-emerald-700 text-sm font-black">Rp {{ number_format($fee, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <!-- Tombol Aksi Kasir -->
                            <div class="pt-4 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3">
                                @if(!in_array($registration->status, ['paid', 'lunas', 'approved']))
                                    <form action="{{ route('bendahara.kasir.pay_cash', $registration->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md shadow-emerald-200 transition flex items-center space-x-2">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                            <span>Proses Pembayaran Tunai (LUNAS)</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('kuitansi.pdf', $registration->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition">
                                            <i class="fa-solid fa-print mr-1.5"></i> Cetak Kuitansi Resmi
                                        </a>
                                        <a href="{{ route('stopmap.pdf', $registration->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow transition">
                                            <i class="fa-solid fa-file-lines mr-1.5"></i> Cetak Stopmap Map
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Blank State -->
                        <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-cash-register text-4xl text-slate-300 mb-3"></i>
                            <h4 class="font-bold text-slate-700 text-xs">Belum Ada Pendaftar yang Dipilih</h4>
                            <p class="text-[11px] text-slate-400 mt-1">Gunakan formulir pencarian di samping kiri untuk memproses pembayaran tunai siswa.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </main>

    <footer class="mt-12 text-center text-xs text-slate-400 py-6 border-t border-slate-200 bg-white">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu - Mode Kasir Bendahara.</p>
    </footer>

</body>
</html>

