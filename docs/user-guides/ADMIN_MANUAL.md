# Panduan Administrasi PPDB Online (v1.0.0)

Dokumen ini ditujukan untuk **Administrator** yang mengelola konfigurasi PPDB Online, termasuk pengaturan gelombang, kuota, ekspor data, dan pemantauan statistik.

---

## 1. Mengubah Status Gelombang & Kuota Pendaftaran

### 1.1 Akses Pengaturan Gelombang
1. Login ke aplikasi dengan akun **admin**.
2. Pilih menu **Admin → Pengaturan**.
3. Pada halaman **Pengaturan Kuota & Gelombang**, Anda akan melihat tabel daftar **Klaster** beserta **Kuota** masing‑masing.

### 1.2 Mengubah Kuota
- Pada kolom **Kuota**, edit nilai angka sesuai kebutuhan (mis. menambah atau mengurangi kuota). 
- Klik **"Simpan"**. Sistem akan menyimpan perubahan ke tabel `program_clusters`.

### 1.3 Mengubah Status Gelombang
- Di bagian **Gelombang Aktif**, terdapat dropdown dengan daftar gelombang (contoh: *Gelombang 1*, *Gelombang 2*).
- Pilih gelombang yang ingin diaktifkan, kemudian tekan **"Aktifkan"**.
- Semua pendaftar baru secara otomatis terasosiasi dengan gelombang yang aktif.

> **Catatan:** Perubahan status gelombang akan tercatat di **Audit Log**.

---

## 2. Mengunduh Data Ekspor EMIS & Dapodik

### 2.1 Memilih Filter
1. Pada menu **Admin → Export Data**, pilih tab **EMIS** atau **Dapodik**.
2. Gunakan filter **Klaster** dan **Gelombang** untuk mengekspor subset data (mis. hanya klaster *STEM* pada *Gelombang 1*).

### 2.2 Menjalankan Ekspor
- Klik tombol **"Ekspor"**. Sistem akan mem‑generate file **CSV** (EMIS) atau **Excel** (Dapodik) dengan format yang sudah disesuaikan untuk impor massal ke sistem Kemenag atau Kemendikbud.
- File akan di‑download secara otomatis melalui browser.

### 2.3 Format File
| Kolom | Deskripsi |
|-------|-----------|
| `reg_code` | Kode Registrasi unik (contoh: `PPDB-2026-0012`) |
| `nik` | NIK siswa (16 digit) |
| `full_name` | Nama lengkap peserta |
| `dob` | Tanggal lahir (YYYY‑MM‑DD) |
| `cluster_name` | Nama klaster (Keagamaan, STEM, dsb.) |
| `status` | Status akhir (`approved`, `revision_needed`, dsb.) |
| `payment_status` | `paid`, `pending`, `unpaid` |
| `created_at` | Tanggal pendaftaran |

---

## 3. Memantau Statistik Pendaftar (Chart.js)

### 3.1 Dashboard Admin
- Buka **Admin → Dashboard**.
- Di bagian atas terdapat **Metrics Cards** (Total Pendaftar, Kuota Terisi, Pendapatan, dll.).
- Di bawah terdapat **Grafik Chart.js**:
  - **Donut Chart**: Distribusi pendaftar per klaster.
  - **Bar Chart**: Jumlah pendaftar per gelombang.
  - **Line Chart**: Tren pendaftaran harian selama 30 hari terakhir.

### 3.2 Interaksi
- Hover pada segmen chart untuk melihat nilai numerik.
- Klik pada segmen *Donut* akan memfilter tabel pendaftar ke klaster yang dipilih.

---

## 4. Audit Log (Keamanan & Transparansi)
- Semua aksi kritis (login admin, perubahan kuota, verifikasi, pembayaran) tercatat di tabel `audit_logs`.
- Pada **Admin → Audit Log**, Anda dapat memfilter berdasarkan **user**, **IP**, **aktivitas**, atau rentang tanggal.

---

*Dokumen ini disusun pada 30 Oktober 2026 untuk versi aplikasi **v1.0.0**.*
