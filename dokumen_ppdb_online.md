# DOKUMEN SPESIFIKASI & STRATEGI RILIS SISTEM INFORMASI PPDB ONLINE MANDIRI

**Sekolah Swasta / Madrasah Aliyah (MA) — Kurikulum Merdeka & Keuangan Mandiri**

---

## I. PRODUCT REQUIREMENT DOCUMENT (PRD)

### 1\. Ringkasan Eksekutif & Tujuan

Sistem Informasi PPDB Online ini dibangun khusus untuk memenuhi karakteristik operasional Sekolah Swasta dan Madrasah Aliyah (MA). Berbeda dengan PPDB sekolah negeri yang terikat aturan zonasi kaku, sistem ini berfokus pada:

- **Kecepatan Penjaringan Kuota (Early Intake):** Memudahkan pendaftar mengunci kuota dalam waktu kurang dari 1 menit.  
- **Zero-Friction UX (Ramah Orang Tua Gaptek):** Mengeliminasi syarat email dan password rumit, serta meminimalkan proses mengetik.  
- **Fleksibilitas Kurikulum Merdeka & Asrama:** Akomodasi pemetaan klaster mata pelajaran pilihan (Fase E/F) serta pilihan status Santri Mukim (Asrama) vs Day School.  
- **100% Keuangan Mandiri Tanpa Biaya Pihak Ke-3:** Bebas biaya komisi *payment gateway* dan biaya admin. Verifikasi dilakukan secara mandiri oleh bendahara melalui transfer nominal pas atau mode kasir offline.

---

### 2\. User Roles & Hak Akses (RBAC)

| Peran (Role) | Hak Akses & Fitur Utama | Mekanisme Login |
| :---- | :---- | :---- |
| **Calon Siswa / Ortu** | Form Multistep 1-Menit, Pilihan Klaster & Asrama, Simulasi Biaya, Live Tracking Status, Upload Foto Berkas, Unduh Kartu & Kuitansi PDF. | NIK (16 Digit) \+ Tanggal Lahir (DDMMYYYY) / Kode Reg |
| **Verifikator Berkas** | Dashboard Verifikasi Berkas, *In-App Document Preview*, Ubah Status (`Approved`, `Revision Needed`), Catatan Koreksi Berkas. | Username \+ Password Terenkripsi |
| **Bendahara / Kasir** | Dashboard Keuangan, Match Foto Struk Transfer, Mode Kasir *Offline* (Bayar Tunai di Sekolah), Terbitkan Kuitansi PDF. | Username \+ Password Terenkripsi |
| **Tim Penguji / Ustaz** | Form Input Nilai Asesmen Diagnostik (Literasi, Numerasi, BTQ, Tahfidz), Catatan Pemetaan Kesiapan Belajar, Wawancara Ortu. | Username \+ Password Terenkripsi |
| **Administrator System** | Pengaturan Tahun Ajaran, Gelombang, Kuota Klaster, Master Biaya, User Management, Ekspor Data Format EMIS / Dapodik. | Username \+ Password \+ Token Auth |

&nbsp;

---

### 3\. Fitur Utama & Keunggulan Spesifik

#### A. Kemudahan Pendaftar Awam (Zero-Friction UX)

1. **Login Tanpa Password:** Pendaftar cukup memasukkan NIK dan Tanggal Lahir untuk masuk kembali ke akun pendaftaran.  
2. **Foto Langsung Kamera HP:** Tombol unggah dokumen langsung membuka kamera HP (bukan folder file) dengan fungsi *auto-crop* dan penyesuaian pencahayaan otomatis.  
3. **Cek Status Tanpa Login:** Fitur pencarian cepat di halaman utama cukup memasukkan NIK atau Kode Pendaftaran.  
4. **Indikator Visual & Bahasa Sehari-hari:** Menggantikan istilah teknis (seperti *Submit*, *Pending*, *Approved*) dengan istilah ramah (*Kirim*, *Diperiksa*, *Lengkap/Diterima*).  
5. **Booking Loket Pendampingan:** Opsi reservasi kedatangan bagi pendaftar yang *gaptek* agar diinputkan langsung oleh panitia di sekolah.

#### B. Adaptasi Kurikulum Merdeka & Madrasah Aliyah (MA)

