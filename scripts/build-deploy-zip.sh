#!/usr/bin/env bash
# =============================================================================
# build-deploy-zip.sh — One-command build of the cPanel deployment zip
# =============================================================================
# Runs the ENTIRE deployment-package pipeline and writes:
#   exports/corporate-academy-laravel.zip
#
# The whole site (public pages + JSON API + admin panel) is now server-rendered
# by a single Laravel application — there is NO separate React build to ship.
# The React app remains in the monorepo for development history only.
#
# Pipeline:
#   1. Export PostgreSQL data → laravel-backend/scripts/data/*.json
#   2. Rebuild the static Tailwind stylesheet → public/assets/app.css
#      (pnpm lives in the workspace; the production server never needs it)
#   3. composer install --no-dev (production vendor/ — needed before artisan)
#   4. Start a throwaway local MariaDB, run Laravel migrations +
#      ImportFromJsonSeeder, strip lead PII, mysqldump → database-mysql.sql
#   5. Assemble laravel-backend/ + database-mysql.sql + README-DEPLOY.txt into
#      the zip (excluding .env, leads.json, node_modules, tests, logs)
#   6. Verify zip contents (public/index.php + built assets + static files
#      present, vendor present, NO .env, NO lead PII, database-mysql.sql
#      present, build timestamp)
#
# Lead records are PII: they are never packaged — leads.json is excluded from
# the zip and the leads table is emptied before the MySQL dump.
#
# Usage (from the monorepo root):
#   DATABASE_URL=postgres://... bash laravel-backend/scripts/build-deploy-zip.sh
#
# DATABASE_URL defaults to the workspace's env var if already set.
# Fails loudly (set -euo pipefail) if any step fails.
# =============================================================================

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
SCRIPTS_DIR="$REPO_ROOT/laravel-backend/scripts"
LARAVEL_DIR="$REPO_ROOT/laravel-backend"
EXPORTS_DIR="$REPO_ROOT/exports"
ZIP_PATH="$EXPORTS_DIR/corporate-academy-laravel.zip"

STAGE_DIR="$(mktemp -d /tmp/deploy-zip-stage.XXXXXX)"
MYSQL_DATADIR="$(mktemp -d /tmp/deploy-zip-mysql-data.XXXXXX)"
MYSQL_RUNDIR="$(mktemp -d /tmp/deploy-zip-mysql-run.XXXXXX)"
MYSQL_SOCK="$MYSQL_RUNDIR/mysql.sock"
MYSQL_PORT="${DEPLOY_ZIP_MYSQL_PORT:-3341}"
DB_NAME="corporate_academy_deploy"
MYSQLD_PID=""

fail() { echo ""; echo "ERROR: $*" >&2; exit 1; }

cleanup() {
  if [ -n "$MYSQLD_PID" ] && kill -0 "$MYSQLD_PID" 2>/dev/null; then
    kill "$MYSQLD_PID" 2>/dev/null || true
    wait "$MYSQLD_PID" 2>/dev/null || true
  fi
  rm -rf "$STAGE_DIR" "$MYSQL_DATADIR" "$MYSQL_RUNDIR"
}
trap cleanup EXIT

echo ""
echo "======================================================="
echo "  Corporate Academy — cPanel Deployment Zip Builder"
echo "======================================================="
echo ""

# ── 0. Preconditions ─────────────────────────────────────────────────────────
for cmd in node pnpm php composer mysqld mysqldump mysql zip unzip tar; do
  command -v "$cmd" >/dev/null 2>&1 || fail "required command not found: $cmd"
done
[ -n "${DATABASE_URL:-}" ] || fail "DATABASE_URL is not set (needed to export Postgres data).
Usage: DATABASE_URL=postgres://... bash $0"

# ── 1. Export PostgreSQL → JSON ──────────────────────────────────────────────
echo "[1/6] Exporting PostgreSQL data to JSON..."
# pg lives in the pnpm workspace (lib/db); expose it to the standalone script.
NODE_PATH="$REPO_ROOT/lib/db/node_modules${NODE_PATH:+:$NODE_PATH}" \
  node "$SCRIPTS_DIR/export-pg-to-json.js"
[ -f "$SCRIPTS_DIR/data/courses.json" ] || fail "export did not produce data/courses.json"
echo ""

