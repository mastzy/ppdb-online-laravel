<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Siswa Baru - PPDB 2026</title>
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
<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-200">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </a>
                <div>
                    <h1 class="font-extrabold text-slate-900 leading-tight text-base sm:text-lg">PPDB Online 2026</h1>
                    <p class="text-xs text-slate-500">Penerimaan Santri & Peserta Didik Baru</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                @if(session()->has('applicant_id') || $applicant)
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs text-slate-400 font-medium">Pendaftar Aktif</span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            {{ $applicant?->reg_code ?? 'Tersimpan' }}
                        </span>
                    </div>
                    <form action="{{ route('pendaftar.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-semibold px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50 transition">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('pendaftar.login') }}" class="text-xs text-slate-700 hover:text-emerald-600 font-semibold px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition">
                        <i class="fa-solid fa-key mr-1"></i> Masuk Akun
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Container with Wizard -->
    <main class="max-w-4xl mx-auto px-4 py-8" 
          x-data="{
              step: {{ $applicant ? ($applicant->status === 'draft' ? ($applicant->cluster_id ? 3 : 2) : 1) : 1 }},
              regCode: '{{ $applicant?->reg_code ?? '' }}',
              selectedCluster: {{ $applicant?->cluster_id ?? 'null' }},
              isBoarding: {{ $applicant && $applicant->is_boarding ? '1' : '0' }},
              hasSibling: {{ $applicant && $applicant->has_sibling_discount ? '1' : '0' }},
              siblingNisn: '{{ $applicant?->sibling_nisn ?? '' }}',
              siblingChecking: false,
              siblingMessage: '',
              siblingValid: false,
              docs: {
                  kk: '{{ isset($documents['kk']) ? asset('storage/'.$documents['kk']->file_path) : '' }}',
                  akta: '{{ isset($documents['akta']) ? asset('storage/'.$documents['akta']->file_path) : '' }}',
                  skl: '{{ isset($documents['skl']) ? asset('storage/'.$documents['skl']->file_path) : '' }}'
              },
              uploading: false,
              uploadMsg: '',
              checkSiblingDiscount() {
                  if (this.siblingNisn.length < 5) return;
                  this.siblingChecking = true;
                  fetch('{{ route('pendaftar.check_sibling') }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({ nisn: this.siblingNisn })
                  })
                  .then(res => res.json())
                  .then(data => {
                      this.siblingChecking = false;
                      if (data.success) {
                          this.siblingValid = true;
                          this.hasSibling = 1;
                          this.siblingMessage = data.message;
                      } else {
                          this.siblingValid = false;
                          this.siblingMessage = data.message || 'NISN kakak tidak terdaftar di sistem sekolah.';
                      }
                  })
                  .catch(() => {
                      this.siblingChecking = false;
                      this.siblingMessage = 'Gagal memverifikasi NISN.';
                  });
              }
          }">

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-sm">Berhasil!</h4>
                    <p class="text-xs mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-sm">Peringatan Input:</h4>
                    <p class="text-xs mt-0.5">{{ session('error') ?? $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Visual Stepper Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 w-full z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-emerald-600 transition-all duration-300 z-0"
                     :style="step === 1 ? 'width: 0%' : (step === 2 ? 'width: 50%' : 'width: 100%')"></div>

                <!-- Step 1 Button -->
                <button type="button" @click="step = 1" class="relative z-10 flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-200 shadow-sm"
                         :class="step >= 1 ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">
                        <i class="fa-solid" :class="step > 1 ? 'fa-check' : 'fa-user'"></i>
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 1 ? 'text-emerald-700' : 'text-slate-500'">1. Data Utama</span>
                    <span class="text-[10px] text-slate-400 hidden sm:block">Kunci Kuota 1-Menit</span>
                </button>

                <!-- Step 2 Button -->
                <button type="button" @click="if(regCode) step = 2" class="relative z-10 flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-200 shadow-sm"
                         :class="step >= 2 ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">
                        <i class="fa-solid" :class="step > 2 ? 'fa-check' : 'fa-shapes'"></i>
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 2 ? 'text-emerald-700' : 'text-slate-500'">2. Klaster & Asrama</span>
                    <span class="text-[10px] text-slate-400 hidden sm:block">Kurikulum Merdeka</span>
                </button>

                <!-- Step 3 Button -->
                <button type="button" @click="if(regCode && selectedCluster) step = 3" class="relative z-10 flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-200 shadow-sm"
                         :class="step === 3 ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step === 3 ? 'text-emerald-700' : 'text-slate-500'">3. Unggah Berkas</span>
                    <span class="text-[10px] text-slate-400 hidden sm:block">Foto Berkas via Kamera</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- STEP 1: DATA UTAMA & KUNCI KUOTA CEPAT   -->
        <!-- ========================================== -->
        <div x-show="step === 1" x-cloak class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Langkah 1 dari 3</span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-2">Data Diri & Kunci Kuota Kilat (&lt; 1 Menit)</h2>
                <p class="text-xs text-slate-500 mt-1">Masukkan NIK dan nomor WhatsApp aktif. Sistem akan mengunci nomor antrean dan menerbitkan kode pendaftaran secara instan.</p>
            </div>

            <form action="{{ route('pendaftar.step1') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- NIK Siswa -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nomor Induk Kependudukan (NIK 16 Digit) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            <input type="text" name="nik" maxlength="16" required
                                   value="{{ old('nik', $applicant?->nik) }}"
                                   placeholder="Contoh: 3302010101080001"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition tracking-wider font-mono">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Sesuai Kartu Keluarga (KK). Digunakan sebagai ID utama login mandiri tanpa password.</p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Lengkap Calon Siswa <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" name="full_name" required
                                   value="{{ old('full_name', $applicant?->full_name) }}"
                                   placeholder="Nama lengkap sesuai Akta Kelahiran / Ijazah"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Tanggal Lahir <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            <input type="date" name="dob" required
                                   value="{{ old('dob', $applicant?->dob ? $applicant->dob->format('Y-m-d') : '') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Format Tanggal Lahir Calon Siswa</p>
                    </div>

                    <!-- No WhatsApp / HP -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            No. WhatsApp Aktif (Ortu / Siswa) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                            </span>
                            <input type="tel" name="phone_number" required
                                   value="{{ old('phone_number', $applicant?->phone_number) }}"
                                   placeholder="081234567890"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Notifikasi kelulusan & jadwal tes dikirim ke nomor ini</p>
                    </div>

                    <!-- Gelombang Pendaftaran -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Gelombang Pendaftaran</label>
                        <select name="wave_name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="Gelombang 1" {{ ($applicant?->wave_name ?? 'Gelombang 1') === 'Gelombang 1' ? 'selected' : '' }}>Gelombang 1 (Jalur Prestasi & Reguler Awal - Potongan Rp 50.000)</option>
                            <option value="Gelombang 2" {{ ($applicant?->wave_name ?? '') === 'Gelombang 2' ? 'selected' : '' }}>Gelombang 2 (Reguler)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-200 transition">
                        <span>Lanjut ke Klaster & Asrama</span>
                        <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- ================================================= -->
        <!-- STEP 2: KLASTER KURIKULUM MERDEKA & STATUS ASRAMA -->
        <!-- ================================================= -->
        <div x-show="step === 2" x-cloak class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Langkah 2 dari 3</span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-2">Pilihan Minat Klaster & Program Asrama</h2>
                <p class="text-xs text-slate-500 mt-1">Tentukan peminatan mata pelajaran Kurikulum Merdeka dan pilihan tempat tinggal calon peserta didik.</p>
            </div>

            <form action="{{ route('pendaftar.step2') }}" method="POST">
                @csrf
                <input type="hidden" name="cluster_id" :value="selectedCluster">
                <input type="hidden" name="is_boarding" :value="isBoarding">

                <!-- 1. Klaster Card Selection -->
                <div class="mb-8">
                    <label class="block text-xs font-bold text-slate-700 mb-3">
                        Pilih Klaster Peminatan Kurikulum Merdeka <span class="text-rose-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($clusters as $c)
                            <div @click="selectedCluster = {{ $c->id }}"
                                 class="cursor-pointer border-2 rounded-2xl p-4 transition-all duration-200 relative flex flex-col justify-between"
                                 :class="selectedCluster === {{ $c->id }} ? 'border-emerald-600 bg-emerald-50/50 shadow-md ring-2 ring-emerald-100' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                <div class="flex items-start justify-between">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg mb-3"
                                         :class="selectedCluster === {{ $c->id }} ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600'">
                                        @if(str_contains(strtolower($c->name), 'agama') || str_contains(strtolower($c->name), 'islam'))
                                            <i class="fa-solid fa-book-quran"></i>
                                        @elseif(str_contains(strtolower($c->name), 'stem') || str_contains(strtolower($c->name), 'ipa'))
                                            <i class="fa-solid fa-atom"></i>
                                        @elseif(str_contains(strtolower($c->name), 'sos'))
                                            <i class="fa-solid fa-landmark"></i>
                                        @else
                                            <i class="fa-solid fa-briefcase"></i>
                                        @endif
                                    </div>
                                    <div class="w-5 h-5 rounded-full border flex items-center justify-center"
                                         :class="selectedCluster === {{ $c->id }} ? 'border-emerald-600 bg-emerald-600 text-white' : 'border-slate-300'">
                                        <i class="fa-solid fa-check text-[10px]" x-show="selectedCluster === {{ $c->id }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $c->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $c->description ?? 'Fokus peminatan akademik dengan kurikulum mendalam.' }}</p>
                                    <div class="mt-3 flex items-center justify-between text-[11px] font-semibold text-emerald-700">
                                        <span>Sisa Kuota: {{ $c->quota ?? 30 }} Kursi</span>
                                        <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">Tersedia</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Fallback cards if database is freshly seeded -->
                            <div @click="selectedCluster = 1"
                                 class="cursor-pointer border-2 rounded-2xl p-4 transition-all relative"
                                 :class="selectedCluster === 1 ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200'">
                                <h3 class="font-bold text-slate-900 text-sm">Klaster Keagamaan & Tahfidz</h3>
                                <p class="text-xs text-slate-500 mt-1">Fokus Al-Qur'an, Hadist, Bahasa Arab & Kitab Kuning.</p>
                            </div>
                            <div @click="selectedCluster = 2"
                                 class="cursor-pointer border-2 rounded-2xl p-4 transition-all relative"
                                 :class="selectedCluster === 2 ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200'">
                                <h3 class="font-bold text-slate-900 text-sm">Klaster STEM & Sains Terapan</h3>
                                <p class="text-xs text-slate-500 mt-1">Fokus Matematika Lanjut, Fisika, Biologi, Coding & Robotika.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 2. Pilihan Status Asrama / Santri Mukim -->
                <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Program Tempat Tinggal Siswa</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button type="button" @click="isBoarding = 1"
                                class="p-4 rounded-xl border-2 text-left transition flex items-center space-x-3"
                                :class="isBoarding === 1 ? 'border-emerald-600 bg-white ring-2 ring-emerald-100 shadow-sm' : 'border-slate-200 bg-slate-100/60'">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold"
                                 :class="isBoarding === 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500'">
                                <i class="fa-solid fa-hotel"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-slate-900">Santri Mukim (Asrama)</h4>
                                <p class="text-[11px] text-slate-500">Tinggal di Pesantren/Boarding School</p>
                            </div>
                        </button>

                        <button type="button" @click="isBoarding = 0"
                                class="p-4 rounded-xl border-2 text-left transition flex items-center space-x-3"
                                :class="isBoarding === 0 ? 'border-emerald-600 bg-white ring-2 ring-emerald-100 shadow-sm' : 'border-slate-200 bg-slate-100/60'">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold"
                                 :class="isBoarding === 0 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500'">
                                <i class="fa-solid fa-house-user"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-slate-900">Non-Mukim (Pulang-Pergi)</h4>
                                <p class="text-[11px] text-slate-500">Tinggal bersama orang tua / wali</p>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 1" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                    </button>
                    <button type="submit" :disabled="!selectedCluster"
                            class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-200 transition disabled:opacity-50">
                        <span>Lanjut ke Berkas Persyaratan</span>
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================== -->
        <!-- STEP 3: UNGGAH FOTO BERKAS (KAMERA HP LANGSUNG) -->
        <!-- ============================================== -->
        <div x-show="step === 3" x-cloak class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Langkah 3 dari 3</span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-2">Unggah Berkas via Kamera HP / File</h2>
                <p class="text-xs text-slate-500 mt-1">Gunakan tombol kamera di bawah untuk memotret dokumen fisik (KK, Akta, SKL) secara langsung dan jelas tanpa scan scanner.</p>
            </div>

            <!-- Upload Box Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <!-- 1. Kartu Keluarga (KK) -->
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-emerald-500 transition relative bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg mb-3">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900">Kartu Keluarga (KK) <span class="text-rose-500">*</span></h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Format JPG/PNG/PDF (Maks 2MB)</p>

                        <div class="mt-3">
                            <template x-if="docs.kk">
                                <div class="relative rounded-lg overflow-hidden border border-emerald-300">
                                    <img :src="docs.kk" class="w-full h-24 object-cover">
                                    <span class="absolute top-1 right-1 bg-emerald-600 text-white text-[9px] px-1.5 py-0.5 rounded font-bold">Terunggah</span>
                                </div>
                            </template>
                            <template x-if="!docs.kk">
                                <div class="h-24 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs">
                                    <span>Belum ada foto</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <form action="{{ route('pendaftar.upload_document') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <input type="hidden" name="doc_type" value="kk">
                        <label class="cursor-pointer w-full inline-flex items-center justify-center px-3 py-2 rounded-xl bg-white border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-xs font-bold transition shadow-sm">
                            <i class="fa-solid fa-camera mr-1.5 text-sm"></i>
                            <span>Foto / Pilih KK</span>
                            <input type="file" name="file" accept="image/*" capture="environment" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <!-- 2. Akta Kelahiran -->
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-emerald-500 transition relative bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-lg mb-3">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900">Akta Kelahiran <span class="text-rose-500">*</span></h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Format JPG/PNG/PDF (Maks 2MB)</p>

                        <div class="mt-3">
                            <template x-if="docs.akta">
                                <div class="relative rounded-lg overflow-hidden border border-emerald-300">
                                    <img :src="docs.akta" class="w-full h-24 object-cover">
                                    <span class="absolute top-1 right-1 bg-emerald-600 text-white text-[9px] px-1.5 py-0.5 rounded font-bold">Terunggah</span>
                                </div>
                            </template>
                            <template x-if="!docs.akta">
                                <div class="h-24 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs">
                                    <span>Belum ada foto</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <form action="{{ route('pendaftar.upload_document') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <input type="hidden" name="doc_type" value="akta">
                        <label class="cursor-pointer w-full inline-flex items-center justify-center px-3 py-2 rounded-xl bg-white border border-blue-600 text-blue-700 hover:bg-blue-50 text-xs font-bold transition shadow-sm">
                            <i class="fa-solid fa-camera mr-1.5 text-sm"></i>
                            <span>Foto / Pilih Akta</span>
                            <input type="file" name="file" accept="image/*" capture="environment" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <!-- 3. Surat Keterangan Lulus (SKL) / Ijazah -->
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-emerald-500 transition relative bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 mx-auto rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-lg mb-3">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900">SKL / Surat Keterangan <span class="text-rose-500">*</span></h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Atau Surat Keterangan Aktif Sekolah</p>

                        <div class="mt-3">
                            <template x-if="docs.skl">
                                <div class="relative rounded-lg overflow-hidden border border-emerald-300">
                                    <img :src="docs.skl" class="w-full h-24 object-cover">
                                    <span class="absolute top-1 right-1 bg-emerald-600 text-white text-[9px] px-1.5 py-0.5 rounded font-bold">Terunggah</span>
                                </div>
                            </template>
                            <template x-if="!docs.skl">
                                <div class="h-24 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs">
                                    <span>Belum ada foto</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <form action="{{ route('pendaftar.upload_document') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <input type="hidden" name="doc_type" value="skl">
                        <label class="cursor-pointer w-full inline-flex items-center justify-center px-3 py-2 rounded-xl bg-white border border-amber-600 text-amber-700 hover:bg-amber-50 text-xs font-bold transition shadow-sm">
                            <i class="fa-solid fa-camera mr-1.5 text-sm"></i>
                            <span>Foto / Pilih SKL</span>
                            <input type="file" name="file" accept="image/*" capture="environment" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            </div>

            <!-- Diskon Saudara Kandung (Sibling Discount) -->
            <div class="mb-8 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-hand-holding-heart text-emerald-600"></i>
                        <h4 class="font-bold text-xs text-slate-800">Apakah Memiliki Saudara Kandung Aktif di Madrasah/Sekolah Ini?</h4>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full">Potongan 20%</span>
                </div>
                <p class="text-[11px] text-slate-500 mb-3">Dapatkan beasiswa keringanan biaya pendaftaran 20% jika memiliki kakak/adik yang saat ini masih berstatus siswa aktif.</p>
                
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" x-model="siblingNisn" maxlength="10" placeholder="Masukkan 10 Digit NISN Saudara Kandung"
                           class="flex-1 px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-mono">
                    <button type="button" @click="checkSiblingDiscount()" :disabled="siblingChecking"
                            class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition disabled:opacity-50">
                        <span x-show="!siblingChecking">Verifikasi NISN</span>
                        <span x-show="siblingChecking"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Memeriksa...</span>
                    </button>
                </div>
                <template x-if="siblingMessage">
                    <p class="text-xs font-semibold mt-2" :class="siblingValid ? 'text-emerald-700' : 'text-rose-600'" x-text="siblingMessage"></p>
                </template>
            </div>

            <!-- Finalisasi & Kunci Data Form -->
            <form action="{{ route('pendaftar.finalize') }}" method="POST" class="pt-4 border-t border-slate-100">
                @csrf
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" @click="step = 2" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Klaster
                    </button>
                    
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-200 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-lock"></i>
                        <span>Kunci Formulir & Lanjut Pembayaran</span>
                    </button>
                </div>
            </form>
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="mt-12 py-6 text-center text-xs text-slate-400 border-t border-slate-200 bg-white">
        <p>&copy; {{ date('Y') }} Sistem Informasi PPDB Online Terpadu. All rights reserved.</p>
    </footer>

</body>
</html>

