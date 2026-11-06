<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi & Laporan Harian Kasir - PPDB Online</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: #000 !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 10pt;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-only {
                display: block !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #cbd5e1 !important;
                padding: 6px 8px !important;
            }
            thead {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen p-4 sm:p-6 lg:p-8">

    <div class="max-w-7xl mx-auto space-y-6 print-container">

        <!-- Top Action Bar (No Print) -->
        <div class="no-print bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl font-bold shadow-inner">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight">Laporan Harian Kasir Bendahara</h1>
                    <p class="text-xs text-slate-500 font-medium">Rekapitulasi penerimaan biaya pendaftaran PPDB Online</p>
                </div>
            </div>

            <!-- Date Filter & Print Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('kasir.laporan') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="date" name="date" value="{{ $selectedDate }}"
                            class="bg-slate-50 border border-slate-300 text-slate-800 text-sm font-semibold rounded-xl focus:ring-teal-500 focus:border-teal-500 block px-3.5 py-2.5 transition">
                    </div>
                    <button type="submit"
                        class="px-4 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl shadow-md shadow-teal-700/20 transition flex items-center gap-2">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter</span>
                    </button>
                </form>

                <button type="button" onclick="window.print()"
                    class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-md shadow-slate-900/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-print text-teal-400"></i>
                    <span>🖨️ Cetak Laporan</span>
                </button>

                <a href="{{ route('bendahara.kasir') }}"
                    class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Loket Kasir</span>
                </a>
            </div>
        </div>

        <!-- Printable Official Header (Print Only) -->
        <div class="hidden print-only mb-6 border-b-2 border-slate-900 pb-4">
            <table class="w-full border-none">
                <tr class="border-none">
                    <td class="w-16 text-center align-middle border-none pr-3">
                        <div class="w-14 h-14 bg-teal-700 text-white font-extrabold text-2xl rounded-full flex items-center justify-center mx-auto" style="line-height: 56px; text-align: center;">
                            MA
                        </div>
                    </td>
                    <td class="text-center align-middle border-none">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-600 m-0">PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h3>
                        <h1 class="text-lg font-black uppercase text-slate-900 m-0">MADRASAH ALIYAH / YAYASAN TERPADU</h1>
                        <p class="text-[10px] text-slate-500 m-0">Jalan Pendidikan No. 123, Kabupaten Banjarnegara, Jawa Tengah 53471 • Email: ppdb@sekolah.sch.id</p>
                    </td>
                </tr>
            </table>
            <div class="mt-4 text-center">
                <h2 class="text-sm font-extrabold uppercase underline tracking-wider text-slate-900">REKAPITULASI & LAPORAN PENERIMAAN KASIR HARIAN</h2>
                <p class="text-xs text-slate-600 mt-0.5">Tanggal: <strong>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</strong></p>
            </div>
        </div>

        <!-- 3 Summary Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- 1. Total Penerimaan Dana -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Penerimaan Dana</span>
                    <span class="text-2xl font-black text-emerald-600 mt-1 block font-mono">
                        Rp {{ number_format($totalNominal, 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] font-medium text-slate-500 mt-1 block">
                        Tunai: Rp {{ number_format($totalCash, 0, ',', '.') }} • Transfer: Rp {{ number_format($totalTransfer, 0, ',', '.') }}
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shadow-sm">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>

            <!-- 2. Total Pendaftar Lunas -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pendaftar Lunas</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block font-mono">
                        {{ $totalTransaksi }} Siswa
                    </span>
                    <span class="text-[11px] font-semibold text-teal-600 mt-1 inline-flex items-center">
                        <i class="fa-solid fa-circle-check mr-1"></i> Transaksi Terverifikasi
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl font-bold shadow-sm">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>

            <!-- 3. Tanggal Laporan -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Periode Tanggal Laporan</span>
                    <span class="text-lg font-bold text-slate-900 mt-1 block">
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}
                    </span>
                    <span class="text-[11px] text-slate-400 mt-1 block">
                        Diperbarui: {{ now()->format('H:i') }} WIB
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl font-bold shadow-sm">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
        </div>

        <!-- Transaction Details Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between no-print">
                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-teal-700"></i>
                    <span>Daftar Rincian Transaksi Pembayaran</span>
                </h3>
                <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">
                    Total: {{ $totalTransaksi }} Data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <tr>
                            <th class="py-3 px-4 text-center w-12">#</th>
                            <th class="py-3 px-4">No. Kuitansi</th>
                            <th class="py-3 px-4">Nama Pendaftar</th>
                            <th class="py-3 px-4">NIK</th>
                            <th class="py-3 px-4">Klaster</th>
                            <th class="py-3 px-4 text-center">Waktu Bayar</th>
                            <th class="py-3 px-4 text-center">Metode</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                            <th class="py-3 px-4 text-center">Petugas Kasir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                        @forelse($payments as $index => $pay)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 text-center font-mono text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                    {{ $pay->registration->reg_code ?? 'REG-'.$pay->id }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $pay->registration->full_name ?? '—' }}</div>
                                    @if($pay->registration && $pay->registration->phone_number)
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $pay->registration->phone_number }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-600">
                                    {{ $pay->registration->nik ?? '—' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-teal-50 text-teal-800 border border-teal-200/60">
                                        {{ $pay->registration->cluster->name ?? 'Reguler' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-mono text-slate-600">
                                    {{ $pay->paid_at ? $pay->paid_at->format('H:i') : $pay->created_at->format('H:i') }} WIB
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($pay->payment_method === 'cash')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Tunai (Loket)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                                            Transfer {{ $pay->sender_bank ? '('.$pay->sender_bank.')' : '' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right font-mono font-extrabold text-slate-900">
                                    Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center text-slate-500">
                                    {{ $pay->verifier->name ?? 'Kasir PPDB' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                                        <p class="text-sm font-semibold">Belum ada transaksi pembayaran lunas pada tanggal ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($payments->isNotEmpty())
                        <tfoot class="bg-slate-50 font-bold text-xs border-t-2 border-slate-200">
                            <tr>
                                <td colspan="7" class="py-3 px-4 text-right uppercase tracking-wider text-slate-600">
                                    Total Penerimaan Kasir:
                                </td>
                                <td class="py-3 px-4 text-right font-mono text-sm text-emerald-700 font-extrabold">
                                    Rp {{ number_format($totalNominal, 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Printable Footer Signatures (Print Only) -->
        <div class="hidden print-only mt-10 pt-4">
            <table class="w-full border-none text-xs">
                <tr class="border-none">
                    <td class="w-1/2 border-none text-center">
                        <p class="m-0">Mengetahui,</p>
                        <p class="font-bold m-0 mb-16">Ketua Panitia PPDB</p>
                        <p class="font-bold underline m-0">( ............................................ )</p>
                        <p class="text-[10px] text-slate-500 m-0">NIP / NIK Panitia</p>
                    </td>
                    <td class="w-1/2 border-none text-center">
                        <p class="m-0">Banjarnegara, {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</p>
                        <p class="font-bold m-0 mb-16">Bendahara / Petugas Kasir</p>
                        <p class="font-bold underline m-0">( {{ auth()->user()->name ?? 'Petugas Kasir PPDB' }} )</p>
                        <p class="text-[10px] text-slate-500 m-0">NIP / Petugas Loket PPDB</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
