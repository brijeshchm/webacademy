#!/usr/bin/env bash
# =============================================================================
# server-deploy.sh — BigRock cPanel Deployment Script
# =============================================================================
# Run this via SSH on your BigRock server AFTER uploading laravel-backend/
# to ~/laravel-backend/.
#
# Usage:
#   chmod +x ~/laravel-backend/scripts/server-deploy.sh
#   ~/laravel-backend/scripts/server-deploy.sh
# =============================================================================

set -euo pipefail

LARAVEL_DIR="$HOME/laravel-backend"
PUBLIC_HTML="$HOME/public_html"

echo ""
echo "================================================="
echo "  Corporate Academy — Server Deployment Script"
echo "================================================="
echo ""

# ── 0. Sanity checks ─────────────────────────────────────────────────────────
if [ ! -d "$LARAVEL_DIR" ]; then
  echo "ERROR: $LARAVEL_DIR not found."
  echo "Upload the laravel-backend/ folder to your home directory first."
  exit 1
fi

if [ ! -d "$PUBLIC_HTML" ]; then
  echo "ERROR: $PUBLIC_HTML not found."
  echo "This script expects a standard cPanel home directory layout."
  exit 1
fi

cd "$LARAVEL_DIR"
echo "Working directory: $(pwd)"
echo ""

# ── 0b. PHP extension prerequisites ──────────────────────────────────────────
# GD is required by GET /api/og-image to generate the dynamic OG image PNG.
# Without it the endpoint falls back to streaming the static og-image.jpg (still
# returns a valid image), but enable GD for best results.
if php -r "exit(extension_loaded('gd') ? 0 : 1);" 2>/dev/null; then
  echo "[pre-check] PHP GD extension: OK"
else
  echo "[pre-check] WARNING: PHP GD extension is not loaded."
  echo "  Enable it in cPanel → PHP Extensions, or add 'extension=gd' to php.ini."
  echo "  The /api/og-image endpoint will fall back to the static og-image.jpg."
fi
echo ""

# ── 1. Composer install ───────────────────────────────────────────────────────
echo "[1/7] Installing PHP dependencies (composer install --no-dev)..."
if command -v composer &>/dev/null; then
  composer install --no-dev --optimize-autoloader --no-interaction
elif [ -f "$HOME/composer.phar" ]; then
  php "$HOME/composer.phar" install --no-dev --optimize-autoloader --no-interaction
else
  echo "ERROR: composer not found. Upload composer.phar to $HOME or install it."
  echo "  Download: https://getcomposer.org/download/"
  exit 1
fi
echo ""

# ── 2. Environment file ───────────────────────────────────────────────────────
echo "[2/7] Checking .env file..."
if [ ! -f ".env" ]; then
  if [ -f ".env.example" ]; then
    cp .env.example .env
    echo "  Created .env from .env.example"
    echo ""
    echo "  ⚠️  STOP: Edit .env now and set all required values, then re-run this script."
    echo "  Required fields:"
    echo "    APP_KEY          (leave blank — will be generated in next step)"
    echo "    DB_HOST          (usually 127.0.0.1)"
    echo "    DB_DATABASE      (your cPanel MySQL database name)"
    echo "    DB_USERNAME      (your cPanel MySQL username)"
    echo "    DB_PASSWORD      (your cPanel MySQL password)"
    echo "    OPENAI_API_KEY"
    echo "    OPENAI_BASE_URL  (https://api.openai.com/v1)"
    echo "    RESEND_API_KEY"
    echo "    NOTIFY_EMAIL     (email that receives lead notifications)"
    echo "    SMTP_USER        (reply-to email)"
    echo "    ADMIN_PASSWORD   (strong password for the admin panel)"
    echo "    APP_URL          (e.g. https://yourdomain.com/api)"
    echo ""
    echo "  Edit with: nano .env"
    exit 1
  else
    echo "ERROR: .env.example not found. Re-upload the laravel-backend/ folder."
    exit 1
  fi
else
  echo "  .env file found."
fi

# Validate critical .env values
for VAR in DB_DATABASE DB_USERNAME DB_PASSWORD ADMIN_PASSWORD APP_URL; do
  VAL=$(grep -E "^${VAR}=" .env | cut -d= -f2- | tr -d '"' | tr -d "'")
  if [ -z "$VAL" ] || [[ "$VAL" == *"your_"* ]] || [[ "$VAL" == *"yourdomain"* ]] || [[ "$VAL" == "change_me"* ]]; then
    echo "ERROR: $VAR in .env is not set or still has a placeholder value."
    echo "Edit .env and set: $VAR"
    exit 1
  fi
done
echo "  .env values look configured."
echo ""

# ── 3. Generate application key ───────────────────────────────────────────────
APP_KEY=$(grep -E "^APP_KEY=" .env | cut -d= -f2-)
if [ -z "$APP_KEY" ]; then
  echo "[3/7] Generating application key..."
  php artisan key:generate --force
else
  echo "[3/7] Application key already set — skipping."
fi
echo ""

# ── 4. Run migrations ─────────────────────────────────────────────────────────
echo "[4/7] Running database migrations..."
php artisan migrate --force
echo ""

# ── 5. Set permissions ────────────────────────────────────────────────────────
echo "[5/7] Setting file permissions..."
chmod -R 755 storage bootstrap/cache
# Log files should be 644 if they exist
if [ -d "storage/logs" ]; then
  find storage/logs -name "*.log" -exec chmod 644 {} \; 2>/dev/null || true
fi
echo "  Permissions set."
echo ""

# ── 6. Symlink Laravel public/ → public_html/api ──────────────────────────────
echo "[6/7] Setting up /api endpoint in public_html..."
if [ -L "$PUBLIC_HTML/api" ]; then
  echo "  Symlink $PUBLIC_HTML/api already exists — removing and recreating."
  rm "$PUBLIC_HTML/api"
fi

if [ -d "$PUBLIC_HTML/api" ]; then
  echo "  WARNING: $PUBLIC_HTML/api is a real directory, not a symlink."
  echo "  Remove it manually first: rm -rf $PUBLIC_HTML/api"
  echo "  Then re-run this script."
  exit 1
fi

ln -s "$LARAVEL_DIR/public" "$PUBLIC_HTML/api"
echo "  Created symlink: $PUBLIC_HTML/api → $LARAVEL_DIR/public"
echo ""

# ── 7. Optimize Laravel ───────────────────────────────────────────────────────
echo "[7/7] Optimizing Laravel for production..."
php artisan config:cache
php artisan route:cache
echo "  Config and route caches built."
echo ""

# ── Summary ──────────────────────────────────────────────────────────────────
echo "================================================="
echo "  ✓ Server-side deployment complete!"
echo "================================================="
echo ""
echo "Next steps:"
echo "  1. Upload the React build output (dist/public/*) to $PUBLIC_HTML/"
echo "  2. Upload the SPA .htaccess to $PUBLIC_HTML/.htaccess"
echo "     (file: laravel-backend/scripts/public_html.htaccess in the repo)"
echo "  3. Test: curl https://yourdomain.com/api/healthz"
echo "     Expected: {\"status\":\"ok\"}"
echo ""
echo "If you exported PostgreSQL data, run the seeder:"
echo "  cd $LARAVEL_DIR && php artisan db:seed --class=ImportFromJsonSeeder"
echo ""
