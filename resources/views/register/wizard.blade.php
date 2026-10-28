<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formulir Pendaftaran Siswa Baru - Progressive Wizard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen font-sans selection:bg-teal-500 selection:text-white"
      x-data="registrationWizard({
          initialStep: {{ $applicant ? ($applicant->status === 'pending_payment' || $applicant->status === 'paid' ? 4 : ($applicant->cluster_id ? 3 : 2)) : 1 }},
          regCode: '{{ $applicant->reg_code ?? '' }}',
          fullName: '{{ addslashes($applicant->full_name ?? '') }}',
          nik: '{{ $applicant->nik ?? '' }}',
          dob: '{{ $applicant && $applicant->dob ? $applicant->dob->format('Y-m-d') : '' }}',
          phoneNumber: '{{ $applicant->phone_number ?? '' }}',
          waveName: '{{ $applicant->wave_name ?? 'Gelombang 1' }}',
          clusterId: '{{ $applicant->cluster_id ?? '' }}',
          isBoarding: {{ $applicant && $applicant->is_boarding ? 'true' : 'false' }},
          parentName: '{{ addslashes($applicant->parent_name ?? '') }}',
          parentPhone: '{{ $applicant->parent_phone ?? '' }}',
          parentJob: '{{ addslashes($applicant->parent_job ?? '') }}',
          hasSibling: {{ $applicant && $applicant->has_sibling_discount ? 'true' : 'false' }},
          siblingNisn: '{{ $applicant->sibling_nisn ?? '' }}',
          siblingName: '{{ addslashes($applicant->sibling_name ?? '') }}',
          baseAmount: {{ $applicant && $applicant->has_sibling_discount ? 240000 : 300000 }}
      })">

    <!-- Toast Notification Container -->
    <div x-data="{ toasts: [] }" 
         @notify.window="toasts.push({ id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'success' }); setTimeout(() => toasts.shift(), 3500)"
         class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="pointer-events-auto px-4 py-3 rounded-2xl shadow-2xl border text-sm font-semibold flex items-center gap-3 backdrop-blur-md"
                 :class="{
                     'bg-emerald-950/90 border-emerald-500/50 text-emerald-200': t.type === 'success',
                     'bg-rose-950/90 border-rose-500/50 text-rose-200': t.type === 'error',
                     'bg-amber-950/90 border-amber-500/50 text-amber-200': t.type === 'warning',
                     'bg-teal-950/90 border-teal-500/50 text-teal-200': t.type === 'info'
                 }">
                <span x-show="t.type === 'success'">✅</span>
                <span x-show="t.type === 'error'">⚠️</span>
                <span x-show="t.type === 'warning'">⚡</span>
                <span x-text="t.message"></span>
            </div>
        </template>
    </div>

    <!-- Ambient Glow Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation Header -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-400 p-0.5 shadow-md shadow-teal-500/20">
                    <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="block text-sm font-extrabold text-white">PPDB ONLINE</span>
                    <span class="block text-[10px] font-semibold text-teal-400">1-Minute Fast Registration</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <template x-if="regCode">
                    <div class="flex items-center gap-2 bg-slate-800/80 border border-slate-700/80 px-3 py-1.5 rounded-xl">
                        <span class="text-[11px] text-slate-400">Kode:</span>
                        <span class="font-mono text-xs font-bold text-teal-300" x-text="regCode"></span>
                    </div>
                </template>
                <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white px-2 py-1">Batal</a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8 sm:py-12 space-y-8">

        <!-- Stepper Progress Bar Header -->
        <div class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-xs font-bold text-teal-400 uppercase tracking-wider block">Langkah <span x-text="currentStep"></span> dari 3</span>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-white mt-0.5" x-text="getStepTitle()"></h1>
                </div>
                <div class="text-right">
                    <span class="text-2xl sm:text-3xl font-extrabold font-mono text-teal-400" x-text="getProgressPercent() + '%'"></span>
                    <span class="text-[11px] text-slate-400 block font-medium" x-text="getProgressText()"></span>
                </div>
            </div>

            <!-- Visual Bar -->
            <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden p-0.5 border border-slate-700/50">
                <div class="h-full bg-gradient-to-r from-teal-500 to-emerald-400 rounded-full transition-all duration-500 ease-out shadow-sm"
                     :style="'width: ' + getProgressPercent() + '%'"></div>
            </div>

            <!-- Stepper Horizontal Icons -->
            <div class="grid grid-cols-3 gap-2 mt-6 pt-6 border-t border-slate-800 text-xs text-center">
                <!-- Step 1 Icon -->
                <div class="flex flex-col items-center gap-1.5"
                     :class="currentStep >= 1 ? 'text-teal-400 font-bold' : 'text-slate-400'">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all"
                         :class="currentStep > 1 ? 'bg-emerald-500 text-white' : (currentStep === 1 ? 'bg-teal-500 text-white ring-4 ring-teal-500/20' : 'bg-slate-800 text-slate-400')">
                        <span x-show="currentStep > 1">✓</span>
                        <span x-show="currentStep <= 1">1</span>
                    </div>
                    <span>Data & Klaster</span>
                </div>

                <!-- Step 2 Icon -->
                <div class="flex flex-col items-center gap-1.5"
                     :class="currentStep >= 2 ? 'text-teal-400 font-bold' : 'text-slate-400'">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all"
                         :class="currentStep > 2 ? 'bg-emerald-500 text-white' : (currentStep === 2 ? 'bg-teal-500 text-white ring-4 ring-teal-500/20' : 'bg-slate-800 text-slate-400')">
                        <span x-show="currentStep > 2">✓</span>
                        <span x-show="currentStep <= 2">2</span>
                    </div>
                    <span>Pembayaran</span>
                </div>

                <!-- Step 3 Icon -->
                <div class="flex flex-col items-center gap-1.5"
                     :class="currentStep >= 3 ? 'text-teal-400 font-bold' : 'text-slate-400'">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all"
                         :class="currentStep === 3 ? 'bg-teal-500 text-white ring-4 ring-teal-500/20' : 'bg-slate-800 text-slate-400'">
                        <span>3</span>
                    </div>
                    <span>Upload Berkas</span>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- STEP 1: KUNCI KUOTA & KLASTER (< 1 MENIT)  -->
        <!-- ========================================== -->
        <div x-show="currentStep === 1" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">

            <div class="border-b border-slate-700/60 pb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/10 text-teal-400 text-xs font-bold uppercase tracking-wider mb-2">
                    Langkah 1: Kunci Kuota & Kurikulum
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white">Identitas Singkat & Pilihan Klaster</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">Cukup isi data pokok di bawah untuk langsung mengamankan nomor kuota.</p>
            </div>

            <form @submit.prevent="submitStep1" class="space-y-6">
                <!-- Data Calon Siswa -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap Siswa *</label>
                        <input type="text" x-model="fullName" required placeholder="Sesuai Akta Kelahiran / Ijazah"
                               class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">NIK 16 Digit *</label>
                        <input type="text" x-model="nik" required maxlength="16" pattern="\d{16}" inputmode="numeric" placeholder="16 digit sesuai Kartu Keluarga"
                               class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 font-mono text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Tanggal Lahir *</label>
                        <input type="date" x-model="dob" required
                               class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">No. WhatsApp / HP Aktif *</label>
                        <input type="text" x-model="phoneNumber" required placeholder="Contoh: 081234567890 (Untuk notifikasi kelulusan)"
                               class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 text-sm">
                    </div>
                </div>

                <!-- Pilihan Klaster Kurikulum Merdeka (Card Interactive Selection) -->
                <div class="pt-4 border-t border-slate-800 space-y-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Pilih Klaster Kurikulum Merdeka *
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        @foreach($clusters as $cluster)
                            <div @click="clusterId = '{{ $cluster->id }}'"
                                 :class="clusterId == '{{ $cluster->id }}' ? 'bg-teal-950/60 border-teal-500 ring-2 ring-teal-500/30 shadow-lg' : 'bg-slate-900/80 border-slate-700 hover:border-slate-600'"
                                 class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <h3 class="font-bold text-sm text-white">{{ $cluster->name }}</h3>
                                        <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded-full bg-teal-500/20 text-teal-300">
                                            Kuota {{ $cluster->quota }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 leading-relaxed">{{ $cluster->description }}</p>
                                </div>
                                <div class="mt-3 pt-2 border-t border-slate-800 flex items-center justify-between text-xs">
                                    <span class="text-slate-400">Pilihan Rumpun</span>
                                    <span class="font-bold" :class="clusterId == '{{ $cluster->id }}' ? 'text-teal-400' : 'text-slate-400'">
                                        <span x-show="clusterId == '{{ $cluster->id }}'">✓ Terpilih</span>
                                        <span x-show="clusterId != '{{ $cluster->id }}'">Pilih</span>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status Asrama / Mukim -->
                <div class="pt-4 border-t border-slate-800 space-y-3">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Status Asrama / Mukim *
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div @click="isBoarding = true"
                             :class="isBoarding ? 'bg-teal-950/60 border-teal-500 ring-2 ring-teal-500/30' : 'bg-slate-900/80 border-slate-700 hover:border-slate-600'"
                             class="p-4 rounded-2xl border transition-all cursor-pointer">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-base">🕌</span>
                                <h3 class="font-bold text-sm text-white">Santri Mukim (Tinggal di Pesantren)</h3>
                            </div>
                            <p class="text-xs text-slate-400">Mendapatkan asrama pondok, pembinaan 24 jam & tahfidz intensif.</p>
                        </div>

                        <div @click="isBoarding = false"
                             :class="!isBoarding ? 'bg-teal-950/60 border-teal-500 ring-2 ring-teal-500/30' : 'bg-slate-900/80 border-slate-700 hover:border-slate-600'"
                             class="p-4 rounded-2xl border transition-all cursor-pointer">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-base">🏡</span>
                                <h3 class="font-bold text-sm text-white">Santri Non-Mukim (Pulang-Pergi)</h3>
                            </div>
                            <p class="text-xs text-slate-400">Mengikuti jam belajar reguler sekolah tanpa menetap di asrama.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" 
                            :disabled="loading"
                            class="min-h-[50px] w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 disabled:opacity-60 text-white font-bold rounded-2xl shadow-lg shadow-teal-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span x-show="!loading">Lanjut ke Pilihan Pembayaran (Step 2) →</span>
                        <span x-show="loading" class="inline-flex items-center gap-2" style="display:none;">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            <span>Menyimpan & Mengunci Kuota...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- STEP 2: PILIHAN PEMBAYARAN & SIBLING       -->
        <!-- ========================================== -->
        <div x-show="currentStep === 2" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             style="display: none;"
             class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">

            <div class="border-b border-slate-700/60 pb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">
                    Langkah 2: Opsi Pembayaran
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white">Biaya Pendaftaran & Metode Pembayaran</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">Nominal resmi bulat Rp 300.000 tanpa biaya admin tersembunyi.</p>
            </div>

            <!-- Diskon Sibling Auto Check -->
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/80 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white">Punya Kakak yang Bersekolah di Sini?</h3>
                        <p class="text-xs text-slate-400">Dapatkan diskon khusus saudara kandung 20% otomatis.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="hasSibling" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                    </label>
                </div>

                <div x-show="hasSibling" class="pt-3 border-t border-slate-800 space-y-2">
                    <label class="block text-xs font-semibold text-slate-300">Masukkan 10 Digit NISN Kakak:</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="siblingNisn" maxlength="10" placeholder="Contoh: 0071234567"
                               class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white font-mono text-xs focus:border-teal-500">
                        <button type="button" @click="verifySibling" class="px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white rounded-xl text-xs font-bold shrink-0">
                            Cek NISN
                        </button>
                    </div>
                    <div x-show="siblingVerified" class="text-xs text-emerald-400 font-semibold flex items-center gap-1.5" style="display: none;">
                        <span>✓</span> Kakak ditemukan: <span x-text="siblingName"></span> (Diskon 20% Diterapkan!)
                    </div>
                </div>
            </div>

            <!-- Total Biaya Card -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-950 border border-teal-500/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-slate-400 block">Total Tagihan Formulir</span>
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-extrabold font-mono text-emerald-400" x-text="formatRupiah(baseAmount)">Rp 300.000</span>
                        <template x-if="hasSibling">
                            <span class="text-xs line-through text-slate-400 font-mono">Rp 300.000</span>
                        </template>
                    </div>
                </div>

                <!-- Copy Amount Button -->
                <button type="button" 
                        @click="copyText(baseAmount, 'Nominal tagihan berhasil disalin!')"
                        class="px-4 py-2.5 bg-slate-800 hover:bg-slate-750 border border-slate-700 text-teal-300 hover:text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Salin Nominal & Kode</span>
                </button>
            </div>

            <!-- Two Payment Methods Selection -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Method 1: Transfer Bank Online -->
                <div @click="paymentMethod = 'transfer'" 
                     :class="paymentMethod === 'transfer' ? 'bg-teal-950/60 border-teal-500 ring-2 ring-teal-500/30' : 'bg-slate-900/80 border-slate-700 hover:border-slate-600'"
                     class="p-5 rounded-2xl border transition-all cursor-pointer space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">💳</span>
                            <h3 class="font-bold text-sm text-white">Transfer Bank Online</h3>
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-teal-500/20 text-teal-300">Rekomendasi</span>
                    </div>
                    <p class="text-xs text-slate-400">Transfer ke rekening resmi BSI / Mandiri / BRI sekolah, lalu unggah struk.</p>
                    
                    <div class="pt-2 border-t border-slate-800 text-xs text-slate-300 space-y-1">
                        <div class="flex justify-between">
                            <span class="text-slate-400">BSI Syariah</span>
                            <span class="font-mono font-bold text-white">7123456789</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Mandiri</span>
                            <span class="font-mono font-bold text-white">1370009876543</span>
                        </div>
                    </div>
                </div>

                <!-- Method 2: Bayar Tunai di Loket Sekolah -->
                <div @click="paymentMethod = 'cash'" 
                     :class="paymentMethod === 'cash' ? 'bg-teal-950/60 border-teal-500 ring-2 ring-teal-500/30' : 'bg-slate-900/80 border-slate-700 hover:border-slate-600'"
                     class="p-5 rounded-2xl border transition-all cursor-pointer space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">💵</span>
                            <h3 class="font-bold text-sm text-white">Bayar Tunai di Loket Sekolah</h3>
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300">Kasir Offline</span>
                    </div>
                    <p class="text-xs text-slate-400">Datang langsung ke bendahara sekolah dengan membawa Kode Registrasi.</p>
                    <div class="pt-2 border-t border-slate-800 text-xs text-slate-400">
                        Loket buka: Senin - Sabtu (08.00 - 14.00 WIB)
                    </div>
                </div>
            </div>

            <!-- Step Navigation -->
            <div class="pt-4 flex items-center justify-between">
                <button type="button" @click="currentStep = 1" class="text-xs font-semibold text-slate-400 hover:text-white px-4 py-2">
                    ← Kembali ke Data Diri
                </button>
                <button type="button" 
                        @click="submitStep2"
                        class="min-h-[50px] px-8 py-3.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-teal-500/30 transition-all flex items-center gap-2 cursor-pointer">
                    <span>Lanjut ke Upload Berkas (Step 3) →</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- STEP 3: UPLOAD BERKAS & KAMERA LANGSUNG    -->
        <!-- ========================================== -->
        <div x-show="currentStep === 3" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             style="display: none;"
             class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">

            <div class="border-b border-slate-700/60 pb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-500/10 text-teal-400 text-xs font-bold uppercase tracking-wider mb-2">
                    Langkah 3: Unggah Berkas Persyaratan
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white">Foto & Pratinjau Dokumen</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">Dapat difoto langsung menggunakan kamera HP tanpa perlu scanner.</p>
            </div>

            <!-- Upload Slots -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Slot KK -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">1. Kartu Keluarga (KK) *</span>
                        <span class="text-[10px] text-teal-400 font-mono">Wajib</span>
                    </div>

                    <div class="relative border-2 border-dashed border-slate-700 rounded-xl p-4 text-center hover:border-teal-500 transition-colors bg-slate-850">
                        <template x-if="previews.kk">
                            <div class="space-y-2">
                                <img :src="previews.kk" class="h-28 mx-auto rounded-lg object-contain shadow-md">
                                <span class="text-[11px] text-emerald-400 block font-semibold">✓ Siap diunggah</span>
                            </div>
                        </template>
                        <template x-if="!previews.kk">
                            <div class="space-y-2 py-2">
                                <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-xs text-slate-400 block">Ambil Foto / Pilih Berkas</span>
                            </div>
                        </template>

                        <!-- Input File with camera capture support -->
                        <input type="file" 
                               accept="image/*,application/pdf"
                               capture="environment"
                               @change="handleFileChange($event, 'kk')"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                </div>

                <!-- Slot Akta -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">2. Akta Kelahiran *</span>
                        <span class="text-[10px] text-teal-400 font-mono">Wajib</span>
                    </div>

                    <div class="relative border-2 border-dashed border-slate-700 rounded-xl p-4 text-center hover:border-teal-500 transition-colors bg-slate-850">
                        <template x-if="previews.akta">
                            <div class="space-y-2">
                                <img :src="previews.akta" class="h-28 mx-auto rounded-lg object-contain shadow-md">
                                <span class="text-[11px] text-emerald-400 block font-semibold">✓ Siap diunggah</span>
                            </div>
                        </template>
                        <template x-if="!previews.akta">
                            <div class="space-y-2 py-2">
                                <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-xs text-slate-400 block">Ambil Foto / Pilih Berkas</span>
                            </div>
                        </template>

                        <input type="file" 
                               accept="image/*,application/pdf"
                               capture="environment"
                               @change="handleFileChange($event, 'akta')"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                </div>

                <!-- Slot SKL / Ijazah -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">3. SKL / Ijazah SMP</span>
                        <span class="text-[10px] text-slate-400 font-mono">Bisa Menyusul</span>
                    </div>

                    <div class="relative border-2 border-dashed border-slate-700 rounded-xl p-4 text-center hover:border-teal-500 transition-colors bg-slate-850">
                        <template x-if="previews.skl">
                            <div class="space-y-2">
                                <img :src="previews.skl" class="h-28 mx-auto rounded-lg object-contain shadow-md">
                                <span class="text-[11px] text-emerald-400 block font-semibold">✓ Siap diunggah</span>
                            </div>
                        </template>
                        <template x-if="!previews.skl">
                            <div class="space-y-2 py-2">
                                <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-xs text-slate-400 block">Ambil Foto / Pilih Berkas</span>
                            </div>
                        </template>

                        <input type="file" 
                               accept="image/*,application/pdf"
                               capture="environment"
                               @change="handleFileChange($event, 'skl')"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                </div>

                <!-- Slot Pas Foto -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">4. Pas Foto Berwarna 3x4</span>
                        <span class="text-[10px] text-teal-400 font-mono">Wajib</span>
                    </div>

                    <div class="relative border-2 border-dashed border-slate-700 rounded-xl p-4 text-center hover:border-teal-500 transition-colors bg-slate-850">
                        <template x-if="previews.passfoto">
                            <div class="space-y-2">
                                <img :src="previews.passfoto" class="h-28 mx-auto rounded-lg object-contain shadow-md">
                                <span class="text-[11px] text-emerald-400 block font-semibold">✓ Siap diunggah</span>
                            </div>
                        </template>
                        <template x-if="!previews.passfoto">
                            <div class="space-y-2 py-2">
                                <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-xs text-slate-400 block">Ambil Foto Wajah Siswa</span>
                            </div>
                        </template>

                        <input type="file" 
                               accept="image/*"
                               capture="user"
                               @change="handleFileChange($event, 'passfoto')"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Finalize Confirmation & Submit -->
            <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" @click="currentStep = 2" class="text-xs font-semibold text-slate-400 hover:text-white px-4 py-2">
                    ← Kembali ke Pembayaran
                </button>

                <button type="button" 
                        @click="finishRegistration"
                        :disabled="loading"
                        class="min-h-[50px] w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold rounded-2xl shadow-xl shadow-emerald-500/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <span x-show="!loading">🚀 Selesaikan & Buka Dashboard Pendaftar</span>
                    <span x-show="loading" class="inline-flex items-center gap-2" style="display:none;">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        <span>Memproses Pendaftaran...</span>
                    </span>
                </button>
            </div>
        </div>

    </main>

    <!-- Wizard JavaScript Driver (Alpine Component) -->
    <script>
        function registrationWizard(config) {
            return {
                currentStep: config.initialStep || 1,
                regCode: config.regCode,
                fullName: config.fullName,
                nik: config.nik,
                dob: config.dob,
                phoneNumber: config.phoneNumber,
                waveName: config.waveName,
                clusterId: config.clusterId,
                isBoarding: config.isBoarding,
                parentName: config.parentName || 'Orang Tua / Wali',
                parentPhone: config.parentPhone || config.phoneNumber,
                parentJob: config.parentJob || 'Wiraswasta',
                hasSibling: config.hasSibling,
                siblingNisn: config.siblingNisn,
                siblingName: config.siblingName,
                siblingVerified: !!config.siblingNisn,
                paymentMethod: 'transfer',
                baseAmount: config.baseAmount || 300000,
                loading: false,
                previews: {
                    kk: null,
                    akta: null,
                    skl: null,
                    passfoto: null
                },

                getStepTitle() {
                    if (this.currentStep === 1) return 'Kunci Kuota & Rumpun Keahlian';
                    if (this.currentStep === 2) return 'Pilihan Pembayaran & Diskon';
                    return 'Upload Berkas & Foto Siswa';
                },

                getProgressPercent() {
                    if (this.currentStep === 1) return 33;
                    if (this.currentStep === 2) return 66;
                    return 100;
                },

                getProgressText() {
                    if (this.currentStep === 1) return '33% Selesai';
                    if (this.currentStep === 2) return '66% Selesai';
                    return 'Hampir Selesai! (100%)';
                },

                formatRupiah(num) {
                    return 'Rp ' + Number(num).toLocaleString('id-ID');
                },

                copyText(text, message) {
                    window.copyToClipboard(text, message);
                },

                async submitStep1() {
                    if (!this.clusterId) {
                        window.showToast('Silakan pilih salah satu Klaster Kurikulum Merdeka.', 'warning');
                        return;
                    }
                    this.loading = true;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        // 1. Simpan Step 1 (Quick Lock)
                        let res1 = await fetch('{{ route('pendaftar.step1') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                full_name: this.fullName,
                                nik: this.nik,
                                dob: this.dob,
                                phone_number: this.phoneNumber,
                                wave_name: this.waveName
                            })
                        });
                        let json1 = await res1.json();
                        if (!res1.ok || !json1.success) {
                            window.showToast(json1.message || 'Gagal menyimpan Step 1', 'error');
                            this.loading = false;
                            return;
                        }

                        this.regCode = json1.reg_code;

                        // 2. Simpan Step 2 (Klaster & Asrama)
                        let res2 = await fetch('{{ route('pendaftar.step2') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                cluster_id: this.clusterId,
                                is_boarding: this.isBoarding
                            })
                        });

                        window.showToast('Kuota berhasil dikunci! Kode: ' + this.regCode, 'success');
                        this.currentStep = 2;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } catch (e) {
                        window.showToast('Terjadi gangguan jaringan.', 'error');
                    } finally {
                        this.loading = false;
                    }
                },

                async verifySibling() {
                    if (!this.siblingNisn || this.siblingNisn.length < 5) {
                        window.showToast('Masukkan minimal 5-10 digit NISN', 'warning');
                        return;
                    }
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let res = await fetch('{{ route('pendaftar.check_sibling') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({ nisn: this.siblingNisn })
                        });
                        let json = await res.json();
                        if (json.success) {
                            this.siblingVerified = true;
                            this.siblingName = json.sibling_name;
                            this.baseAmount = 240000;
                            window.showToast(json.message, 'success');
                        } else {
                            window.showToast(json.message, 'warning');
                        }
                    } catch (e) {
                        window.showToast('Gagal memverifikasi NISN.', 'error');
                    }
                },

                async submitStep2() {
                    this.loading = true;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let res = await fetch('{{ route('pendaftar.step3') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                parent_name: this.parentName || 'Orang Tua ' + this.fullName,
                                parent_phone: this.parentPhone || this.phoneNumber,
                                parent_job: this.parentJob || 'Wiraswasta',
                                has_sibling_discount: this.hasSibling,
                                sibling_nisn: this.siblingNisn,
                                sibling_name: this.siblingName
                            })
                        });
                        let json = await res.json();
                        if (json.success) {
                            window.showToast('Data pembayaran & diskon tersimpan.', 'success');
                            this.currentStep = 3;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    } catch (e) {
                        window.showToast('Gagal melanjutkan.', 'error');
                    } finally {
                        this.loading = false;
                    }
                },

                handleFileChange(event, type) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Buat pratinjau instan jika berupa gambar
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previews[type] = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.previews[type] = 'https://placehold.co/150x150/1e293b/ffffff?text=' + type.toUpperCase();
                    }

                    // Unggah langsung via AJAX
                    this.uploadSingleDoc(file, type);
                },

                async uploadSingleDoc(file, type) {
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('doc_type', type);

                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    try {
                        let res = await fetch('{{ route('pendaftar.upload_document') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        let json = await res.json();
                        if (json.success) {
                            window.showToast('Berkas ' + type.toUpperCase() + ' berhasil diunggah!', 'success');
                        } else {
                            window.showToast('Gagal mengunggah berkas: ' + json.message, 'error');
                        }
                    } catch (e) {
                        window.showToast('Gagal mengunggah berkas.', 'error');
                    }
                },

                async finishRegistration() {
                    this.loading = true;
                    try {
                        // Submit finalize
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('pendaftar.finalize') }}';
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        form.appendChild(csrfInput);
                        document.body.appendChild(form);
                        form.submit();
                    } catch (e) {
                        this.loading = false;
                        window.showToast('Gagal memproses finalisasi pendaftaran.', 'error');
                    }
                }
            }
        }
    </script>
</body>
</html>
