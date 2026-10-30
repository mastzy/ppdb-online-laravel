<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Verifikasi Berkas - Panitia PPDB 2026</title>
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
<body class="bg-slate-100 text-slate-800 min-h-screen"
      x-data="{
          previewModal: false,
          currentRegId: null,
          currentName: '',
          currentRegCode: '',
          currentStatus: 'approved',
          currentNote: '',
          docsList: [],
          activeDocUrl: null,
          isPdf: false,
          openModal(item) {
              this.currentRegId = item.id;
              this.currentName = item.full_name;
              this.currentRegCode = item.reg_code;
              this.currentStatus = item.status === 'revision_needed' ? 'revision_needed' : 'approved';
              this.currentNote = item.catatan_koreksi || '';
              this.docsList = item.documents || [];
              if (this.docsList.length > 0) {
                  this.selectDoc(this.docsList[0]);
              } else {
                  this.activeDocUrl = null;
              }
              this.previewModal = true;
          },
          selectDoc(doc) {
              this.activeDocUrl = '/storage/' + doc.file_path;
              this.isPdf = doc.file_path.toLowerCase().endsWith('.pdf');
          }
      }">

    <!-- Top Navigation Admin -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-200">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Dashboard Verifikator PPDB</h1>
                    <p class="text-xs text-slate-500">Panitia Verifikasi & Validasi Dokumen Persyaratan</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('admin.export.emis') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition">
                    <i class="fa-solid fa-file-excel mr-1.5 text-emerald-600"></i> Ekspor EMIS
                </a>
                <a href="{{ route('admin.export.dapodik') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold hover:bg-blue-100 transition">
                    <i class="fa-solid fa-file-csv mr-1.5 text-blue-600"></i> Ekspor Dapodik
                </a>
                <a href="{{ route('bendahara.kasir') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold hover:bg-amber-100 transition">
                    <i class="fa-solid fa-cash-register mr-1.5"></i> Kasir Loket
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Logout">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Sukses Memperbarui:</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Kesalahan:</h4>
                    <p class="mt-0.5">{{ session('error') ?? $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Filter Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6 shadow-sm">
            <form action="{{ route('verifikator.dashboard') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4 justify-between">
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <h2 class="font-black text-slate-900 text-base">Antrean Berkas Siswa</h2>
                    <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200">
                        {{ $registrations->total() }} Data
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-end">
                    <select name="status" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Menunggu Bayar</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                        <option value="revision_needed" {{ request('status') === 'revision_needed' ? 'selected' : '' }}>Perlu Revisi</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved / Lulus</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-extrabold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Kode & NIK</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Peminatan / Asrama</th>
                            <th class="py-3.5 px-4">Status & Kelengkapan</th>
                            <th class="py-3.5 px-4 text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($registrations as $reg)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-blue-700 block text-xs">{{ $reg->reg_code }}</span>
                                    <span class="font-mono text-slate-400 text-[11px]">{{ $reg->nik }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-900 block text-xs">{{ $reg->full_name }}</span>
                                    <span class="text-[11px] text-slate-400">WA: {{ $reg->phone_number }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-700 block">{{ $reg->cluster?->name ?? 'Belum Pilih' }}</span>
                                    <span class="text-[10px] {{ $reg->is_boarding ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 bg-slate-100' }} px-1.5 py-0.5 rounded font-semibold inline-block mt-0.5">
                                        {{ $reg->is_boarding ? 'Santri Mukim' : 'Non-Mukim' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="mb-1">
                                        @if($reg->status === 'approved')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                <i class="fa-solid fa-check mr-1"></i> Approved
                                            </span>
                                        @elseif($reg->status === 'revision_needed')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                                <i class="fa-solid fa-triangle-exclamation mr-1"></i> Perlu Revisi
                                            </span>
                                        @elseif($reg->status === 'paid')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                <i class="fa-solid fa-receipt mr-1"></i> Sudah Bayar
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                                {{ strtoupper($reg->status) }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-400">Berkas: <strong>{{ $reg->documents->count() }}</strong> diunggah</span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button type="button" 
                                            @click="openModal({{ json_encode($reg) }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm transition">
                                        <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Periksa Berkas
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Tidak ada antrean pendaftar pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-200">
                {{ $registrations->links() }}
            </div>
        </div>

    </main>

    <!-- ============================================================== -->
    <!-- IN-APP DOCUMENT PREVIEW & QUICK VERIFICATION MODAL (ALPINE.JS) -->
    <!-- ============================================================== -->
    <div x-show="previewModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4">
        
        <div class="bg-white rounded-3xl border border-slate-200 max-w-5xl w-full overflow-hidden shadow-2xl flex flex-col max-h-[90vh]"
             @click.away="previewModal = false">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base" x-text="'Periksa Berkas: ' + currentName"></h3>
                    <p class="text-xs text-slate-500">
                        Kode Registrasi: <span class="font-mono font-bold text-blue-700" x-text="currentRegCode"></span>
                    </p>
                </div>
                <button type="button" @click="previewModal = false" class="text-slate-400 hover:text-slate-600 p-2 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body: Split 2 Kolom (Viewer Kiri, Form Aksi Kanan) -->
            <div class="flex-1 overflow-y-auto grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                
                <!-- Kolom Kiri: Document Viewer (2 Kolom) -->
                <div class="md:col-span-2 p-5 bg-slate-900 flex flex-col justify-between min-h-[380px]">
                    <!-- Navigasi Tab Jenis Berkas -->
                    <div class="flex items-center space-x-2 mb-3 overflow-x-auto pb-2">
                        <template x-for="d in docsList" :key="d.id">
                            <button type="button" @click="selectDoc(d)"
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center space-x-1.5 shrink-0"
                                    :class="activeDocUrl === ('/storage/' + d.file_path) ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'">
                                <i class="fa-solid fa-file"></i>
                                <span x-text="d.doc_type.toUpperCase()"></span>
                            </button>
                        </template>
                        <template x-if="docsList.length === 0">
                            <span class="text-xs text-slate-400">Pendaftar belum mengunggah berkas digital.</span>
                        </template>
                    </div>

                    <!-- Area Pratinjau Inline Stream -->
                    <div class="flex-1 bg-slate-950 rounded-2xl flex items-center justify-center overflow-hidden border border-slate-800 p-2">
                        <template x-if="activeDocUrl && !isPdf">
                            <img :src="activeDocUrl" class="max-h-[460px] w-auto max-w-full object-contain rounded-lg shadow">
                        </template>

                        <template x-if="activeDocUrl && isPdf">
                            <iframe :src="activeDocUrl" class="w-full h-[460px] rounded-lg border-0"></iframe>
                        </template>

                        <template x-if="!activeDocUrl">
                            <div class="text-center p-8 text-slate-500">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <p class="text-xs">Tidak ada pratinjau berkas yang dipilih.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Quick Verification (1 Kolom) -->
                <div class="p-6 bg-white flex flex-col justify-between">
                    <form :action="'/verifikator/verify/' + currentRegId" method="POST">
                        @csrf
                        <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider mb-3">Keputusan Verifikasi</h4>

                        <!-- Status Option -->
                        <div class="space-y-2 mb-4">
                            <label class="flex items-center space-x-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="currentStatus === 'approved' ? 'border-emerald-600 bg-emerald-50 text-emerald-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="status" value="approved" x-model="currentStatus" class="text-emerald-600">
                                <span class="text-xs">Setujui / Lolos (Approved)</span>
                            </label>

                            <label class="flex items-center space-x-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="currentStatus === 'revision_needed' ? 'border-amber-600 bg-amber-50 text-amber-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="status" value="revision_needed" x-model="currentStatus" class="text-amber-600">
                                <span class="text-xs">Minta Revisi Dokumen</span>
                            </label>

                            <label class="flex items-center space-x-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="currentStatus === 'rejected' ? 'border-rose-600 bg-rose-50 text-rose-900 font-bold' : 'border-slate-200 text-slate-700'">
                                <input type="radio" name="status" value="rejected" x-model="currentStatus" class="text-rose-600">
                                <span class="text-xs">Tolak Pendaftaran</span>
                            </label>
                        </div>

                        <!-- Catatan Koreksi Wajib Jika Revisi / Ditolak -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Catatan Koreksi untuk Siswa
                                <span x-show="currentStatus !== 'approved'" class="text-rose-500">* (Wajib)</span>
                            </label>
                            <textarea name="catatan_koreksi" rows="4" x-model="currentNote"
                                      placeholder="Contoh: Foto Kartu Keluarga buram atau terpotong, mohon unggah ulang foto yang jelas..."
                                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <p class="text-[10px] text-slate-400 mt-1">Catatan ini akan langsung tampil merah pada dashboard & status publik siswa.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                            <button type="button" @click="previewModal = false" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-200 transition">
                                Simpan Keputusan
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

</body>
</html>