# ── 2. Rebuild the static Tailwind stylesheet ────────────────────────────────
echo "[2/6] Rebuilding public/assets/app.css (Tailwind, pnpm-only)..."
bash "$SCRIPTS_DIR/build-css.sh"
[ -s "$LARAVEL_DIR/public/assets/app.css" ] || fail "build-css.sh did not produce public/assets/app.css"
echo ""

# ── 3. Production vendor/ (before any artisan call — vendor/ may be absent) ──
echo "[3/6] composer install --no-dev..."
( cd "$LARAVEL_DIR" && composer install --no-dev --optimize-autoloader --no-interaction --quiet )
[ -d "$LARAVEL_DIR/vendor/laravel/framework" ] || fail "vendor/laravel/framework missing after composer install"
echo ""

# ── 4. Local MariaDB: migrate + seed + dump ──────────────────────────────────
echo "[4/6] Starting throwaway MariaDB and generating database-mysql.sql..."
mysql_install_db --datadir="$MYSQL_DATADIR" --auth-root-authentication-method=normal >/dev/null 2>&1 \
  || fail "mysql_install_db failed"
mysqld --datadir="$MYSQL_DATADIR" --socket="$MYSQL_SOCK" --port="$MYSQL_PORT" \
  --bind-address=127.0.0.1 --skip-networking=0 --skip-grant-tables >/dev/null 2>&1 &
MYSQLD_PID=$!

for i in $(seq 1 60); do
  if mysql --socket="$MYSQL_SOCK" -u root -e "SELECT 1" >/dev/null 2>&1; then break; fi
  kill -0 "$MYSQLD_PID" 2>/dev/null || fail "mysqld exited during startup"
  sleep 0.5
  [ "$i" -eq 60 ] && fail "mysqld did not become ready in 30s"
done

mysql --socket="$MYSQL_SOCK" -u root -e "CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"

# Self-contained artisan env: works on a clean checkout with no .env / cached
# config (throwaway APP_KEY — the dump contains no encrypted values).
DB_ENV=(APP_ENV=production APP_DEBUG=false \
        APP_KEY="base64:$(head -c 32 /dev/urandom | base64)" \
        CACHE_STORE=array SESSION_DRIVER=array \
        DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT="$MYSQL_PORT" \
        DB_SOCKET="$MYSQL_SOCK" DB_DATABASE="$DB_NAME" DB_USERNAME=root DB_PASSWORD=)

( cd "$LARAVEL_DIR" && env "${DB_ENV[@]}" php artisan migrate --force )
( cd "$LARAVEL_DIR" && env "${DB_ENV[@]}" php artisan db:seed --class=ImportFromJsonSeeder --force )

COURSE_COUNT=$(mysql --socket="$MYSQL_SOCK" -u root -N -e "SELECT COUNT(*) FROM \`$DB_NAME\`.courses")
[ "$COURSE_COUNT" -gt 0 ] || fail "seeder produced 0 courses"
echo "Seeded courses: $COURSE_COUNT"

# Lead records are PII — never ship them. Keep the (empty) table schema.
mysql --socket="$MYSQL_SOCK" -u root -e "DELETE FROM \`$DB_NAME\`.leads"
LEAD_COUNT=$(mysql --socket="$MYSQL_SOCK" -u root -N -e "SELECT COUNT(*) FROM \`$DB_NAME\`.leads")
[ "$LEAD_COUNT" -eq 0 ] || fail "leads table not emptied before dump (PII guard)"

mysqldump --socket="$MYSQL_SOCK" -u root --routines --triggers "$DB_NAME" > "$STAGE_DIR/database-mysql.sql"
grep -q "CREATE TABLE" "$STAGE_DIR/database-mysql.sql" || fail "mysqldump output looks empty"
echo "Dump written: $(du -h "$STAGE_DIR/database-mysql.sql" | cut -f1)"
echo ""

# ── 5. Assemble + zip ────────────────────────────────────────────────────────
echo "[5/6] Assembling package..."
mkdir -p "$STAGE_DIR/laravel-backend"

tar -C "$LARAVEL_DIR" \
  --exclude './.env' \
  --exclude './.env.backup*' \
  --exclude './scripts/data/leads.json' \
  --exclude './node_modules' \
  --exclude './tests' \
  --exclude './.phpunit.result.cache' \
  --exclude './storage/logs/*.log' \
  --exclude './storage/framework/cache/data/*' \
  --exclude './storage/framework/sessions/*' \
  --exclude './storage/framework/views/*.php' \
  --exclude './bootstrap/cache/*.php' \
  -cf - . | tar -C "$STAGE_DIR/laravel-backend" -xf -

