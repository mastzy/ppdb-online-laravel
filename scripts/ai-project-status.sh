#!/usr/bin/env bash
set -e

echo "=========================================="
echo "  AI PROJECT STATUS DIAGNOSTIC REPORT"
echo "  Waktu: $(date)"
echo "=========================================="

if [ ! -f "artisan" ]; then
    echo "[ERROR] File 'artisan' tidak ditemukan. Jalankan dari root Laravel."
    exit 1
fi
echo "[OK] Root direktori Laravel terverifikasi."

COMPOSE_FILE=""
if [ -f "compose.yaml" ]; then COMPOSE_FILE="compose.yaml"
elif [ -f "compose.yml" ]; then COMPOSE_FILE="compose.yml"
elif [ -f "docker-compose.yml" ]; then COMPOSE_FILE="docker-compose.yml"
fi

if [ -n "$COMPOSE_FILE" ]; then echo "[OK] File Compose: $COMPOSE_FILE"
else echo "[WARN] File Compose tidak ditemukan."
fi

DOCKER_CMD=""
if command -v docker &> /dev/null && docker compose version &> /dev/null; then DOCKER_CMD="docker compose"
elif command -v docker-compose &> /dev/null; then DOCKER_CMD="docker-compose"
fi

if [ -n "$DOCKER_CMD" ]; then echo "[OK] Perintah Docker: '$DOCKER_CMD'"
else echo "[WARN] Perintah Docker Compose tidak terdeteksi."
fi

echo ""
echo "--- STATUS GIT ---"
git status --short || echo "Bukan repositori Git."

if [ -n "$DOCKER_CMD" ] && [ -n "$COMPOSE_FILE" ]; then
    echo ""
    echo "--- SERVICE DOCKER ---"
    $DOCKER_CMD -f "$COMPOSE_FILE" config --services 2>/dev/null || true
    echo ""
    echo "--- CONTAINER RUNNING STATUS ---"
    $DOCKER_CMD -f "$COMPOSE_FILE" ps || true
fi
echo "=========================================="
