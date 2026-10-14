# DOKUMEN SPESIFIKASI DAN RENCANA PENGEMBANGAN SISTEM INFORMASI PPDB ONLINE

Dokumentasi Rekayasa Perangkat Lunak Terpadu: PRD, SRS, dan Rencana Progres Pengembangan

# BAGIAN I: PRODUCT REQUIREMENT DOCUMENT (PRD)

## 1. Ringkasan Eksekutif & Deskripsi Produk

Sistem Informasi Penerimaan Peserta Didik Baru (PPDB) Online berbasis web dirancang untuk mengotomatisasi dan mempermudah alur pendaftaran siswa baru secara mandiri, transparan, dan efisien. Sistem ini menangani seluruh tahapan operasional penerimaan siswa, mulai dari pendaftaran akun awal, pengisian data terstruktur, unggah berkas persyaratan, verifikasi administratif oleh panitia, pemeringkatan otomatis berbasis kriteria jalur seleksi, hingga penerbitan kartu bukti pendaftaran dan lembar hasil seleksi resmi.

Tujuan utama pembangunan sistem ini adalah mengurangi beban administrasi fisik, meminimalisir kesalahan input data manual, menjamin transparansi proses seleksi, serta memberikan kemudahan aksesibilitas bagi calon siswa dan orang tua dari berbagai latar belakang perangkat.

## 2. User Roles & Hak Akses

Aplikasi ini mendefinisikan tiga peran pengguna utama dengan batasan hak akses yang tersentralisasi:

Calon Siswa / Orang Tua:

Membuat dan mengaktifkan akun pendaftaran menggunakan NIK dan NISN.

Mengisi formulir pendaftaran multistep (data pribadi, data orang tua/wali, riwayat akademik, pilihan jalur).

Mengunggah dokumen persyaratan (ijazah, KK, akta, sertifikat).

Memantau status verifikasi dan membaca catatan koreksi dari panitia.

Mencetak Kartu Bukti Pendaftaran dan Kartu Hasil Seleksi resmi ber-QR Code.

Panitia PPDB / Verifikator:

Mengakses dashboard verifikasi khusus pendaftar.

Memeriksa keabsahan dan kesesuaian berkas fisik digital dengan data terinput.

Mengubah status verifikasi pendaftar (Approved, Rejected, atau Revision Needed).

Memberikan catatan koreksi mendetail jika dokumen ditolak atau memerlukan perbaikan.

Administrator System:

Mengatur konfigurasi global sistem (tahun ajaran, jadwal gelombang pendaftaran).

Mengelola parameter jalur pendaftaran (Zonasi, Prestasi, Afirmasi, Perpindahan Tugas Orang Tua) dan batas kuota masing-masing.

Mengelola akun pengguna (kredensial panitia, reset akses pendaftar).

Memicu (trigger) proses pemeringkatan otomatis dan mempublikasikan hasil seleksi akhir.

## 3. Matriks Kebutuhan Fungsional Utama

| Modul Utama | Fitur Fungsional | Deskripsi Operasional |
| --- | --- | --- |
| Autentikasi | Registrasi & Login | Registrasi validasi NIK/NISN unik, autentikasi terenkripsi, reset password. |
| Pendaftaran | Multistep Form | Formulir data diri, orang tua, akademik, dan verifikasi jalur bertahap. |
| Pengelolaan Berkas | Unggah Dokumen | Dukungan PDF/JPG/PNG max 2MB, hashing nama file, penyimpanan tersentral. |
| Verifikasi | Dashboard Panitia | Visualisasi data pendaftar, in-app document preview, sistem penilaian berkas. |
| Pengumuman | Pemeringkatan Otomatis | Kalkulasi skor/jarak otomatis sesuai jalur seleksi dan publikasi transparan. |
| Output Dokumentasi | Cetak PDF & QR Code | Penjanaan otomatis Kartu Pendaftaran & Bukti Lulus ber-QR Code tervalidasi. |

# BAGIAN II: SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

Standard Reference: IEEE 830 / ISO 29148

