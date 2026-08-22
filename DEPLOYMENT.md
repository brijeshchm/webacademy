# Corporate Academy — Laravel Deployment Guide

This guide covers deploying the Corporate Academy site on **BigRock Linux cPanel
shared hosting** (Apache + PHP 8.2, MySQL).

The entire site is a **single Laravel 8.2 application** — the public website, the
JSON API (`/api/*`) and the admin panel (`/admin`) are all server-rendered by
Laravel. There is **no separate React frontend to deploy**; the React app remains
in the monorepo (`artifacts/corporate-academy/`) for development history only.
Nothing on the server requires Node.js, and `vendor/` ships inside the zip so
Composer is not required on the host either.

---

## Rebuilding the deployment zip (one command)

```bash
# From the monorepo root — runs export → CSS build → composer → seed → dump → zip:
DATABASE_URL=postgres://... bash laravel-backend/scripts/build-deploy-zip.sh
# Output: exports/corporate-academy-laravel.zip
```

Prerequisites (all preinstalled in the Replit workspace): Node + pnpm, PHP 8.2,
Composer, MariaDB (`mysqld`/`mysqldump`), `zip`/`unzip`. `pnpm` is only used to
rebuild the static Tailwind stylesheet (`public/assets/app.css`) at build time —
the production server never needs it. The script fails loudly on any step and
verifies the zip before finishing (`public/index.php`, built `public/assets/app.css`
and static files present, `vendor/` present, no `.env`, no lead PII,
`database-mysql.sql` present, build timestamp embedded). Lead records are treated
as PII and are **not** included in the package.

## Quick-Start

The zip contains just three things: `laravel-backend/` (with `vendor/`),
`database-mysql.sql`, and `README-DEPLOY.txt` (non-technical upload steps).

1. Upload `laravel-backend/` to your account's **home directory** (above
   `public_html/`).
2. In cPanel → MySQL Databases, create a database + user (ALL PRIVILEGES). In
   phpMyAdmin, import `database-mysql.sql` (full schema **and** data).
3. Copy `.env.example` to `.env` and fill in DB credentials, `APP_URL`,
   `FRONTEND_URL`, `SITE_ORIGIN`, `ADMIN_PASSWORD`, `RESEND_API_KEY`,
   `NOTIFY_EMAIL`, and the `OPENAI_*` settings, then run
   `php artisan key:generate --force`.
4. Point the domain's document root at `laravel-backend/public` (or symlink
   `public_html → laravel-backend/public`; if the host forbids both, copy
   `public/*` into `public_html/` and edit the two `require` paths in
   `index.php` — see `README-DEPLOY.txt` for the exact edits).
5. `php artisan config:cache` (and optionally `route:cache`, `view:cache`).

Migrations are **not** required — the dump already carries the schema and data —
but `php artisan migrate --force` is safe/idempotent if you prefer.

### Verify

```bash
curl https://yourdomain.com/api/healthz
# Expected: {"status":"ok"}
```

---

## Architecture Overview

```
laravel-backend/          ← the entire application (uploaded to the home dir)
  app/
  bootstrap/
  config/
  database/
  resources/views/        ← Blade templates for the public site + admin panel
  public/                 ← DOCUMENT ROOT (point the domain here)
    index.php
    .htaccess
    assets/               ← compiled app.css / app.js (built at package time)
    images/  videos/      ← static media
    robots.txt  sitemap.xml  favicon.*  og images
  routes/
    web.php               ← public pages + admin panel
    api.php               ← JSON API (/api/*)
  vendor/                 ← bundled (no Composer needed on the server)
```

A single Laravel app serves everything from `public/`. Point the domain's
document root at `laravel-backend/public` (Option A below) and you are done — no
SPA proxying, no `/api` symlink, no second document root.

---

## Prerequisites

### Required PHP Extensions
Ensure these are enabled in cPanel → PHP Selector / MultiPHP INI Editor:
- `pdo_mysql`
- `mbstring`
- `openssl`
- `json`
- `curl`
- `fileinfo`
- `tokenizer`
- `xml`

