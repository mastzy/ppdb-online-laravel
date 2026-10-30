#!/usr/bin/env bash

# =============================================================================
# Automated Production Deployment Script for PPDB Online (v1.0.0)
# =============================================================================
# This script is intended to be executed on the VPS after pulling the latest
# code from the repository. It runs the essential Laravel Artisan commands
# inside the `app` container using Docker Compose.
#
# Usage:   ./scripts/deploy-vps.sh
# =============================================================================

set -euo pipefail

# 1. Pull the newest code from the remote repository (main branch).
# ---------------------------------------------------------------------
if ! git rev-parse --is-inside-work-tree > /dev/null 2>&1; then
  echo "Error: This script must be run from the project root (git repo)."
  exit 1
fi

echo "--- Pull latest code ---"
git pull origin main

# 2. Clear & cache Laravel configuration, routes, and compiled views.
# ---------------------------------------------------------------------
echo "--- Cache configuration, routes, and views ---"
# Using Docker Compose v2 syntax (docker compose ...) – works with both.

docker compose exec -T app php artisan config:cache

docker compose exec -T app php artisan route:cache

docker compose exec -T app php artisan view:cache

# 3. Ensure the public storage symlink exists (required for uploaded files).
# ---------------------------------------------------------------------
echo "--- Create storage symlink ---"

docker compose exec -T app php artisan storage:link

echo "Deployment script completed successfully."

