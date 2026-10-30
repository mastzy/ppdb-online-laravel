<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Siswa - PPDB Online</title>
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
<body class="bg-slate-900 text-slate-100 min-h-screen py-8 px-4 flex flex-col justify-between">

    <div class="max-w-4xl mx-auto w-full space-y-6">

        <!-- Top Navigation -->
        <header class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-950">
                    <i class="fa-solid fa-graduation-cap"></i>
                </a>
                <div>
                    <h1 class="font-extrabold text-white text-base">Dashboard Calon Siswa</h1>
                    <p class="text-xs text-slate-400">Selamat datang, <strong class="text-emerald-400">{{ auth()->user()->name }}</strong></p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-900/60 bg-rose-950/40 text-xs font-bold text-rose-300 hover:text-white hover:bg-rose-900 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                </button>
            </form>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 flex items-start space-x-3 shadow-lg">
                <i class="fa-solid fa-circle-check text-emerald-400 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm text-emerald-300">Berhasil!</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 flex items-start space-x-3 shadow-lg">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm text-rose-300">Peringatan:</h4>
                    <p class="mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Banner Revision Needed Jika Ada -->
        @if($registration->status === 'revision_needed')
            <div class="p-5 rounded-3xl bg-rose-500/10 border-2 border-rose-500/40 text-rose-200 shadow-xl">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold text-base mt-0.5 shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-sm text-rose-300">Perhatian: Berkas Memerlukan Perbaikan!</h4>
                        <p class="text-xs text-rose-200 mt-1 leading-relaxed">
                            {{ $registration->catatan_koreksi ?? 'Terdapat berkas yang tidak terbaca atau belum sesuai dengan ketentuan panitia.' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Card Status Tracking Siswa -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-700 pb-6 mb-6">
                <div>
                    <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider bg-emerald-950/70 border border-emerald-800 px-3 py-1 rounded-full">
                        Status Pendaftaran
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-white mt-2">{{ $registration->full_name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5 font-mono">
                        Kode: <span class="text-emerald-400 font-bold">{{ $registration->reg_code }}</span> | NIK: {{ $registration->nik }}
                    </p>
                </div>

                <div>
                    @if(in_array($registration->status, ['approved', 'lunas', 'paid']))
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <i class="fa-solid fa-circle-check mr-1.5"></i> LUNAS / DITERIMA
                        </span>
                    @elseif($registration->status === 'revision_needed')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> PERLU REVISI
                        </span>
                    @else
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            <i class="fa-solid fa-clock mr-1.5"></i> DALAM PROSES
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stepper Progress Bar -->
            <div class="grid grid-cols-4 gap-2 text-center text-xs mb-8">
                <div class="p-3 rounded-xl border {{ $registration->id ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                    <i class="fa-solid fa-clipboard-check block mb-1 text-sm"></i>
                    <span class="font-bold text-[11px]">1. Formulir</span>
                </div>
                <div class="p-3 rounded-xl border {{ in_array($registration->status, ['paid', 'lunas', 'approved']) || $registration->latestPayment ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                    <i class="fa-solid fa-receipt block mb-1 text-sm"></i>
                    <span class="font-bold text-[11px]">2. Bayar</span>
                </div>
                <div class="p-3 rounded-xl border {{ in_array($registration->status, ['approved', 'lunas']) ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : ($registration->status === 'revision_needed' ? 'bg-rose-950/40 border-rose-500/50 text-rose-300' : 'bg-slate-900 border-slate-700 text-slate-500') }}">
                    <i class="fa-solid fa-stamp block mb-1 text-sm"></i>
                    <span class="font-bold text-[11px]">3. Verifikasi</span>
                </div>
                <div class="p-3 rounded-xl border {{ in_array($registration->status, ['approved', 'lunas']) ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-700 text-slate-500' }}">
                    <i class="fa-solid fa-graduation-cap block mb-1 text-sm"></i>
                    <span class="font-bold text-[11px]">4. Lulus</span>
                </div>
            </div>

            <!-- Action Center Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('pendaftar.pembayaran') }}" class="p-4 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-950 text-emerald-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xs text-white">Pembayaran</h4>
                        <p class="text-[11px] text-slate-400">Instruksi & Upload Struk</p>
                    </div>
                </a>

                <a href="{{ route('registration.card.pdf') }}" class="p-4 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-950 text-blue-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xs text-white">Kartu Tes (PDF)</h4>
                        <p class="text-[11px] text-slate-400">Unduh Kartu Ujian</p>
                    </div>
                </a>

                <a href="{{ route('stopmap.pdf', $registration->id) }}" class="p-4 rounded-2xl bg-slate-900 border border-slate-700 hover:border-emerald-500 transition flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-950 text-amber-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-folder"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xs text-white">Lembar Stopmap</h4>
                        <p class="text-[11px] text-slate-400">Checklist Berkas Fisik</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tabel Berkas Terunggah -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 shadow-xl">
            <h3 class="font-bold text-sm text-white mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-folder-open text-emerald-400"></i>
                <span>Kelengkapan Berkas Persyaratan Digital</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="py-2.5 px-3">Jenis Berkas</th>
                            <th class="py-2.5 px-3">Status Verifikasi</th>
                            <th class="py-2.5 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach(['kk' => 'Kartu Keluarga', 'akta' => 'Akta Kelahiran', 'skl' => 'SKL / Ijazah'] as $type => $label)
                            @php
                                $doc = $registration->documents->firstWhere('doc_type', $type);
                            @endphp
                            <tr>
                                <td class="py-3 px-3">
                                    <strong class="text-slate-200 block">{{ $label }}</strong>
                                    <span class="text-[10px] text-slate-500 uppercase">{{ $type }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    @if($doc)
                                        @if($doc->status === 'approved')
                                            <span class="text-emerald-400 font-bold"><i class="fa-solid fa-check mr-1"></i> Disetujui</span>
                                        @elseif($doc->status === 'revision_needed')
                                            <span class="text-rose-400 font-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Perlu Revisi</span>
                                        @else
                                            <span class="text-amber-400 font-bold"><i class="fa-solid fa-clock mr-1"></i> Menunggu Verifikasi</span>
                                        @endif
                                    @else
                                        <span class="text-slate-500">Belum diunggah</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('pendaftar.formulir') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-bold transition">
                                        <i class="fa-solid fa-upload mr-1 text-[10px]"></i> Unggah Ulang
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Footer Simple -->
    <footer class="mt-12 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu.</p>
    </footer>

</body>
</html>