## 1. Pendahuluan

### 1.1 Tujuan

Dokumen Software Requirements Specification (SRS) ini bertujuan untuk menyediakan spesifikasi teknis yang lengkap, formal, dan terstruktur mengenai Sistem Informasi PPDB Online. Dokumen ini menjadi acuan utama bagi tim pengembang (front-end dan back-end), perancang UI/UX, tim Quality Assurance (QA), serta pemangku kepentingan (stakeholders) selama siklus hidup pengembangan perangkat lunak.

### 1.2 Lingkup Produk

Sistem yang dikembangkan adalah aplikasi web standalone yang mencakup seluruh alur kerja operasional PPDB. Sistem tidak mencakup modul pembayaran sekolah pasca-diterima atau manajemen kurikulum internal sekolah.

### 1.3 Definisi & Akronim

SRS: Software Requirements Specification

PPDB: Penerimaan Peserta Didik Baru

NISN: Nomor Induk Siswa Nasional

NIK: Nomor Induk Kependudukan

HCI: Human-Computer Interaction

WCAG 2.1 AA: Web Content Accessibility Guidelines level AA

CSRF: Cross-Site Request Forgery

XSS: Cross-Site Scripting

## 2. Deskripsi Umum

### 2.1 Arsitektur Sistem

Sistem menggunakan arsitektur modern Client-Server berbasis Single Page Application (SPA) atau Progressive Web App (PWA) di sisi klien yang berkomunikasi melalui RESTful API berformat JSON dengan back-end server. Seluruh penyimpanan media dokumen dikelola oleh Object Storage terpisah dengan enkripsi nama file.[ Front-End Web Client ] <--- (HTTPS / REST API) ---> [ Back-End Engine (PHP/Node) ]

|         |

[ MySQL DB ]   [ File Storage ]

### 2.2 Karakteristik Pengguna

Calon Siswa / Orang Tua: Kemampuan teknis bervariasi (awam hingga mahir). Antarmuka harus sangat intuitif, responsif, dan bebas hambatan teknis.

Verifikator / Panitia: Kemampuan operasional komputer tingkat menengah. Membutuhkan efisiensi antarmuka untuk pemrosesan data berjumlah besar (bulk processing).

Administrator: Kemampuan teknis tingkat lanjut. Mengoperasikan konfigurasi sistem, manipulasi data akhir, dan pemeliharaan akses.

### 2.3 Lingkungan Operasi

Sistem Operasi Server: Linux Ubuntu Server 22.04 LTS atau lebih baru.

Web Server: NGINX 1.24+ dengan reverse proxy dan caching layer.

Database Engine: MySQL 8.0+ atau PostgreSQL 15+.

Runtime Environment: PHP 8.2+ (Laravel Framework) atau Node.js 18+ (Express/NestJS).

Client Browser: Google Chrome v100+, Mozilla Firefox v100+, Safari v15+, Microsoft Edge v100+.

## 3. Persyaratan Antarmuka Eksternal

### 3.1 Antarmuka Pengguna (UI)

Desain berbasis mobile-first dan responsif penuh pada resolusi breakpoint 320px hingga 1920px.

Mematuhi standar rasio kontras warna minimum 4.5:1 sesuai WCAG 2.1 AA.

Navigasi pendaftaran menggunakan visualisasi step-progress bar yang jelas.

### 3.2 Antarmuka Komunikasi

Seluruh transmisi data antar klien dan server wajib menggunakan protokol tersandi HTTPS via TLS 1.3.

Pertukaran data API menggunakan format standar JSON.

## 4. Persyaratan Fungsional Detail (REQ)

### 4.1 Modul Autentikasi (REQ-AUTH)

REQ-AUTH-01: Sistem harus mengvalidasi keunikan NIK (16 digit) dan NISN (10 digit) pada saat registrasi pendaftar baru.

REQ-AUTH-02: Sistem harus membatasi hak akses halaman dan entitas API berdasarkan peran pengguna yang terverifikasi (Role-Based Access Control).

