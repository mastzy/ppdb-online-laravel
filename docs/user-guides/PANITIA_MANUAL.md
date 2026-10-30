# Panduan Operasional Panitia PPDB Online (v1.0.0)

Dokumen ini ditujukan untuk **Panitia Verifikator** dan **Bendahara (Kasir Offline)** yang mengelola proses penerimaan peserta didik melalui aplikasi PPDB Online.

---

## 1. Alur Kerja Verifikator

### 1.1 Masuk ke Dashboard Verifikator
1. Buka URL aplikasi (mis. `https://ppdb.sekolahmu.id`).
2. Login dengan **username** dan **password** yang diberikan oleh administrator.
3. Setelah berhasil masuk, pilih menu **Verifikator → Dashboard**.

### 1.2 Memeriksa Berkas Pendaftar
1. Pada tabel **Pendaftar Menunggu Verifikasi**, klik tombol **"Review"** pada baris pendaftar yang ingin diverifikasi.
2. Sebuah **In‑App Document Preview Modal** akan terbuka, menampilkan foto KK, Akta, dan SKL secara langsung tanpa mengunduh file.
3. Periksa kejelasan tiap berkas:
   - Pastikan foto tidak blur dan ukuran minimal **300 KB** (sudah otomatis dikonversi ke WebP pada upload).
   - Pastikan semua informasi (nama, NIK, tanggal lahir) terbaca jelas.

### 1.3 Menyetujui atau Menolak Berkas
- **Setujui**
  1. Klik tombol **"Setujui"** pada modal.
  2. Sistem otomatis menandai status pendaftar menjadi **"Lunas / Verifikasi"**.
- **Revisi**
  1. Klik tombol **"Minta Revisi"**.
  2. Isi kolom **Catatan Revisi** dengan penjelasan singkat, misalnya *"Foto KK terlalu blur, harap upload ulang dengan pencahayaan yang lebih baik"*.
  3. Klik **Kirim**. Pendaftar akan menerima notifikasi WhatsApp (jika di‑aktifkan) dan dapat memperbaiki berkas.

---

## 2. Panduan Kasir Offline (Bendahara)

### 2.1 Mencari NIK Pendaftar
1. Pada menu **Kasir → Pencarian**, masukkan **NIK** atau **Kode Registrasi** pada field pencarian.
2. Tekan **Enter** atau klik **Cari**. Hasil akan menampilkan data pendaftar beserta status pembayaran.

### 2.2 Memproses Pembayaran Tunai
1. Pastikan pendaftar berada di loket dan mengonfirmasi jumlah **Tagihan** (termasuk 3‑digit kode unik).
2. Pada tabel pendaftar, klik tombol **"Bayar Tunai"**.
3. Sistem otomatis:
   - Mengubah status menjadi **"paid"**.
   - Membuat entri **Payment** dengan metode `cash` dan status `verified`.
   - Men-generate **Kuitansi PDF** yang berisi QR Code untuk verifikasi.
4. Klik **"Cetak Kuitansi"** untuk membuka PDF di tab baru, lalu cetak menggunakan printer.

### 2.3 Mengirim Notifikasi WhatsApp
Setelah pembayaran berhasil, Kasir dapat mengirim notifikasi langsung ke orang tua:
1. Pada halaman **Detail Pembayaran**, klik tombol **"Kirim WA"**.
2. Sistem akan membuka **WhatsApp Web** (atau aplikasi WA pada perangkat mobile) dengan template pesan:
   ```text
   Yth. Bapak/Ibu *{NAMA_ORANG_TUA}*,
   Pembayaran PPDB Anda dengan NIK *{NIK}* telah kami terima.
   Berikut link kuitansi resmi: {URL_KUITANSI}
   Terima kasih.
   ```
3. Tekan **Send** untuk mengirim.

---

## 3. Fitur WhatsApp Direct‑Link

### 3.1 Apa itu Direct‑Link?
Direct‑Link adalah URL khusus yang memanggil aplikasi WhatsApp dengan pesan pra‑isi. Format:
```
https://wa.me/<NO_WA>?text=<URL_ENCODED_MESSAGE>
```
### 3.2 Cara Menggunakan di Aplikasi
1. Pada **Formulir Verifikasi** atau **Halaman Pembayaran**, terdapat tombol **"Kirim WA"**.
2. Tombol secara otomatis men‑generate link dengan placeholder:
   - `{NAMA}` → Nama pendaftar
   - `{NIK}` → NIK pendaftar
   - `{STATUS}` → Status (mis. "Lunas", "Revisi")
   - `{NOMINAL}` → Jumlah tagihan lengkap kode unik
   - `{CATATAN_REVISI}` → Catatan revisi (jika ada)
3. Klik tombol, browser membuka WhatsApp dengan pesan siap kirim.

---

## 4. Tips & Trik
- Pastikan **Internet** stabil saat meng‑akses modal preview; jika terputus, reload halaman.
- Gunakan **QR Code Scanner** pada ponsel untuk memverifikasi kuitansi serta SK Lulus.
- Semua aksi penting (login, verifikasi, pembayaran) tercatat dalam **Audit Log** (lihat panduan Admin).

---

*Dokumen ini disusun pada 30 Oktober 2026 dan berlaku untuk versi aplikasi **v1.0.0**.*
