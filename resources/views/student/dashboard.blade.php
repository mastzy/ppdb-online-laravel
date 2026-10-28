<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pendaftar / Dashboard Siswa - PPDB Online</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- html2canvas for Download Kartu to Gallery as Image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen font-sans selection:bg-teal-500 selection:text-white"
      x-data="studentDashboard({
          regId: {{ $registration->id ?? 0 }},
          regCode: '{{ $registration->reg_code ?? '' }}',
          fullName: '{{ addslashes($registration->full_name ?? ($registration->user->name ?? 'Calon Siswa')) }}',
          status: '{{ $registration->status ?? 'draft' }}',
          catatanKoreksi: '{{ addslashes($registration->catatan_koreksi ?? '') }}'
      })">

    <!-- Toast Notification Container -->
    <div x-data="{ toasts: [] }" 
         @notify.window="toasts.push({ id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'success' }); setTimeout(() => toasts.shift(), 3500)"
         class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div x-transition class="pointer-events-auto px-4 py-3 rounded-2xl shadow-2xl border text-sm font-semibold flex items-center gap-3 backdrop-blur-md"
                 :class="{
                     'bg-emerald-950/90 border-emerald-500/50 text-emerald-200': t.type === 'success',
                     'bg-rose-950/90 border-rose-500/50 text-rose-200': t.type === 'error',
                     'bg-amber-950/90 border-amber-500/50 text-amber-200': t.type === 'warning'
                 }">
                <span x-show="t.type === 'success'">✅</span>
                <span x-show="t.type === 'error'">⚠️</span>
                <span x-show="t.type === 'warning'">⚡</span>
                <span x-text="t.message"></span>
            </div>
        </template>
    </div>

    <!-- Top Navigation -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
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
                    <span class="block text-[10px] font-semibold text-teal-400">Portal Siswa & Live Tracking</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <div class="hidden sm:block text-right">
                    <span class="block text-xs font-bold text-white">{{ $registration->full_name ?? ($registration->user->name ?? 'Calon Siswa') }}</span>
                    <span class="block text-[11px] font-mono text-teal-400">{{ $registration->reg_code ?? 'REG-ACTIVE' }}</span>
                </div>
                <form action="{{ route('pendaftar.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition-all border border-slate-700">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 sm:py-12 space-y-8">

        <!-- 2. WARNING CALLOUT / KOTAK CATATAN REVISI (Jika status = revision_needed) -->
        @if(($registration->status ?? '') === 'revision_needed' || !empty($registration->catatan_koreksi))
            <div class="p-6 rounded-3xl bg-amber-500/15 border-2 border-amber-500/50 text-amber-200 shadow-2xl relative overflow-hidden animate-pulse">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-md bg-amber-500 text-slate-900 text-xs font-extrabold uppercase">Perlu Tindakan</span>
                            <h2 class="text-base sm:text-lg font-bold text-white">Catatan Koreksi dari Panitia Verifikator</h2>
                        </div>
                        <p class="text-sm text-amber-100 font-medium leading-relaxed">
                            "{{ $registration->catatan_koreksi ?: 'Foto KK buram atau terpotong, silakan unggah ulang berkas yang jelas sesuai ketentuan.' }}"
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('pendaftar.formulir') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-extrabold shadow-md transition-all">
                                <span>Perbaiki & Unggah Ulang Berkas Sekarang</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- 1. LIVE TRACKING STATUS (GAYA PELACAK PAKET EKSPEDISI) -->
        <section class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-700/60 pb-5">
                <div>
                    <span class="text-xs font-bold text-teal-400 uppercase tracking-wider block">Live Delivery-Style Tracking</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-white mt-1">Status Progres Pendaftaran Anda</h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400">Status Terkini:</span>
                    <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold uppercase tracking-wider font-mono border"
                          :class="getStatusBadgeClass(status)">
                        <span x-text="getStatusLabel(status)"></span>
                    </span>
                </div>
            </div>

            <!-- Stepper Container: [1. Pendaftaran] -> [2. Pembayaran] -> [3. Asesmen & Berkas] -> [4. Pengumuman Lulus] -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 pt-4">
                
                <!-- Stage 1: Pendaftaran -->
                <div class="p-4 rounded-2xl border transition-all flex sm:flex-col items-center sm:items-start gap-4 sm:gap-3"
                     :class="getStageClass(1, status)">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0"
                         :class="getStageIconClass(1, status)">
                        <template x-if="isStageDone(1, status)">
                            <span>✓</span>
                        </template>
                        <template x-if="!isStageDone(1, status)">
                            <span>1</span>
                        </template>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider block"
                              :class="isStageCurrent(1, status) ? 'text-amber-400 animate-pulse' : 'text-slate-400'">
                            Tahap 1
                        </span>
                        <h3 class="text-sm font-bold text-white">1. Pendaftaran</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Input data diri, NIK, dan pemilihan klaster.</p>
                    </div>
                </div>

                <!-- Stage 2: Pembayaran -->
                <div class="p-4 rounded-2xl border transition-all flex sm:flex-col items-center sm:items-start gap-4 sm:gap-3"
                     :class="getStageClass(2, status)">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0"
                         :class="getStageIconClass(2, status)">
                        <template x-if="isStageDone(2, status)">
                            <span>✓</span>
                        </template>
                        <template x-if="!isStageDone(2, status)">
                            <span>2</span>
                        </template>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider block"
                              :class="isStageCurrent(2, status) ? 'text-amber-400 animate-pulse' : 'text-slate-400'">
                            Tahap 2
                        </span>
                        <h3 class="text-sm font-bold text-white">2. Pembayaran</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Transfer rekening atau bayar tunai di loket.</p>
                    </div>
                </div>

                <!-- Stage 3: Asesmen & Berkas -->
                <div class="p-4 rounded-2xl border transition-all flex sm:flex-col items-center sm:items-start gap-4 sm:gap-3"
                     :class="getStageClass(3, status)">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0"
                         :class="getStageIconClass(3, status)">
                        <template x-if="isStageDone(3, status)">
                            <span>✓</span>
                        </template>
                        <template x-if="!isStageDone(3, status)">
                            <span>3</span>
                        </template>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider block"
                              :class="isStageCurrent(3, status) ? 'text-amber-400 animate-pulse' : 'text-slate-400'">
                            Tahap 3
                        </span>
                        <h3 class="text-sm font-bold text-white">3. Asesmen & Berkas</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Verifikasi berkas & uji diagnostik.</p>
                    </div>
                </div>

                <!-- Stage 4: Pengumuman Lulus -->
                <div class="p-4 rounded-2xl border transition-all flex sm:flex-col items-center sm:items-start gap-4 sm:gap-3"
                     :class="getStageClass(4, status)">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0"
                         :class="getStageIconClass(4, status)">
                        <template x-if="isStageDone(4, status)">
                            <span>🎉</span>
                        </template>
                        <template x-if="!isStageDone(4, status)">
                            <span>4</span>
                        </template>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider block"
                              :class="isStageCurrent(4, status) ? 'text-emerald-400' : 'text-slate-400'">
                            Tahap Akhir
                        </span>
                        <h3 class="text-sm font-bold text-white">4. Pengumuman Lulus</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Penerbitan surat kelulusan & Welcome Hub.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 3. ACTION CENTER & DOWNLOAD HUB -->
        <section class="bg-slate-850 border border-slate-700/80 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
            <div class="border-b border-slate-700/60 pb-4">
                <span class="text-xs font-bold text-teal-400 uppercase tracking-wider block">One-Click Download Hub</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-white mt-1">Dokumen & Berkas Resmi</h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">Unduh kartu pendaftaran resmi, kuitansi sah, dan simpan langsung ke galeri foto HP.</p>
            </div>

            <!-- Download Action Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                
                <!-- 1. Unduh Kartu Pendaftaran (PDF) -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700/80 flex flex-col justify-between space-y-4 hover:border-teal-500 transition-colors">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-sm text-white">Kartu Pendaftaran (PDF)</h3>
                        <p class="text-xs text-slate-400 mt-1">Berisi barcode & QR Code validasi untuk kartu ujian.</p>
                    </div>
                    <a href="{{ route('registration.card.pdf') }}" 
                       target="_blank"
                       class="btn w-full py-2.5 px-4 bg-teal-600 hover:bg-teal-500 text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2">
                        <span>Unduh Kartu (PDF)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>

                <!-- 2. Unduh Kuitansi (PDF) -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700/80 flex flex-col justify-between space-y-4 hover:border-emerald-500 transition-colors">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-sm text-white">Kuitansi Pembayaran (PDF)</h3>
                        <p class="text-xs text-slate-400 mt-1">Bukti sah pembayaran bertanda tangan stempel bendahara.</p>
                    </div>
                    @if(in_array(($registration->status ?? ''), ['paid', 'verified', 'passed']))
                        <a href="{{ route('kuitansi.pdf', $registration->id) }}" 
                           target="_blank"
                           class="btn w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2">
                            <span>Unduh Kuitansi (PDF)</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @else
                        <a href="{{ route('pendaftar.pembayaran') }}" class="btn w-full py-2.5 px-4 bg-slate-800 text-slate-400 font-bold rounded-xl text-xs text-center border border-slate-700 hover:text-white transition-all">
                            Selesaikan Pembayaran
                        </a>
                    @endif
                </div>

                <!-- 3. Simpan Kartu ke Galeri HP (Gambar) -->
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-700/80 flex flex-col justify-between space-y-4 hover:border-indigo-500 transition-colors">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-sm text-white">Simpan Kartu ke Galeri HP</h3>
                        <p class="text-xs text-slate-400 mt-1">Konversi langsung kartu peserta menjadi gambar JPG/PNG.</p>
                    </div>
                    <button type="button" 
                            @click="saveCardToGallery" 
                            :disabled="savingImage"
                            class="btn w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-60 text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span x-show="!savingImage">📸 Simpan ke Galeri (PNG)</span>
                        <span x-show="savingImage" style="display:none;">Sedang Menyimpan...</span>
                    </button>
                </div>

            </div>

            <!-- Welcome Hub Banner for Passed Student -->
            @if(($registration->status ?? '') === 'passed')
                <div class="mt-4 p-5 rounded-2xl bg-gradient-to-r from-emerald-950 to-teal-950 border border-emerald-500/40 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider block">Selamat! Anda Dinyatakan Lulus</span>
                        <h3 class="text-lg font-bold text-white">Masuk ke Welcome Hub Santri Baru</h3>
                        <p class="text-xs text-slate-300 mt-0.5">Gabung grup WhatsApp angkatan dan panduan seragam madrasah.</p>
                    </div>
                    <a href="{{ route('pendaftar.welcome_hub') }}" class="btn px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-xl text-xs shadow-lg shadow-emerald-500/20 shrink-0">
                        Buka Welcome Hub →
                    </a>
                </div>
            @endif
        </section>

        <!-- Printable / Capturable Card Template (Rendered Off-Screen or Viewable) -->
        <div id="printable-student-card" class="bg-white text-slate-900 p-8 rounded-3xl border border-slate-300 shadow-xl max-w-xl mx-auto space-y-6">
            <div class="flex items-center justify-between border-b-2 border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                        MA
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900 leading-tight">MA AL-HIKMAH TERPADU</h3>
                        <p class="text-xs text-slate-600">Kartu Tanda Peserta PPDB 2026/2027</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-mono text-sm font-extrabold text-teal-700 block">{{ $registration->reg_code ?? 'PPDB-2026-001' }}</span>
                    <span class="text-[10px] text-slate-500">Resmi & Terverifikasi</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-500 block">Nama Lengkap</span>
                    <strong class="text-sm text-slate-900">{{ $registration->full_name ?? ($registration->user->name ?? 'Calon Siswa') }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block">NIK</span>
                    <strong class="font-mono text-slate-800">{{ $registration->nik ?? ($registration->user->nik ?? '-') }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block">Klaster Pilihan</span>
                    <strong class="text-slate-800">{{ $registration->cluster->name ?? 'Kurikulum Merdeka' }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block">Status Santri</span>
                    <strong class="text-slate-800">{{ ($registration->is_boarding ?? false) ? 'Mukim (Asrama)' : 'Non-Mukim' }}</strong>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <div class="text-[11px] text-slate-500 leading-tight">
                    <p>• Bawa kartu ini saat tes diagnostik</p>
                    <p>• QR Code dapat dipindai panitia</p>
                </div>
                <div class="w-16 h-16 bg-slate-100 border border-slate-300 rounded-lg flex items-center justify-center font-mono text-[9px] text-center p-1 text-slate-600">
                    [QR VALID]
                </div>
            </div>
        </div>

    </main>

    <script>
        function studentDashboard(config) {
            return {
                status: config.status || 'draft',
                savingImage: false,

                getStatusBadgeClass(st) {
                    if (st === 'passed') return 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40';
                    if (st === 'verified' || st === 'paid') return 'bg-teal-500/20 text-teal-300 border-teal-500/40';
                    if (st === 'revision_needed' || st === 'pending_payment') return 'bg-amber-500/20 text-amber-300 border-amber-500/40';
                    if (st === 'rejected') return 'bg-rose-500/20 text-rose-300 border-rose-500/40';
                    return 'bg-slate-700 text-slate-300 border-slate-600';
                },

                getStatusLabel(st) {
                    const map = {
                        draft: 'Draft Formulir',
                        pending_payment: 'Menunggu Pembayaran',
                        paid: 'Sudah Dibayar (Proses)',
                        verified: 'Berkas Lengkap & Terverifikasi',
                        revision_needed: 'Perlu Revisi Berkas',
                        passed: 'Dinyatakan Lulus',
                        rejected: 'Tidak Lolos'
                    };
                    return map[st] || st.toUpperCase();
                },

                isStageDone(stage, st) {
                    if (stage === 1) return st !== 'draft';
                    if (stage === 2) return ['paid', 'verified', 'passed'].includes(st);
                    if (stage === 3) return ['verified', 'passed'].includes(st);
                    if (stage === 4) return st === 'passed';
                    return false;
                },

                isStageCurrent(stage, st) {
                    if (stage === 1 && st === 'draft') return true;
                    if (stage === 2 && st === 'pending_payment') return true;
                    if (stage === 3 && ['paid', 'revision_needed'].includes(st)) return true;
                    if (stage === 4 && st === 'verified') return true;
                    return false;
                },

                getStageClass(stage, st) {
                    if (this.isStageDone(stage, st)) {
                        return 'bg-emerald-950/40 border-emerald-500/40 shadow-sm';
                    }
                    if (this.isStageCurrent(stage, st)) {
                        return 'bg-amber-950/40 border-amber-500/60 shadow-md ring-2 ring-amber-500/20';
                    }
                    return 'bg-slate-900/60 border-slate-700/80 opacity-70';
                },

                getStageIconClass(stage, st) {
                    if (this.isStageDone(stage, st)) {
                        return 'bg-emerald-500 text-white';
                    }
                    if (this.isStageCurrent(stage, st)) {
                        return 'bg-amber-500 text-slate-950 ring-4 ring-amber-500/20';
                    }
                    return 'bg-slate-800 text-slate-500';
                },

                async saveCardToGallery() {
                    this.savingImage = true;
                    try {
                        const cardElement = document.getElementById('printable-student-card');
                        const canvas = await html2canvas(cardElement, {
                            scale: 2,
                            backgroundColor: '#ffffff'
                        });
                        const imgUrl = canvas.toDataURL('image/png');
                        const a = document.createElement('a');
                        a.href = imgUrl;
                        a.download = 'Kartu-PPDB-' + config.regCode + '.png';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.showToast('Kartu berhasil disimpan ke galeri foto!', 'success');
                    } catch (e) {
                        window.showToast('Gagal memproses gambar.', 'error');
                    } finally {
                        this.savingImage = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