REQ-AUTH-03: Sistem harus menyediakan mekanisme reset password aman menggunakan one-time token yang dikirimkan via email atau No. WhatsApp terdaftar.

REQ-AUTH-04: Sistem harus membatasi batas percobaan login gagal maksimal 5 kali sebelum melakukan penguncian sementara akun (account lockout) selama 15 menit.

### 4.2 Modul Pendaftaran (REQ-REG)

REQ-REG-01: Sistem harus menyediakan formulir pendaftaran bertahap (multistep form) yang terbagi menjadi: Data Diri, Data Orang Tua/Wali, Data Akademik, dan Pemilihan Jalur.

REQ-REG-02: Sistem harus menyediakan fitur Save Draft otomatis sehingga calon siswa dapat melanjutkan pengisian formulir kapan saja sebelum batas waktu penutupan.

REQ-REG-03: Sistem harus melakukan penguncian data (Lock Data) secara permanen setelah calon siswa melakukan tindakan finalisasi/submit pendaftaran.

### 4.3 Modul Pengelolaan Berkas (REQ-FILE)

REQ-FILE-01: Sistem harus mengvalidasi tipe file yang diunggah (hanya PDF, JPG, PNG) dan ukuran file maksimal 2 MB per dokumen.

REQ-FILE-02: Sistem harus mengubah nama file asli menggunakan algoritma hashing SHA-256 acak untuk mencegah eksploitasi eksekusi file script di server storage.

REQ-FILE-03: Sistem harus menyediakan modul In-App Document Preview bagi verifikator untuk memeriksa berkas tanpa perlu mengunduh file ke perangkat lokal.

### 4.4 Modul Verifikasi (REQ-VERIF)

REQ-VERIF-01: Dashboard verifikator harus menyediakan fitur filtering data pendaftar berdasarkan jalur, status verifikasi, dan kata kunci pencarian.

REQ-VERIF-02: Verifikator harus dapat mengubah status pendaftaran menjadi Approved, Rejected, atau Revision Needed.

REQ-VERIF-03: Jika status diubah menjadi Rejected atau Revision Needed, sistem mewajibkan verifikator mengisi alasan/catatan koreksi yang dapat dilihat oleh pendaftar.

### 4.5 Modul Pengumuman & Output (REQ-OUT)

REQ-OUT-01: Sistem harus memiliki engine pemeringkatan otomatis yang mengkalkulasi bobot nilai/jarak sesuai aturan jalur secara real-time atau terjadwal.

REQ-OUT-02: Sistem harus mampu mencetak Kartu Tanda Pendaftaran dan Bukti Hasil Seleksi dalam format PDF secara presisi.

REQ-OUT-03: Dokumen PDF yang diterbitkan wajib memuat Encrypted QR Code yang jika dipindai akan mengarah ke URL validasi keabsahan dokumen di server resmi.

## 5. Persyaratan Non-Fungsional (NFR)

[ KINERJA ]           [ KEAMANAN ]           [ KELEMBAGAAN ]

Response Time < 2s    Enkripsi TLS 1.3 / Bcrypt     Uptime 99.5%

200+ Concurrent Users    Proteksi CSRF / XSS     Aksesibilitas WCAG

NFR-PERF (Performance): Waktu respon server untuk beban standar harus < 2 detik. Sistem harus mampu menangani beban puncak minimal 200 concurrent users tanpa penurunan performa signifikan.

NFR-SEC (Security): Seluruh password pengguna disimpan menggunakan hashing Bcrypt/Argon2id. Sistem wajib dilengkapi proteksi terintegrasi terhadap serangan CSRF, XSS, dan SQL Injection, serta menerapkan rate limiting pada API (max 60 request/menit per IP).

NFR-USA (Usability): Antarmuka harus mencapai skor System Usability Scale (SUS) minimal 75 dan memenuhi kriteria aksesibilitas WCAG 2.1 AA.

NFR-AVA (Availability): Uptime server dipastikan minimal 99.5% selama periode aktif pendaftaran dan pengumuman PPDB.