### PHP Version
Select **PHP 8.2** or higher in cPanel → MultiPHP Manager.

### Composer
Composer must be available on the server. Most cPanel hosts provide it. Test with:
```bash
composer --version
```
If not available, upload `composer.phar` and run `php composer.phar`.

---

## Step-by-Step Deployment

### 1. Upload the Laravel Backend

Upload the `laravel-backend/` folder to your home directory (NOT inside `public_html/`):
```
/home/yourusername/laravel-backend/
```

### 2. Install PHP Dependencies

SSH into your server and run:
```bash
cd ~/laravel-backend
composer install --no-dev --optimize-autoloader
```

### 3. Set Up the Environment File

Copy the example and fill in your values:
```bash
cp .env.example .env
nano .env   # or use cPanel File Manager
```

**Every variable you must set:**

| Variable | Description |
|---|---|
| `APP_KEY` | Generate with `php artisan key:generate` |
| `APP_URL` | Full URL of the site, e.g. `https://yourdomain.com` |
| `DB_HOST` | MySQL host (usually `127.0.0.1` or `localhost`) |
| `DB_DATABASE` | MySQL database name (created in cPanel) |
| `DB_USERNAME` | MySQL username |
| `DB_PASSWORD` | MySQL password |
| `OPENAI_API_KEY` | Your OpenAI API key |
| `OPENAI_BASE_URL` | OpenAI base URL (default: `https://api.openai.com/v1`) |
| `OPENAI_CHAT_MODEL` | Model for chat (default: `gpt-5.4-mini`) |
| `RESEND_API_KEY` | Resend email API key |
| `NOTIFY_EMAIL` | Email that receives lead notifications |
| `SMTP_USER` | Reply-to email address |
| `ADMIN_PASSWORD` | Initial admin panel password (used until you change it from the admin panel; after that the database-managed password takes over) |
| `FRONTEND_URL` | Production frontend origin for CORS, e.g. `https://yourdomain.com` — **required** or the API will block all browser requests |
| `SITE_ORIGIN` | Public site origin used in `/api/sitemap.xml` course URLs, e.g. `https://yourdomain.com` (defaults to `https://corporateacademy.com`) |

### 4. Generate Application Key

```bash
cd ~/laravel-backend
php artisan key:generate
```

### 5. Create the MySQL Database

In cPanel → MySQL Databases:
1. Create a new database
2. Create a new user with a strong password
3. Add the user to the database with **All Privileges**
4. Update `.env` with these credentials

### 6. Run Migrations

```bash
cd ~/laravel-backend
php artisan migrate --force
```

### 7. Set Correct Permissions

```bash
cd ~/laravel-backend
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/logs
```

### 8. Point the Domain at Laravel's `public/`

The whole site is served from `laravel-backend/public/`. Choose ONE:

**Option A — Set the document root (recommended):**
In cPanel → Domains (or "Change document root"), set the domain's document root
to `laravel-backend/public`. Nothing else is required.

**Option B — Symlink `public_html` to Laravel's `public/`:**
```bash
cd ~
rm -rf public_html
ln -s laravel-backend/public public_html
```

**Option C — Host forbids both:**
Copy everything from `laravel-backend/public/` into `public_html/` (including the
hidden `.htaccess`), then edit `public_html/index.php` and change its two
`require` paths to point one extra level up into `laravel-backend/`:
```php
require __DIR__.'/../laravel-backend/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel-backend/bootstrap/app.php';
```
(This assumes `public_html/` and `laravel-backend/` share the same parent.)

The `public/.htaccess` shipped in the package already routes every request
through Laravel's front controller — no SPA rules or `/api` proxying are needed.

### 9. Cache Configuration

