#!/usr/bin/env bash
# Compile Tailwind v4 CSS to a single committed static stylesheet.
# Run from anywhere; cwd is forced to laravel-backend so Tailwind v4 source
# auto-detection scans resources/views + resources/js.
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."

# Prefer pnpm dlx (works with the monorepo pnpm store); fall back to npx.
if command -v pnpm >/dev/null 2>&1; then
  pnpm dlx @tailwindcss/cli -i resources/css/app.css -o public/assets/app.css --minify
else
  npx --yes @tailwindcss/cli -i resources/css/app.css -o public/assets/app.css --minify
fi

echo "Built public/assets/app.css ($(wc -c < public/assets/app.css) bytes)"
