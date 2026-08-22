# Blade Frontend Port — Conventions (Task: remove React, serve site from Laravel)

Goal: the public website + admin panel are server-rendered Blade pages served by
this Laravel app, styled with Tailwind CSS compiled to ONE static stylesheet.
No Node.js on the production server. Visual design must match the existing React
app (artifacts/corporate-academy) exactly — same colors, fonts, spacing, layout.

## Layout & views
- `resources/views/layouts/app.blade.php` — public layout: `<html lang dir>`, meta/SEO section (`@stack('seo')`), fonts, `/assets/app.css`, navbar, `{{ $slot }}`/`@yield('content')`, footer, floating chat widget + floating contacts + small vanilla JS at end of body (`/assets/app.js`).
- Pages live in `resources/views/pages/<name>.blade.php`; partials in `resources/views/partials/`; components in `resources/views/components/` (anonymous Blade components).
- Admin views in `resources/views/admin/`.
- Web routes in `routes/web.php` (names: `home`, `courses`, `courses.show`, `categories`, `categories.show`, `about`, `contact`, `enquiry`, `scholarship`, `corporate-training`, `doctorate`, `doctorate.show`, `universities.show`, `admin.*`). 404 via custom `resources/views/errors/404.blade.php`.
- Route paths mirror the React router exactly: `/`, `/courses`, `/courses/{slug}`, `/categories`, `/categories/{slug}`, `/about`, `/contact`, `/enquiry`, `/scholarship`, `/corporate-training`, `/doctorate`, `/doctorate/{slug}`, `/universities/{slug}`, `/admin`.

## Design tokens / CSS
- Tailwind v4 source: `resources/css/app.css` — ported from `artifacts/corporate-academy/src/index.css` (same `@theme`, `:root` HSL variables, elevate system, ca-* animations, reduced-motion block). Fonts: Outfit (display) + Plus Jakarta Sans (sans) via Google Fonts link tag.
- Build: `bash scripts/build-css.sh` runs `npx @tailwindcss/cli -i resources/css/app.css -o public/assets/app.css --minify` scanning `resources/views/**/*.blade.php` and `resources/js/**/*.js` (Tailwind v4 auto-detects sources from cwd `laravel-backend/`). The compiled `public/assets/app.css` IS COMMITTED so the server needs no Node.
- Use the same utility classes as the React components (copy class strings when porting JSX → Blade). `class=` instead of `className=`, self-close tags removed, `{...}` → Blade `{{ }}`.

## i18n (8 locales: en hi zh fr es de ru ar)
- Locale JSONs copied verbatim from `artifacts/corporate-academy/src/i18n/locales/*.json` into `lang/i18n/<code>.json` (nested i18next format).
- Helper `t(string $key, array $replace = [])` (global helper in `app/Support/helpers.php`, autoloaded via composer files) — resolves nested dot keys from the active locale JSON with English fallback; `{{name}}` placeholder interpolation like i18next.
- Locale selection: `SetLocale` middleware — priority `?lng=` query param → `lng` cookie → default `en`. When `?lng=` present, set the cookie (1 year). Store active code in `app()->getLocale()`.
- Language switcher: links/dropdown that append `?lng=<code>` to the current URL (server round-trip; no JS required, JS enhancement optional).
- RTL: layout sets `dir="rtl"` on `<html>` when locale is `ar`; keep the React app's `rtl:` Tailwind utilities when porting classes.
- Dynamic DB text (course titles/summaries/etc.): `App\Services\ServerTranslator::translate(?string $text): ?string` and `translateMany(array $texts): array` — for non-English locale, look up the `translations` table by `(lang, sha256(text))` (same scheme as TranslateController). CACHE-ONLY at page render: on miss return the English original (never call the LLM during a page render). English locale returns input unchanged.
- FAQs/static arrays that the React app translated via the API: also run through `ServerTranslator` (cache is pre-warmed with them).

## Data access
- Controllers in `app/Http/Controllers/Web/` namespace; reuse existing Eloquent models (Course, Category, Testimonial, Proof, WhatsappChat, VideoStory) — read-only queries mirroring the API controllers' shapes (e.g. course search: same LIKE filters as CourseController@index).
- Static data (doctorate cards/programmes, partner universities, FAQs) ported from `artifacts/corporate-academy/src/data/*.ts` and `src/lib/universities.ts` to PHP arrays in `app/Data/` (e.g. `DoctorateProgrammes.php`, `PartnerUniversities.php`, `Faqs.php`) — content verbatim, English source; render through `ServerTranslator` for non-English.

## Forms & JS
- Lead/enquiry/contact forms: standard HTML forms POSTing to web routes that call the same validation/notification logic as `LeadController@store` (reuse the controller/service, then redirect back with a success flash). Include a JS-enhanced path optional; must work without JS.
- CSRF: use `@csrf` on web forms (web middleware group). The existing `/api/*` routes are untouched.
- `resources/js/app.js` → copied to `public/assets/app.js` (plain vanilla JS, no build): mobile menu toggle, FAQ/curriculum accordions (or use native `<details>`), chat widget (POST `/api/chat` JSON `{message, history?}` — match ChatController contract), course search autocomplete on Home (fetch `/api/courses?search=`), language dropdown, scroll animations optional.
- Keep JS tiny and dependency-free.

## SEO
- Every page pushes to `@stack('seo')`: title (`... | Corporate Academy`), meta description, canonical (config('services.site.origin') + path), OG/Twitter tags (og:image `/api/og-image`), JSON-LD script(s) mirroring PageSEO.tsx builders (Organization, WebSite+SearchAction on home, Course + BreadcrumbList on course detail, FAQPage where the React page had one, ItemList on listings).
- robots.txt / llms.txt / sitemap.xml: served as static files from `public/` (copied from the React `public/`), pointing at the same URLs. Pages render full content server-side — crawlable without JS by construction.

## Admin
- Server-rendered admin at `/admin` using session (Laravel session) storing the admin token obtained from `AdminAuth` service (call the service directly, not HTTP). Login form → AdminAuth::login; middleware `AdminWebAuth` checks session token validity via AdminAuth. CRUD forms POST to web admin routes that reuse existing controllers' logic or call models directly with the same validation rules. Include change/forgot/reset password pages mirroring the API flows.

## Testing
- Feature tests in `tests/Feature/Web/` — every public route returns 200 (seeded sqlite), `?lng=ar` renders `dir="rtl"`, course search filters, lead form stores + redirects, admin login flow works.
