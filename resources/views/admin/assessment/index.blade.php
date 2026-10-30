<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Asesmen Diagnostik - Panitia Penguji PPDB</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Plus Jakarta Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen"
      x-data="{
          modalOpen: false,
          regId: null,
          studentName: '',
          regCode: '',
          btq: 75,
          tahfidz: 1,
          literacy: 75,
          notes: '',
          get averageScore() {
              const b = parseFloat(this.btq) || 0;
              const l = parseFloat(this.literacy) || 0;
              return ((b + l) / 2).toFixed(1);
          },
          get recommendation() {
              const avg = parseFloat(this.averageScore);
              if (avg >= 85) return { text: 'SANGAT DIREKOMENDASIKAN (KELAS UNGGULAN)', color: 'text-emerald-700 bg-emerald-100 border-emerald-300' };
              if (avg >= 70) return { text: 'LULUS / DIREKOMENDASIKAN', color: 'text-teal-700 bg-teal-100 border-teal-300' };
              return { text: 'PERLU PEMBINAAN MATRIKULASI', color: 'text-amber-700 bg-amber-100 border-amber-300' };
          },
          openScoreModal(item) {
              this.regId = item.id;
              this.studentName = item.full_name;
              this.regCode = item.reg_code;
              this.btq = item.diagnostic_score ? item.diagnostic_score.btq_score : 75;
              this.tahfidz = item.diagnostic_score ? item.diagnostic_score.tahfidz_juz : 0;
              this.literacy = item.diagnostic_score ? item.diagnostic_score.literacy_score : 75;
              this.notes = item.diagnostic_score ? (item.diagnostic_score.notes || '') : '';
              this.modalOpen = true;
          }
      }">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-teal-700 text-white flex items-center justify-center font-bold shadow-md shadow-teal-200">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Asesmen Diagnostik Siswa</h1>
                    <p class="text-xs text-slate-500">Penilaian BTQ, Tahfidz Al-Qur'an & Literasi Dasar</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('verifikator.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Panitia
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Logout">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Berhasil Disimpan:</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-slate-900 text-base">Daftar Peserta Asesmen</h2>
                <p class="text-xs text-slate-500">Total {{ $registrations->total() }} Calon Siswa Terdaftar</p>
            </div>

            <form action="{{ route('admin.assessment.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama / kode reg / NIK..."
                           class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-teal-600 font-mono">
                </div>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Table Data Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Kode & NIK</th>
                            <th class="py-3.5 px-4">Nama Siswa</th>
                            <th class="py-3.5 px-4">Peminatan Klaster</th>
                            <th class="py-3.5 px-4 text-center">Skor BTQ</th>
                            <th class="py-3.5 px-4 text-center">Tahfidz (Juz)</th>
                            <th class="py-3.5 px-4 text-center">Literasi Dasar</th>
                            <th class="py-3.5 px-4 text-center">Rata-Rata</th>
                            <th class="py-3.5 px-4 text-center">Aksi Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($registrations as $reg)
                            @php
                                $score = $reg->diagnosticScore;
                                $avg = $score ? round(($score->btq_score + $score->literacy_score) / 2, 1) : null;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-teal-700 block">{{ $reg->reg_code }}</span>
                                    <span class="font-mono text-slate-400 text-[11px]">{{ $reg->nik }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <strong class="text-slate-900 block">{{ $reg->full_name }}</strong>
                                    <span class="text-[11px] text-slate-400">{{ $reg->is_boarding ? 'Santri Mukim' : 'Non-Mukim' }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-slate-700">{{ $reg->cluster?->name ?? 'Belum Pilih' }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                                    {{ $score ? number_format($score->btq_score, 0) : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-teal-700">
                                    {{ $score ? $score->tahfidz_juz . ' Juz' : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                                    {{ $score ? number_format($score->literacy_score, 0) : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($avg !== null)
                                        <span class="px-2 py-0.5 rounded-full font-bold font-mono text-[11px] {{ $avg >= 70 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $avg }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button type="button" @click="openScoreModal({{ json_encode($reg) }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-sm transition">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Input Nilai
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-400">
                                    Tidak ada data pendaftar yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200">
                {{ $registrations->links() }}
            </div>
        </div>

    </main>

    <!-- Modal Input Skor Diagnostik (Alpine.js) -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-slate-200 max-w-lg w-full overflow-hidden shadow-2xl p-6 sm:p-8"
             @click.away="modalOpen = false">
            
            <div class="border-b border-slate-100 pb-4 mb-5 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-teal-700 uppercase tracking-wider bg-teal-50 px-2.5 py-0.5 rounded-full">Formulir Penguji</span>
                    <h3 class="font-black text-slate-900 text-lg mt-1" x-text="'Nilai: ' + studentName"></h3>
                    <p class="text-xs text-slate-400 font-mono" x-text="'Kode: ' + regCode"></p>
                </div>
                <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="'/admin/assessment/' + regId" method="POST">
                @csrf
                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Skor Baca Tulis Al-Qur'an (BTQ) (0 - 100) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.1" name="btq_score" min="0" max="100" required x-model="btq"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Capaian Hafalan Tahfidz (Jumlah Juz)</label>
                        <input type="number" name="tahfidz_juz" min="0" max="30" x-model="tahfidz"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Skor Tes Literasi & Numerasi Dasar (0 - 100) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.1" name="literacy_score" min="0" max="100" required x-model="literacy"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-teal-600">
                    </div>

                    <!-- Auto Recommendation Box -->
                    <div class="p-3.5 rounded-xl border text-xs" :class="recommendation.color">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold">Rata-Rata Nilai: <strong x-text="averageScore"></strong></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Kalkulasi Otomatis</span>
                        </div>
                        <p class="font-black text-xs" x-text="'Rekomendasi: ' + recommendation.text"></p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Wawancara Orang Tua / Calon Santri</label>
                        <textarea name="notes" rows="3" x-model="notes" placeholder="Catatan komitmen orang tua, minat bakat santri..."
                                  class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-teal-600"></textarea>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-md shadow-teal-200 transition">
                        Simpan Nilai Asesmen
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>