cp "$SCRIPTS_DIR/README-DEPLOY.txt" "$STAGE_DIR/README-DEPLOY.txt"

# Embed build metadata so a stale zip is identifiable after the fact, and so
# check-deploy-zip-freshness.sh can compare it against current sources.
BUILD_TIMESTAMP="$(date -u +%Y-%m-%dT%H:%M:%SZ)"
GIT_COMMIT="unknown"
GIT_DIRTY="unknown"
if git -C "$REPO_ROOT" rev-parse HEAD >/dev/null 2>&1; then
  GIT_COMMIT="$(git -C "$REPO_ROOT" rev-parse HEAD)"
  if [ -n "$(git -C "$REPO_ROOT" status --porcelain 2>/dev/null)" ]; then
    GIT_DIRTY="yes"
  else
    GIT_DIRTY="no"
  fi
fi
{
  echo ""
  echo "Build info:"
  echo "  Built at (UTC):  $BUILD_TIMESTAMP"
  echo "  Source commit:   $GIT_COMMIT"
  echo "  Dirty sources:   $GIT_DIRTY"
  echo "  Verify freshness before uploading:"
  echo "    bash laravel-backend/scripts/check-deploy-zip-freshness.sh"
} >> "$STAGE_DIR/README-DEPLOY.txt"

mkdir -p "$EXPORTS_DIR"
rm -f "$ZIP_PATH"
( cd "$STAGE_DIR" && zip -rq "$ZIP_PATH" laravel-backend database-mysql.sql README-DEPLOY.txt )
echo "Zip written: $ZIP_PATH ($(du -h "$ZIP_PATH" | cut -f1))"
echo ""

# ── 6. Verify zip contents ───────────────────────────────────────────────────
echo "[6/6] Verifying zip contents..."
LISTING="$(unzip -Z1 "$ZIP_PATH")"

# NB: use here-strings, not `echo | grep -q` — grep -q closes the pipe early,
# which kills echo with SIGPIPE and trips `set -o pipefail` spuriously.
check_present() {
  grep -Fxq "$1" <<<"$LISTING" || fail "zip verification failed: missing $1"
  echo "  ✓ present: $1"
}
check_present "database-mysql.sql"
check_present "README-DEPLOY.txt"
check_present "laravel-backend/artisan"
check_present "laravel-backend/.env.example"
check_present "laravel-backend/vendor/autoload.php"
check_present "laravel-backend/vendor/laravel/framework/composer.json"
check_present "laravel-backend/public/index.php"
check_present "laravel-backend/public/assets/app.css"
check_present "laravel-backend/public/robots.txt"

# At least one file under public/images/ must be shipped (static site assets).
if ! grep -Eq "^laravel-backend/public/images/.+[^/]$" <<<"$LISTING"; then
  fail "zip verification failed: no files under laravel-backend/public/images/"
fi
echo "  ✓ present: laravel-backend/public/images/... (at least one file)"

if grep -Fxq "laravel-backend/.env" <<<"$LISTING"; then
  fail "zip verification failed: laravel-backend/.env must NOT be in the package"
fi
echo "  ✓ absent:  laravel-backend/.env"
if grep -Fxq "laravel-backend/scripts/data/leads.json" <<<"$LISTING"; then
  fail "zip verification failed: leads.json (PII) must NOT be in the package"
fi
echo "  ✓ absent:  leads.json (PII)"
if unzip -p "$ZIP_PATH" database-mysql.sql | grep -q "^INSERT INTO \`leads\`"; then
  fail "zip verification failed: database-mysql.sql must NOT contain lead rows (PII)"
fi
echo "  ✓ absent:  lead rows in database-mysql.sql"
if grep -q "node_modules/" <<<"$LISTING"; then
  fail "zip verification failed: node_modules/ must NOT be in the package"
fi
echo "  ✓ absent:  node_modules/"
if grep -q "storage/logs/.*\.log$" <<<"$LISTING"; then
  fail "zip verification failed: log files must NOT be in the package"
fi
echo "  ✓ absent:  storage log files"
unzip -p "$ZIP_PATH" README-DEPLOY.txt | grep -q "^  Built at (UTC):" \
  || fail "zip verification failed: README-DEPLOY.txt missing build timestamp"
echo "  ✓ present: build timestamp in README-DEPLOY.txt"

echo ""
echo "======================================================="
echo "  ✓ Deployment package ready: $ZIP_PATH"
echo "======================================================="
