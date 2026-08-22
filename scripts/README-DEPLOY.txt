Corporate Academy — BigRock cPanel deployment package
=====================================================

This is a SINGLE Laravel 8.2 application. The entire site — public pages, the
JSON API (/api/*) and the admin panel (/admin) — is server-rendered by Laravel.
There is NO separate React build to upload and NOTHING on the server needs
Node.js. Composer is NOT required either: vendor/ is already INCLUDED.

Contents:
  laravel-backend/    The whole application. vendor/ is bundled. Its public/
                      folder is the web document root and already contains all
                      static assets (compiled CSS/JS, images, videos, favicon,
                      robots.txt, sitemap.xml, og images).
  database-mysql.sql  MySQL/MariaDB dump — import directly via phpMyAdmin.
                      Contains all tables + data: categories, courses,
                      testimonials, proofs, whatsapp_chats, video_stories,
                      translations (pre-translated strings), admin_settings,
                      admin_sessions. The leads table is included EMPTY —
                      lead records are PII and are migrated separately.


Non-technical upload steps (cPanel)
-----------------------------------
1. Upload the laravel-backend/ folder to your account's HOME directory (the
   folder ABOVE public_html, e.g. /home/youruser/laravel-backend). Use the
   cPanel File Manager "Upload" button or drag the folder in over SFTP.

2. Import the database:
   - cPanel → MySQL Databases: create a new database and a user, add the user
     to the database with ALL PRIVILEGES. Note the DB name, user and password.
   - cPanel → phpMyAdmin: select the new database → Import tab → choose
     database-mysql.sql → Go. This loads all tables and data.

3. Create the environment file:
   - In cPanel File Manager, open laravel-backend/, copy .env.example to a new
     file named .env (Copy, then rename the copy to ".env").
   - Edit .env and fill in: DB_DATABASE, DB_USERNAME, DB_PASSWORD (from step 2),
     APP_URL (https://yourdomain.com), FRONTEND_URL (https://yourdomain.com),
     SITE_ORIGIN (https://yourdomain.com), ADMIN_PASSWORD, RESEND_API_KEY,
     NOTIFY_EMAIL, and the OPENAI_* settings.

4. Generate the application key. In cPanel → Terminal (or SSH):
       cd ~/laravel-backend
       php artisan key:generate --force
   (If your host has no terminal, generate a key elsewhere with the same
   command and paste it into APP_KEY= in .env — format: base64:....)

5. Migrations are NOT required — database-mysql.sql already contains the full
   schema AND data. Running them anyway is safe/idempotent if you prefer:
       php artisan migrate --force

6. Point the domain at Laravel's public/ folder. Pick ONE:

   Option A (best) — set the document root:
     In cPanel → Domains (or "Change document root"), set your domain's
     document root to laravel-backend/public. Done — the whole site is served.

   Option B — symlink public_html to Laravel's public/:
     Remove or rename the default public_html, then (cPanel → Terminal/SSH):
         cd ~
         rm -rf public_html
         ln -s laravel-backend/public public_html

   Option C — if the host FORBIDS changing the document root and symlinks:
     Copy everything from laravel-backend/public/ INTO public_html/ (including
     the hidden .htaccess), then edit public_html/index.php and change its two
     require paths so they point up one extra level into laravel-backend/:
         Change:  require __DIR__.'/../vendor/autoload.php';
         To:      require __DIR__.'/../laravel-backend/vendor/autoload.php';

         Change:  $app = require_once __DIR__.'/../bootstrap/app.php';
         To:      $app = require_once __DIR__.'/../laravel-backend/bootstrap/app.php';
     (This assumes public_html/ and laravel-backend/ share the same parent
     directory, which they do after step 1.)

7. Cache the configuration for speed (cPanel → Terminal/SSH):
       cd ~/laravel-backend
       php artisan config:cache
       php artisan route:cache
       php artisan view:cache

Done. Open https://yourdomain.com — the public site, the /api/* endpoints and
the /admin panel are all served by this one Laravel app.


Admin panel:
  Log in at /admin with your ADMIN_PASSWORD. The panel uses secure session
  tokens (12-hour expiry), change-password, and email OTP password reset. After
  you change the password in the panel, the database-managed password takes
  over. ADMIN_PASSWORD in .env is only the initial password.

Nothing on the server requires Node.js.

(A "Build info" section with the build timestamp and source commit is
appended below by build-deploy-zip.sh when the zip is packaged.)
