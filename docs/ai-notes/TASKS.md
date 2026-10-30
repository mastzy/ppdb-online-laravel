## Tasks Overview

### Done
- Project scaffolding with Laravel 11 & Docker Compose (app, webserver, db, redis, phpmyadmin).
- Registration flow, zero-friction applicant authentication, verifikator verification, and offline cash register.
- **Generator PDF & QR Code (DomPDF & Simple-QRCode)**:
  * `resources/views/pdf/kuitansi.blade.php`: Kuitansi resmi LUNAS berstempel digital & QR code verifikasi.
  * `resources/views/pdf/stopmap.blade.php`: Cetak Ringkasan Stopmap 1-Halaman (One-Page Resume PDF) memuat identitas, rincian klaster, checklist berkas fisik, dan paraf verifikator.
  * `resources/views/pdf/sk_lulus.blade.php`: Cetak Surat Keputusan Kelulusan resmi ber-QR Code & stempel digital.
- **Portal Pendaftar & Siswa (Frontend UX Complete - Tailwind CDN, Alpine.js, Plus Jakarta Sans)**:
  * `resources/views/pendaftar/formulir.blade.php`: Wizard 3-Langkah (Data Utama -> Card Klaster -> Upload Kamera HP Langsung `capture="environment"`).
  * `resources/views/pendaftar/login.blade.php`: Floating Card Login NIK / Kode Registrasi + Tanggal Lahir (PIN) tanpa password ribet.
  * `resources/views/pendaftar/pembayaran.blade.php`: Instruksi transfer bank resmi + 3 digit kode unik + tombol salin toast notifikasi Alpine.js + opsi loket tunai.
  * `resources/views/pendaftar/cek_status_result.blade.php`: Kartu hasil pencarian NIK publik tanpa login + tracking stepper + alert box merah jika `revision_needed`.
  * `resources/views/pendaftar/welcome_hub.blade.php`: Selebrasi kelulusan siswa, info MATSAMA, seragam, dan action hub unduh SK Lulus PDF, Kuitansi Lunas PDF, Stopmap PDF.
  * `resources/views/student/dashboard.blade.php`: Portal dashboard siswa modern memuat ringkasan kelengkapan berkas, tracking status, dan link cepat unduh dokumen.
- **Dashboard Panitia, Verifikator, Kasir & Admin**:
  * `resources/views/admin/dashboard.blade.php`: Executive live analytics dengan Chart.js (Donut Klaster & Bar Chart Status Verifikasi).
  * `resources/views/admin/verification/index.blade.php` & `verifikator/dashboard.blade.php`: In-App Document Preview Modal Alpine.js (buka gambar/PDF langsung tanpa download) + Quick Approve/Revisi form.
  * `resources/views/admin/kasir/index.blade.php`: Mode kasir offline bendahara pencarian instan + proses bayar tunai sekali klik (status PAID & kuitansi resmi).
  * `resources/views/admin/assessment/index.blade.php`: Penguji asesmen input skor BTQ, Tahfidz, Literasi, dan kalkulasi rekomendasi otomatis.
  * `resources/views/admin/settings/index.blade.php`: Pengaturan kuota dinamis per klaster Kurikulum Merdeka.
- **Public Verification & Halaman Error**:
  * `resources/views/public/verify_document.blade.php`: Validasi scan QR Code kuitansi & SK lulus ("DOKUMEN TERVERIFIKASI RESMI").
  * `resources/views/errors/404.blade.php` & `errors/500.blade.php`: Halaman error bertema Emerald/Teal dengan tombol bantuan WhatsApp CS.
- **Ekspor Data EMIS & Dapodik**:
  * `AdminExportController.php`: Format CSV ber-UTF-8 BOM siap impor ke EMIS Kemenag & Dapodik Kemendikbud.
- **Pengujian**: 10/10 test files passed (112 assertions, 0 failed).

### In Progress
- CI/CD workflow pada GitHub Actions.

### Backlog
- Rilis production dan hosting setup.
