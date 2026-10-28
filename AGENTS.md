# ATURAN PERMANEN AI (AGENTS.md)

Aturan ini wajib dipatuhi oleh semua AI (Gemini, ChatGPT, Antigravity) sebelum, selama, dan setelah bekerja pada proyek ini.

## PROSEDUR WAJIB SEBELUM BEKERJA:
1. BACA `docs/ai-notes/NEXT_STEPS.md` dan `docs/ai-notes/PROJECT_CONTEXT.md`.
2. PERIKSA perubahan Git yang belum di-commit dengan `git status`.
3. JALANKAN skrip diagnostik `bash scripts/ai-project-status.sh`.
4. VERIFIKASI nama service Docker Compose aktual sebelum mengeksekusi perintah.

## ATURAN KESELAMATAN TEKNIS:
1. DILARANG menjalankan `docker compose down -v` atau `docker-compose down -v`.
2. DILARANG mengeksekusi `chmod -R 777`.
3. DILARANG menjalankan migrasi destruktif (`migrate:fresh`, `migrate:reset`) tanpa persetujuan pengguna.
4. DILARANG menyalin isi token, password, atau secret dari `.env` ke file dokumentasi `docs/ai-notes/` atau Git.
5. DILARANG mengubah versi PHP, Laravel, atau database tanpa persetujuan eksplisit.

## PROSEDUR SETELAH BEKERJA:
1. Perbarui `docs/ai-notes/SESSION_LOG.md`.
2. Perbarui `docs/ai-notes/TASKS.md`.
3. Perbarui `docs/ai-notes/NEXT_STEPS.md`.