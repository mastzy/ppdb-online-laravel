## Tasks Overview

### Done
- Project scaffolding with Laravel 11 & Docker Compose (app, webserver, db, redis, phpmyadmin).
- Registration flow, zero-friction applicant authentication, verifikator verification, and offline cash register.
- **Generator PDF & QR Code (DomPDF & Simple-QRCode)**:
  * `resources/views/pdf/kuitansi.blade.php` & `kuitansi_pembayaran.blade.php`: Kuitansi resmi LUNAS berstempel digital & QR code verifikasi keabsahan.
  * `resources/views/pdf/stopmap.blade.php` & `ringkasan_stopmap.blade.php`: Cetak Ringkasan Stopmap 1-Halaman (One-Page Resume PDF) memuat identitas, rincian klaster, checklist berkas fisik, dan paraf verifikator.
  * `resources/views/pdf/sk_lulus.blade.php`: Cetak Surat Keputusan Kelulusan resmi ber-QR Code & stempel digital.
- **Halaman Validasi QR Code Publik**:
  * `resources/views/public/verify_document.blade.php`: Halaman publik terenkripsi hasil scan QR Code yang menampilkan badge "DOKUMEN TERVERIFIKASI RESMI", timestamp penerbitan, dan stempel yayasan.
  * `resources/views/public/verify_receipt.blade.php`: Validasi keabsahan kuitansi pembayaran resmi.
- **Dashboard Verifikator & In-App Document Preview Modal**:
  * `resources/views/admin/verification/index.blade.php`, `show.blade.php`, dan `verifikator/dashboard.blade.php` dilengkapi inline stream preview dokumen (foto/PDF) tanpa memaksa unduh file + quick approve & revisi form.
- **Mode Kasir Offline Bendahara**:
  * `resources/views/admin/kasir/index.blade.php` & `bendahara/kasir.blade.php`: Interface loket pencarian instan pendaftar dan tombol pembayaran tunai langsung berstatus LUNAS.
- **Ekspor Data EMIS Kemenag & Dapodik Kemendikbud**:
  * `AdminExportController.php`: Ekspor CSV ber-UTF-8 BOM siap impor ke sistem EMIS 4.0 dan Dapodik Kemendikbudristek.
- **UI & Frontend**: 100% menggunakan Tailwind CSS CDN, Google Font Plus Jakarta Sans, FontAwesome 6, dan Alpine.js 3 pada seluruh modul pendaftar, admin, dan publik.
- **Pengujian**: 10/10 test files passed (112 assertions, 0 failed).

### In Progress
- CI/CD workflow pada GitHub Actions.

### Backlog
- Rilis production dan hosting setup.
