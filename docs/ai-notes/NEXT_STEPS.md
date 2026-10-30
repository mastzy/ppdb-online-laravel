## NEXT STEPS

- **Status Akhir Proyek**: Seluruh View Blade pada proyek PPDB Online (Portal Pendaftar, Portal Siswa, Dashboard Admin/Verifikator/Kasir/Penguji, Validasi QR Code, dan Halaman Error) telah **100% lengkap, utuh, dan konsisten menggunakan Tailwind CSS CDN, FontAwesome 6, dan Alpine.js 3**.
- **Kondisi Pengujian & Kontainer**:
  * 5/5 Container Docker Compose UP & Healthy (`app`, `db`, `redis`, `webserver`, `phpmyadmin`).
  * Test Suite: `10 passed, 112 assertions, 0 failed`.
- **Langkah Lanjutan**:
  * Menyiapkan deployment pipeline atau pengujian integrasi browser lanjutan.

### Deployment ke VPS (Produksi)
1. Pastikan server VPS memiliki Docker Engine & Docker Compose v2 terinstall.
2. Clone repository ke server:
   ```bash
   git clone https://github.com/your-org/ppdb-online.git && cd ppdb-online
   ```
3. Copy file `.env.example` menjadi `.env` dan sesuaikan variabel database, app key, dan port:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Build & jalankan layanan dengan satu perintah:
   ```bash
   docker compose up -d --build
   ```
   *Nginx container otomatis mengekspor port 80 ke port yang Anda tentukan di variabel `APP_PORT` (default 8000).* 
5. Setelah semua container sehat, lakukan migrasi & seed database:
   ```bash
   docker compose exec app php artisan migrate --force
   docker compose exec app php artisan db:seed --force
   ```
6. (Opsional) Jalankan perintah `php artisan storage:link` di dalam container `app` untuk membuat link folder public storage.
7. Akses aplikasi melalui `http://<VPS_IP>:<APP_PORT>`.


- **Status Akhir Proyek**: Seluruh View Blade pada proyek PPDB Online (Portal Pendaftar, Portal Siswa, Dashboard Admin/Verifikator/Kasir/Penguji, Validasi QR Code, dan Halaman Error) telah **100% lengkap, utuh, dan konsisten menggunakan Tailwind CSS CDN, FontAwesome 6, dan Alpine.js 3**.
- **Kondisi Pengujian & Kontainer**:
  * 5/5 Container Docker Compose UP & Healthy (`app`, `db`, `redis`, `webserver`, `phpmyadmin`).
  * Test Suite: `10 passed, 112 assertions, 0 failed`.
- **Langkah Lanjutan**:
  * Menyiapkan deployment pipeline atau pengujian integrasi browser lanjutan.