```bash
cd ~/laravel-backend
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Data Migration from PostgreSQL to MySQL

To migrate existing data from the PostgreSQL (Node.js) backend:

### 1. Export from PostgreSQL

On your development machine:
```bash
# From the monorepo root
DATABASE_URL=postgres://... node laravel-backend/scripts/export-pg-to-json.js
```

This creates JSON files in `laravel-backend/scripts/data/`.

The export includes `translations.json` — the pre-warmed server-side translation
cache (keyed by language + SHA-256 of the source text). Importing it means the
PHP server serves non-English catalog text instantly on first page view, with
zero repeat LLM spend for translations already purchased on Replit.

### 2. Upload JSON Files

Upload the `laravel-backend/scripts/data/` directory to the server.

### 3. Run the Seeder

```bash
cd ~/laravel-backend
php artisan db:seed --class=ImportFromJsonSeeder
```

### 4. Verify the translation cache (do this after seeding)

The seeder output must show `✓ translations: imported 13775 rows.` (the count
must match the number of objects in `scripts/data/translations.json`). Then
confirm cached languages are served instantly with **zero** OpenAI calls:

```bash
# 1. Row count per language (expect ~1,960+ rows each for hi/zh/fr/es/de/ru/ar)
php artisan tinker --execute="print_r(DB::table('translations')->selectRaw('lang, count(*) c')->groupBy('lang')->get()->toArray());"

# 2. A cached catalog string returns instantly (tens of ms, not seconds)
curl -s -X POST https://yourdomain.com/api/translate/batch \
  -H 'Content-Type: application/json' \
  -d '{"texts":["Data Science Bootcamp"],"targetLang":"hi"}'
# Expected: {"translations":["डेटा साइंस बूटकैंप"]}

# 3. No LLM calls were made for cached text
grep -i "Translation LLM" storage/logs/laravel.log   # should print nothing
```

Then open `https://yourdomain.com` in a browser, switch the site language to
Hindi or Arabic, and confirm course titles/summaries appear translated
immediately on first view.

> This exact pipeline (migrate → seed → batch endpoint) has been dry-run
> verified against a real MySQL-compatible server (MariaDB 10.11): all 13,775
> rows imported, Hindi/Arabic batch requests returned cached translations in
> 20–40 ms with zero LLM calls, and rate-limit headers were served correctly.
> If the LLM endpoint is unreachable, cache **hits** still work; only uncached
> strings return a JSON 500 error.

---

## Local Development

The site is served entirely by Laravel — start the dev server and browse it:
```bash
cd laravel-backend
php artisan serve --port=8000
# Public site, /api/* and /admin all served at http://localhost:8000
```

The React app in `artifacts/corporate-academy/` is retained for development
history only and is not part of the deployment path.

---

## CORS Configuration

The `/api/*` JSON endpoints restrict cross-origin browser access to the origin in
`FRONTEND_URL`. Set it in `.env` — **do not edit `config/cors.php` directly**:

```ini
FRONTEND_URL=https://yourdomain.com
```

If `FRONTEND_URL` is absent, the API will block all browser cross-origin requests
(fail-closed). Since the site is served same-origin by Laravel, this only affects
external API consumers.

---

## Admin Authentication

The admin panel uses session-token authentication, exactly like the original Node API:

1. `POST /api/admin/login` with `{"password": "..."}` returns `{token, expiresAt}` (sessions last 12 hours).
2. All admin requests send the token in the `x-admin-token` header (or `Authorization: Bearer <token>`).
3. `POST /api/admin/logout` revokes the token.
4. `POST /api/admin/change-password` (currentPassword + newPassword, min 8 chars) stores a bcrypt hash in the `admin_settings` table, revokes all sessions, and returns a fresh token.
5. `POST /api/admin/forgot-password` emails a 6-digit OTP (10-minute expiry, max 5 attempts, 1 email per minute) to `NOTIFY_EMAIL` via Resend; `POST /api/admin/reset-password` with `{otp, newPassword}` completes the reset.

`ADMIN_PASSWORD` in `.env` is only the *initial* password. Once you change the password from the admin panel, the database-managed (hashed) password is authoritative. If `ADMIN_PASSWORD` is unset in production and no password exists in the database, admin access fails closed.

### Verify the admin panel end-to-end after upload

Run the guided verification script (from any machine with bash + curl, or via SSH on the server):