1. **Pemetaan Klaster Peminatan (Fase E/F):** Pilihan kelompok mata pelajaran (Rumpun Keagamaan, MIPA/STEM, Soshum, Vokasi/Digital).  
2. **Kategori Santri Mukim vs Non-Mukim:** Form khusus riwayat kesehatan, alergi, dan kuesioner kemandirian untuk calon santri asrama.  
3. **Asesmen Diagnostik (BTQ & Tahfidz):** Penilaian kemampuan awal untuk pemetaan kelas pendampingan/matrikulasi (non-kualifikasi gugur).  
4. **Diskon Saudara Kandung (Sibling Discount Auto-Check):** Cek NISN/Nama kakak yang aktif di sekolah untuk mendapatkan potongan biaya otomatis.

#### C. Pengelolaan Keuangan Mandiri (Tanpa Vendor / Biaya Admin)

1. **Transfer Nominal Pas:** Pembayaran murni nominal resmi tanpa biaya admin. Verifikasi berbasis Nama Pemilik Rekening & *Timestamp*.  
2. **Mode Kasir Offline:** Penanganan pendaftar yang membayar tunai langsung di sekolah dengan pencetakan kuitansi *real-time*.  
3. **Kalkulator Beasiswa Yayasan:** Menampilkan estimasi potongan biaya (Tahfidz, Prestasi, Afirmasi) sebelum memfinalisasi pendaftaran.

---

## II. SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

### 1\. Arsitektur Teknis

- **Runtime & Framework:** PHP 8.2-FPM / Laravel 10/11  
- **Web Server:** NGINX 1.24+ (Reverse Proxy & Static Cache)  
- **Database:** MySQL 8.0+  
- **Cache & Session:** Redis Alpine  
- **Containerization:** Docker & Docker Compose  
- **Document & PDF Engine:** `barryvdh/laravel-dompdf` & `simplesoftwareio/simple-qrcode`

---

### 2\. Skema Basis Data (Database Schema Summary)

```
users (id, username, password, role)
registrations (id, reg_code, nik, nisn, full_name, dob, wave_id, cluster_id, is_boarding, status)
program_clusters (id, name, quota, description, is_active)
payments (id, reg_id, amount, sender_name, sender_bank, proof_file, payment_method, status, verified_by)
documents (id, reg_id, doc_type, file_path_hash, status, revision_note)
diagnostic_scores (id, reg_id, btq_score, tahfidz_score, literacy_score, notes)
```

&nbsp;

---

### 3\. Persyaratan Non-Fungsional (NFR)

- **Performance:** Respon server \< 1.5 detik, mendukung 200+ *concurrent users*.  
- **Security:** Hashing nama file SHA-256, Enkripsi TLS 1.3 (HTTPS via Let's Encrypt), sanitasi XSS & CSRF, Rate Limiting 60 req/min.  
- **Usability:** WCAG 2.1 AA Compliant, antarmuka *Mobile-First*, ketersediaan Mode Sederhana (teks besar).

---

## III. WORKFLOW ARCHITECTURE (ALUR KERJA OPERASIONAL)

```
[1. Buka Web PPDB] -> [2. Form Quick-Lock 1-Menit] -> [3. Terbit Kode Reg]
                                                               |
                                                               v
[6. Upload Berkas (Foto HP)] <- [5. Kuitansi PDF Terbit] <- [4. Bayar (Transfer Nominal Pas / Tunai Loket)]
         |
         v
[7. Asesmen Diagnostik & BTQ] -> [8. Verifikasi Berkas & Nilai] -> [9. SK Lulus & Welcome Hub]
```

&nbsp;

---

## IV. STRATEGI RILIS & TIMELINE PRODUKSI (6 WINGGU)

- **Minggu 1:** Inisiasi Docker Compose, setup Laravel, Migrasi DB, & Master Data.  
- **Minggu 2:** Pengembangan Form Multistep & Login NIK \+ Tgl Lahir.  
- **Minggu 3:** Modul Keuangan Mandiri (Transfer Nominal Pas, Kasir Offline, Kuitansi PDF).  
- **Minggu 4:** Modul Dashboard Verifikasi (*In-App Preview*) & Input Asesmen Diagnostik BTQ.  
- **Minggu 5:** Fitur UX Anti-Ribet (Live Tracking, Sibling Discount, Ekspor EMIS/Dapodik) & Load Testing (200 Concurrent Users).  
- **Minggu 6:** Deployment ke Cloud VPS Ubuntu Server \+ SSL Let's Encrypt & Go-Live.