<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Gelombang & Kuota - Administrator PPDB</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center font-bold shadow-md">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Pengaturan Gelombang & Kuota</h1>
                    <p class="text-xs text-slate-500">Konfigurasi Kuota Klaster & Periode Pendaftaran</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('verifikator.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Panitia
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Pengaturan Berhasil Disimpan:</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="space-y-6">

            <!-- Card Kuota Klaster Kurikulum Merdeka -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="font-extrabold text-slate-900 text-base">Alokasi Kuota Klaster Peminatan</h3>
                    <p class="text-xs text-slate-400 mt-1">Perubahan kuota di sini langsung berdampak pada kalkulasi sisa kursi di halaman utama.</p>
                </div>

                <form action="{{ route('admin.settings.update_clusters') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        @foreach($clusters as $c)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-xs text-slate-900">{{ $c->name }}</h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $c->description ?? 'Klaster akademik Kurikulum Merdeka.' }}</p>
                                </div>
                                <div class="flex items-center space-x-3 sm:shrink-0">
                                    <label class="text-xs font-semibold text-slate-500">Kapasitas Kursi:</label>
                                    <input type="number" name="quota[{{ $c->id }}]" min="1" max="500" value="{{ $c->quota }}"
                                           class="w-24 px-3 py-1.5 rounded-xl border border-slate-300 font-mono font-bold text-sm text-center focus:ring-2 focus:ring-teal-600">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-md shadow-teal-200 transition">
                            Simpan Perubahan Kuota
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card Informasi Status Gelombang Aktif -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-700">
                <div class="flex items-center space-x-3 mb-4">
                    <i class="fa-solid fa-clock-rotate-left text-teal-400 text-xl"></i>
                    <h3 class="font-extrabold text-base text-white">Status Gelombang Aktif PPDB</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <span class="text-teal-400 font-bold block mb-1">Gelombang 1 (Jalur Prestasi & Reguler)</span>
                        <p class="text-slate-300">Status: <strong class="text-emerald-400">DIBUKA</strong></p>
                        <p class="text-slate-400 text-[11px] mt-1">Potongan biaya pendaftaran Rp 50.000 berlaku otomatis.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700">
                        <span class="text-amber-400 font-bold block mb-1">Gelombang 2 (Reguler Lanjutan)</span>
                        <p class="text-slate-300">Status: <strong class="text-slate-400">SIAP BUKA OTOMATIS</strong></p>
                        <p class="text-slate-400 text-[11px] mt-1">Akan diaktifkan setelah kuota Gelombang 1 terpenuhi.</p>
                    </div>
                </div>
            </div>

        </div>

    </main>

</body>
</html>