```bash
chmod +x ~/laravel-backend/scripts/verify-admin-live.sh
~/laravel-backend/scripts/verify-admin-live.sh https://yourdomain.com/api
```

It checks, in order: API reachability, wrong-password rejection, login (prompts for the password — never stored), token enforcement on admin routes, create+delete of a test WhatsApp chat and proof, change-password (uses a temporary password and restores yours immediately, verifying old sessions are revoked), the forgot-password OTP email to `NOTIFY_EMAIL`, and optionally the OTP reset itself. Every failure prints the concrete fix (env value, `php artisan config:cache`, symlink, `.htaccess`, migrations, or Resend restrictions).

Expected result: `13 passed, 0 failed` (12 if you skip the OTP-entry step).

---

## Troubleshooting

| Issue | Fix |
|---|---|
| 500 errors | Check `storage/logs/laravel.log`; ensure `APP_DEBUG=false` in production |
| 403 on `/api` | Check symlink permissions; ensure `public/` is world-readable |
| DB connection errors | Verify `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env` |
| Large base64 uploads fail | Increase `post_max_size` and `upload_max_filesize` in cPanel PHP settings |
| CORS errors | Ensure `FRONTEND_URL=https://yourdomain.com` is set in `.env` |
| 404 on all routes | Ensure `mod_rewrite` is enabled and `.htaccess` is present in `public/` |

---


## Uptime Monitoring (Alerting)

After deploying, register the health endpoint with an uptime service so the team is alerted automatically if the API goes down.
## Uptime Status Page

The Node.js API server includes a built-in status page at:

```
https://yourdomain.com/api/status
```

It shows the current status of `/api/healthz` and `/api/courses`, uptime percentage since the server was first checked, response time, and a sparkline of the last 12 checks (≈ 1 hour at 5-minute intervals).  The page auto-refreshes every 60 seconds and requires no external services or sign-up.

A machine-readable JSON version is available at `/api/status.json`.

Bookmark this URL and share it with enterprise customers who ask "is the site down?".

---

## Uptime Monitoring (Alerting)

After deploying, register the health endpoint with an uptime service so the team is alerted automatically if the API goes down.
### Option A — GitHub Actions (recommended, zero cost, no sign-up)

The repository includes `.github/workflows/health-check.yml`, which pings `/api/healthz` and `/api/courses` every 5 minutes and emails the team if either endpoint fails.

**Alert deduplication** — the workflow only sends one email per outage, no matter how long it lasts. It tracks state in a repository variable (`HEALTH_OUTAGE_ACTIVE`): the flag is set to `true` when the first alert fires and cleared back to `false` as soon as the service recovers. This means a 2-hour outage produces exactly one alert email (at the start) and one recovery email (when the API comes back), not 24 emails.

**Set these repository secrets** (Settings → Secrets → Actions):

| Secret | Value |
|---|---|
| `PRODUCTION_URL` | Full base URL, e.g. `https://yourdomain.com` |
| `RESEND_API_KEY` | Resend API key (same as in `.env`) |
| `NOTIFY_EMAIL` | Email address to receive alerts |

The workflow also requires **write access to repository variables**. This is granted automatically via the built-in `GITHUB_TOKEN` with the `actions: write` permission declared in the workflow — no extra setup is needed.

GitHub will send alerts to the repository's notification watchers on workflow failure and will show a status badge you can embed in your README:

```markdown
![API Health](https://github.com/<org>/<repo>/actions/workflows/health-check.yml/badge.svg)
```

#### 📬 Outage and recovery emails

The workflow sends **two types of alerts**:

| Event | Subject | Condition |
|---|---|---|
| Outage detected | `🚨 API Outage Detected — Corporate Academy` | Any endpoint returns non-200 |
| Service recovered | `✅ Service Recovered — Corporate Academy` | All endpoints healthy after a previous failure |

The recovery email includes:
- The timestamp the service came back online
- When the outage started (from persisted state)
- A link to the last failed workflow run

