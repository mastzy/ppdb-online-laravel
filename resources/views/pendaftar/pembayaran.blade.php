<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran Pendaftaran - PPDB Online 2026</title>
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
<body class="bg-slate-900 text-slate-100 min-h-screen py-8 px-4"
      x-data="{
          toastMessage: '',
          showToast: false,
          previewUrl: null,
          copyText(val, label) {
              navigator.clipboard.writeText(val);
              this.toastMessage = label + ' berhasil disalin ke clipboard!';
              this.showToast = true;
              setTimeout(() => { this.showToast = false; }, 3000);
          },
          handleFile(event) {
              const file = event.target.files[0];
              if (file && file.type.startsWith('image/')) {
                  this.previewUrl = URL.createObjectURL(file);
              } else {
                  this.previewUrl = null;
              }
          }
      }">

    <!-- Toast Notification Alpine.js -->
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-4"
         class="fixed bottom-6 right-6 z-50 bg-emerald-600 text-white px-5 py-3 rounded-2xl shadow-xl flex items-center space-x-3 text-xs font-bold border border-emerald-400">
        <i class="fa-solid fa-circle-check text-base"></i>
        <span x-text="toastMessage"></span>
    </div>

    <!-- Navigation Header -->
    <header class="max-w-4xl mx-auto mb-8 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-900">
                <i class="fa-solid fa-graduation-cap"></i>
            </a>
            <div>
                <h1 class="font-extrabold text-white text-base">Modul Pembayaran Mandiri - PPDB 2026</h1>
                <p class="text-xs text-slate-400">Kode Pendaftaran: <span class="text-emerald-400 font-mono font-bold">{{ $applicant->reg_code }}</span></p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('pendaftar.formulir') }}" class="text-xs font-bold text-slate-300 hover:text-white px-3 py-1.5 rounded-lg border border-slate-700 bg-slate-800 transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Data
            </a>
            <form action="{{ route('pendaftar.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-bold px-3 py-1.5 rounded-lg border border-rose-900/60 bg-rose-950/40 transition">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-4xl mx-auto space-y-6">

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

        @if(session('error') || $errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 flex items-start space-x-3 shadow-lg">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm text-rose-300">Peringatan:</h4>
                    <p class="mt-0.5">{{ session('error') ?? $errors->first() }}</p>
                </div>
            </div>
        @endif

        @php
            // Hitung 3-Digit Unique Code dari ID Pendaftar
            $uniqueCode = str_pad(($applicant->id % 900) + 100, 3, '0', STR_PAD_LEFT);
            $totalAmount = $baseAmount + (int)$uniqueCode;
        @endphp

        <!-- Tagihan Display Card (Hero Nominal) -->
        <div class="bg-gradient-to-br from-slate-800 via-slate-850 to-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-700 pb-6 mb-6">
                <div>
                    <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider bg-emerald-950/70 border border-emerald-800 px-3 py-1 rounded-full">
                        Tagihan Biaya Registrasi
                    </span>
                    <h2 class="text-xl font-black text-white mt-2">{{ $applicant->full_name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Klaster: <span class="text-slate-200 font-semibold">{{ $applicant->cluster?->name ?? 'Belum memilih' }}</span>
                        @if($applicant->has_sibling_discount)
                            <span class="ml-2 bg-emerald-900/60 text-emerald-300 text-[10px] px-2 py-0.5 rounded border border-emerald-700">Diskon Sibling 20%</span>
                        @endif
                    </p>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-xs text-slate-400 block font-medium">Tagihan Resmi:</span>
                    <span class="text-xs font-bold text-slate-300">Rp {{ number_format($baseAmount, 0, ',', '.') }}</span>
                    <span class="text-xs text-slate-400 block font-medium mt-1">Total Nominal Transfer:</span>
                    <div class="flex items-center sm:justify-end space-x-2 mt-1">
                        <span class="text-2xl sm:text-3xl font-black text-emerald-400 font-mono tracking-tight">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </span>
                        <button type="button" @click="copyText('{{ $totalAmount }}', 'Nominal transfer')"
                                class="px-2.5 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-xs text-slate-200 font-bold transition flex items-center space-x-1"
                                title="Salin Nominal Pas">
                            <i class="fa-regular fa-copy"></i>
                            <span class="text-[11px]">Salin</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-amber-300/90 mt-1 font-medium">
                        *Termasuk 3 Digit Kode Unik: <span class="font-bold underline text-white">{{ $uniqueCode }}</span> untuk verifikasi instan.
                    </p>
                </div>
            </div>

            <!-- Rekening Bank Sekolah Grid -->
            <div class="mb-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Pilihan Rekening Resmi Sekolah</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($bankAccounts as $bank)
                        <div class="bg-slate-900/70 border border-slate-700/80 rounded-2xl p-4 flex flex-col justify-between hover:border-slate-600 transition">
                            <div>
                                <span class="text-xs font-bold text-emerald-400 block">{{ $bank['bank'] }}</span>
                                <span class="text-base font-extrabold text-white font-mono tracking-wider block mt-1">
                                    {{ $bank['account_number'] }}
                                </span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">a.n. {{ $bank['account_name'] }}</span>
                            </div>
                            <div class="mt-3 pt-2 border-t border-slate-800">
                                <button type="button" @click="copyText('{{ $bank['account_number'] }}', 'Nomor rekening {{ $bank['bank'] }}')"
                                        class="w-full py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-[11px] font-bold text-slate-300 transition flex items-center justify-center space-x-1">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                    <span>Salin No. Rekening</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Opsi Bayar Tunai di Loket Sekolah (Offline) -->
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start space-x-3">
                    <i class="fa-solid fa-store text-xl text-amber-400 mt-1"></i>
                    <div>
                        <h4 class="font-bold text-xs text-amber-300">Pilihan Bayar Tunai di Loket Sekolah (Offline)</h4>
                        <p class="text-[11px] text-amber-200/80 mt-0.5">
                            Jika kesulitan melakukan transfer bank, calon peserta didik/wali santri dapat langsung membayar tunai ke Bendahara Panitia PPDB di sekolah dengan menunjukkan Kode Pendaftaran: <span class="font-mono font-bold text-white">{{ $applicant->reg_code }}</span>.
                        </p>
                    </div>
                </div>
                <div class="sm:shrink-0">
                    <span class="inline-block px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-500/30">
                        Loket Buka 08:00 - 14:00 WIB
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Upload Bukti Transfer Bank -->
        <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 sm:p-8 shadow-xl">
            <div class="border-b border-slate-700 pb-4 mb-6">
                <h3 class="text-base font-extrabold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-receipt text-emerald-400"></i>
                    <span>Konfirmasi & Unggah Bukti Transfer</span>
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Silakan unggah foto struk ATM, tangkapan layar m-Banking, atau bukti transfer resmi Anda di bawah ini.
                </p>
            </div>

            <!-- Riwayat Bukti Sebelumnya Jika Ada -->
            @if($latestPayment)
                <div class="mb-6 p-4 rounded-2xl bg-slate-900 border border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-950 text-emerald-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block">Bukti Transfer Terakhir Diunggah:</span>
                            <span class="text-[11px] text-slate-400">
                                Bank: <strong class="text-slate-300">{{ $latestPayment->sender_bank }}</strong> | Pengirim: <strong class="text-slate-300">{{ $latestPayment->sender_name }}</strong>
                            </span>
                        </div>
                    </div>
                    <div>
                        @if($latestPayment->status === 'verified')
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <i class="fa-solid fa-check mr-1"></i> Terverifikasi Lunas
                            </span>
                        @elseif($latestPayment->status === 'rejected')
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                <i class="fa-solid fa-xmark mr-1"></i> Bukti Ditolak
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                <i class="fa-solid fa-clock mr-1"></i> Menunggu Verifikasi Bendahara
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <form action="{{ route('pendaftar.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">
                            Nama Bank / Dompet Digital Pengirim <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" name="sender_bank" required
                               placeholder="Contoh: BCA, BSI, BRI, Mandiri, Dana"
                               value="{{ old('sender_bank', $latestPayment?->sender_bank) }}"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">
                            Nama Pemilik Rekening Pengirim <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" name="sender_name" required
                               placeholder="Nama pengirim sesuai struk transfer"
                               value="{{ old('sender_name', $latestPayment?->sender_name) }}"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1.5">
                            Unggah Foto / Tangkapan Layar Struk Transfer <span class="text-rose-400">*</span>
                        </label>
                        
                        <div class="border-2 border-dashed border-slate-700 hover:border-emerald-500 rounded-2xl p-6 text-center transition bg-slate-900/50">
                            <template x-if="!previewUrl">
                                <div>
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-500 mb-2"></i>
                                    <p class="text-xs text-slate-300 font-bold">Pilih foto bukti pembayaran atau potret langsung</p>
                                    <p class="text-[11px] text-slate-500 mt-1">Format: JPG, PNG, atau PDF (Ukuran Maksimal 2MB)</p>
                                </div>
                            </template>
                            
                            <template x-if="previewUrl">
                                <div class="relative inline-block mt-2">
                                    <img :src="previewUrl" class="max-h-48 rounded-xl border border-slate-600 shadow-md">
                                    <span class="block text-[11px] text-emerald-400 font-bold mt-2">Pratinjau Foto Struk</span>
                                </div>
                            </template>

                            <div class="mt-4">
                                <label class="cursor-pointer inline-flex items-center px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-600 text-xs font-bold transition">
                                    <i class="fa-solid fa-camera mr-2"></i>
                                    <span>Pilih Berkas / Foto</span>
                                    <input type="file" name="proof_file" required accept="image/*,application/pdf" capture="environment" class="hidden" @change="handleFile($event)">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-700">
                    <a href="{{ route('pendaftar.formulir') }}" class="text-xs font-bold text-slate-400 hover:text-white transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Biodata
                    </a>
                    
                    <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-lg shadow-emerald-950 transition flex items-center space-x-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Bukti Pembayaran</span>
                    </button>
                </div>
            </form>
        </div>

    </main>

    <footer class="mt-12 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu.</p>
    </footer>

</body>
</html>
