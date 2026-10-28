#!/usr/bin/env bash

set -e

# Berpindah ke direktori root proyek
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"

echo "=== Memulai Setup Awal Proyek PPDB Online (Docker) ==="

# 1. Pastikan file .env ada
if [ ! -f .env ]; then
    echo "File .env tidak ditemukan. Menyalin dari .env.example..."
    cp .env.example .env
fi

# 2. Deteksi command docker compose (v2 plugin atau standalone docker-compose)
if docker compose version &> /dev/null; then
    COMPOSE="docker compose"
elif command -v docker-compose &> /dev/null; then
    COMPOSE="docker-compose"
else
    echo "Error: Docker Compose tidak ditemukan. Harap install Docker Compose terlebih dahulu."
    exit 1
fi

echo "Menggunakan: $COMPOSE"

# 3. Menjalankan container Docker (build dan start di background)
echo "1/5. Membangun dan menjalankan container Docker..."
$COMPOSE up -d --build

# 4. Menunggu database MySQL siap
echo "Menunggu database MySQL siap menerima koneksi..."
MAX_RETRIES=45
COUNT=0
until $COMPOSE exec -T db mysqladmin ping -h 127.0.0.1 -uroot -psecret --silent > /dev/null 2>&1 || \
      $COMPOSE exec -T db mysqladmin ping -h 127.0.0.1 -uppdb_user -psecret --silent > /dev/null 2>&1; do
    COUNT=$((COUNT + 1))
    if [ $COUNT -ge $MAX_RETRIES ]; then
        echo "Error: Database MySQL tidak siap setelah $((MAX_RETRIES * 2)) detik."
        exit 1
    fi
    sleep 2
done
echo "Database MySQL telah siap."

# 5. Jalankan composer install di dalam container app
echo "2/5. Menjalankan composer install..."
$COMPOSE exec -T app git config --global --add safe.directory /var/www || true
$COMPOSE exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# 6. Generate application key
echo "3/5. Menjalankan php artisan key:generate..."
$COMPOSE exec -T app php artisan key:generate --force --no-interaction

# 7. Jalankan migrasi database
echo "4/5. Menjalankan php artisan migrate..."
$COMPOSE exec -T app php artisan migrate --force --no-interaction

# 8. Buat symbolic link untuk storage
echo "5/5. Menjalankan php artisan storage:link..."
$COMPOSE exec -T app php artisan storage:link --no-interaction

echo "=== Setup Berhasil Selesai! ==="
echo "Aplikasi PPDB Online berjalan dan dapat diakses di: http://localhost:8000"