Failure state is persisted between workflow runs using **GitHub Actions cache** (key prefix `health-state-`). If you ever need to reset the state (e.g. after a false-positive outage), go to **Actions → Caches** and delete any `health-state-*` entries.

#### ✅ How to verify the alert path end-to-end (do this before going live)

The workflow supports a built-in test mode that fires a real Resend alert without touching the production API. Run this **once** after setting the three repository secrets above.

**Via GitHub UI (easiest):**
1. Go to **Actions → API Health Check → Run workflow**
2. Set **force_failure** to `true`
3. Click **Run workflow**
4. After ~30 seconds the run will show as ❌ Failed — this is expected
5. Open the **"Send alert email via Resend"** step log and confirm it shows `HTTP 200` from Resend
6. Check `NOTIFY_EMAIL` inbox — the subject is `🚨 API Outage Detected — Corporate Academy`
7. The email body will contain a note that this is a test alert, not a real outage
8. On the next scheduled (or manual) run with healthy endpoints, a `✅ Service Recovered` email will arrive

**Via CLI (requires GitHub CLI):**
```bash
gh workflow run health-check.yml -f force_failure=true
```

**Via the standalone monitor script (no GitHub needed):**
```bash
PRODUCTION_URL=https://yourdomain.com \
RESEND_API_KEY=re_... \
NOTIFY_EMAIL=you@yourdomain.com \
FORCE_FAILURE=true \
node scripts/health-monitor.mjs
```

> **Resend note:** If your Resend account is not yet fully verified, you can only send to the email address registered with Resend. Set `NOTIFY_EMAIL` to that address for the initial test, then update it to the team inbox after your domain is verified.

#### Alert test log

| Date | Triggered by | Method | Resend response | Email received? | In spam? |
|------|-------------|--------|-----------------|-----------------|---------|
| _Run this test and fill in the row_ | | `force_failure=true` | | | |

### Option B — UptimeRobot free tier (5-minute checks, email alerts)

1. Create a free account at <https://uptimerobot.com>
2. **Add Monitor → HTTP(s)**
   - Friendly name: `Corporate Academy API`
   - URL: `https://yourdomain.com/api/healthz`
   - Monitoring interval: **5 minutes**
3. Under **Alert Contacts**, add the team email address
4. Repeat for `https://yourdomain.com/api/courses` if desired

UptimeRobot provides a public status page and shareable badge you can embed in the README.

### Option C — Server-side cron script

The repository also includes `scripts/health-monitor.mjs`, a standalone Node.js monitor with Resend email alerts and a consecutive-failure threshold (to avoid alert noise on transient blips).

```bash
# On the server — run every 5 minutes
crontab -e
# Add:
*/5 * * * * PRODUCTION_URL=https://yourdomain.com RESEND_API_KEY=re_... NOTIFY_EMAIL=team@yourdomain.com node ~/health-monitor.mjs >> /var/log/ca-health.log 2>&1
```

#### 📬 Outage and recovery emails (cron script)

The script sends **two types of alerts**:

| Event | Subject | Condition |
|---|---|---|
| Outage detected | `🚨 API Outage Detected — Corporate Academy` | Consecutive failures ≥ `FAILURE_THRESHOLD` |
| Service recovered | `✅ Service Recovered — Corporate Academy` | All endpoints healthy after a tracked outage |

The recovery email is only sent if an alert was previously dispatched (i.e. the failure crossed the threshold). Transient blips that never triggered an alert do not generate a recovery email.

Failure state (including the outage start time) is persisted in the state file (`STATE_FILE`, default `/tmp/ca-health-state.json`) between cron runs. The recovery email includes the approximate downtime duration calculated from that timestamp.

---

## Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] `ADMIN_PASSWORD` is a strong, unique password (not `admin123`)
- [ ] `CORS` restricted to your production domain
- [ ] `.env` file is NOT in `public_html/` (it's in `~/laravel-backend/`)
- [ ] `storage/` and `bootstrap/cache/` are writable by the web server
- [ ] MySQL user has minimum necessary privileges
- [ ] Uptime monitoring configured (see above) and test alert received