# BAGIAN III: RENCANA PROGRES PENGEMBANGAN (DEVELOPMENT PROGRESS PLAN)

## 1. Garis Waktu & Fase Utama (8 Minggu)

M1-M2: [Fase 1: Inisiasi & Desain UI/UX/DB]

M3-M6: [Fase 2: Development Sprints & Fitur Utama]

M7   : [Fase 3: QA, Load Testing, & UAT]

M8   : [Fase 4: Deployment & Go-Live]

M9+  : [Fase 5: Pemeliharaan Pasca-Rilis]

Minggu 1–2 (Fase 1: Inisiasi & Perancangan):

Analisis kebutuhan akhir dan finalisasi dokumen PRD/SRS.

Perancangan skema basis data (ERD) dan pemetaan API endpoint.

Pembuatan wireframe High-Fidelity dan desain UI/UX sesuai standar WCAG 2.1 AA.

Minggu 3–6 (Fase 2: Sprints Pengembangan Utama):

Sprint 1 (M3): Pengkondisian repositori, modul autentikasi (REQ-AUTH), dan peran pengguna.

Sprint 2 (M4): Formulir pendaftaran multistep (REQ-REG) & fitur draft/lock data.

Sprint 3 (M5): Modul unggah berkas (REQ-FILE) & dashboard verifikasi panitia (REQ-VERIF).

Sprint 4 (M6): Engine pemeringkatan otomatis, penjaanaan PDF, dan integrasi QR Code (REQ-OUT).

Minggu 7 (Fase 3: Pengujian & Quality Assurance):

Pelaksanaan pengujian menyeluruh (Unit Test, Integration Test, System Test).

User Acceptance Testing (UAT) bersama panitia PPDB.

Load testing (simulasi 200+ concurrent users) dan vulnerability scanning.

Minggu 8 (Fase 4: Deployment & Go-Live):

Konfigurasi infrastruktur produksi, SSL/TLS, dan pipeline CI/CD.

Migrasi data awal (master data sekolah/kuota) dan rilis publik (Go-Live).

Minggu 9+ (Fase 5: Pemeliharaan & Monitoring):

Pemantauan performa server, penanganan bug mendadak, dan dukungan teknis harian.

## 2. Matriks Pengujian & Traceability (Test Cases)

| Requirement ID | Test Case ID | Skenario Pengujian | Ekspektasi Hasil | Status |
| --- | --- | --- | --- | --- |
| REQ-AUTH-01 | TC-AUTH-01 | Registrasi akun dengan NIK/NISN yang sudah terdaftar di sistem. | Sistem menolak registrasi dan menampilkan pesan error duplikasi data. |  |
| REQ-AUTH-02 | TC-AUTH-02 | Akses URL dashboard verifikator menggunakan akun Calon Siswa. | Sistem menolak akses dan mengarahkan kembali (redirect) ke halaman siswa. |  |
| REQ-REG-03 | TC-REG-01 | Mengubah data formulir pendaftaran setelah melakukan finalisasi (Lock Data). | Elemen formulir terkunci (disabled) dan permintaan API pembaruan ditolak. |  |
| REQ-FILE-01 | TC-FILE-01 | Mengunggah file berkas persyaratan format .exe atau ukuran > 2 MB. | Sistem menolak file dan menampilkan peringatan format/ukuran tidak sesuai. |  |
| REQ-FILE-02 | TC-FILE-02 | Memeriksa struktur direktori penyimpanan file di server storage. | Nama file terenkripsi menggunakan hash SHA-256 dan terisolasi dari skrip publik. |  |
| REQ-VERIF-02 | TC-VERIF-01 | Verifikator mengubah status pendaftar menjadi Rejected tanpa mengisi alasan. | Sistem menahan eksekusi dan mewajibkan pengisian kolom catatan perbaikan. |  |
| REQ-OUT-02 | TC-OUT-01 | Mengunduh PDF Kartu Pendaftaran dan memindai QR Code di dalamnya. | QR Code berhasil dipindai dan mengarah ke URL verifikasi data keabsahan siswa. |  |
