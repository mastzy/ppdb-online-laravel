## Tasks Overview

### Done
- Project scaffolding with Laravel 11 & Docker Compose (app, webserver, db, redis, phpmyadmin).
- Registration flow, zero-friction applicant authentication, verifikator verification, and offline cash register.
- **Generator PDF & QR Code (DomPDF & Simple-QRCode)**:
  * `resources/views/pdf/kuitansi.blade.php`: Kuitansi resmi LUNAS berstempel digital & QR code verifikasi.
  * `resources/views/pdf/stopmap.blade.php`: Cetak Ringkasan Stopmap 1-Halaman (One-Page Resume PDF) memuat identitas, rincian klaster, checklist berkas fisik, dan paraf verifikator.
  * `resources/views/pdf/sk_lulus.blade.php`: Cetak Surat Keputusan Kelulusan resmi ber-QR Code & stempel digital.
- **Halaman Validasi QR Code Publik**:
  * `resources/views/public/verify_document.blade.php`: Halaman publik terenkripsi hasil scan QR Code yang menampilkan badge "DOKUMEN TERVERIFIKASI RESMI", timestamp penerbitan, dan stempel yayasan.
  * `resources/views/public/verify_receipt.blade.php`: Validasi keabsahan kuitansi pembayaran resmi.
- **Dashboard Verifikator & In-App Document Preview Modal**:
  * `resources/views/admin/verification/index.blade.php`, `show.blade.php`, dan `verifikator/dashboard.blade.php` dilengkapi inline stream preview dokumen (foto/PDF) tanpa download + quick approve & revisi form.
- **Modul Asesmen Diagnostik (`AssessmentController.php` & `admin/assessment/index.blade.php`)**:
  * Penilaian BTQ, jumlah juz tahfidz Al-Qur'an, literasi/numerasi, catatan wawancara, dan kalkulasi rekomendasi otomatis Alpine.js.
- **Fitur Pemicu Notifikasi WhatsApp Direct-Link**:
  * Tombol kirim notifikasi WhatsApp otomatis di Dashboard Verifikator dan Kasir Loket dengan format pesan resmi.
- **Manajemen Gelombang & Kuota Dinamis (`admin/settings/index.blade.php`)**:
  * Form admin konfigurasi kuota klaster dan pemantauan status gelombang.
- **Executive Dashboard Analytics (`admin/dashboard.blade.php`)**:
  * Integrasi Chart.js CDN: Grafik Donat Klaster Kurikulum Merdeka dan Bar Chart Status Verifikasi.
- **Halaman Error Kustom (`errors/404.blade.php` & `errors/500.blade.php`)**:
  * Halaman error terpadu tema Emerald/Teal dan tombol bantuan CS WhatsApp.
- **Ekspor Data EMIS Kemenag & Dapodik Kemendikbud**:
  * `AdminExportController.php`: Ekspor CSV ber-UTF-8 BOM siap impor ke sistem EMIS 4.0 dan Dapodik Kemendikbudristek.
- **Pengujian**: 10/10 test files passed (112 assertions, 0 failed).

### In Progress
- Penyiapan automasi CI/CD pada repositori Git.

### Backlog
- Rilis production dan hosting setup.
