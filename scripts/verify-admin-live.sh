#!/usr/bin/env bash
# End-to-end verification of the admin panel API on the LIVE server.
#
# Usage:
#   ./verify-admin-live.sh https://yourdomain.com/api
#
# It will prompt for the admin password (never echoed, never stored).
# Safe to run on production: it creates one test WhatsApp chat + one test
# proof and deletes them again; change-password is verified by changing to a
# temporary password and immediately changing back.
#
# Requires: bash, curl. (python3 or php used for JSON parsing if available;
# falls back to sed.)
set -u

BASE="${1:-}"
if [ -z "$BASE" ]; then
  echo "Usage: $0 https://yourdomain.com/api" >&2
  exit 2
fi
BASE="${BASE%/}"

PASS_COUNT=0
FAIL_COUNT=0

pass() { PASS_COUNT=$((PASS_COUNT+1)); printf '  \033[32mPASS\033[0m %s\n' "$1"; }
fail() { FAIL_COUNT=$((FAIL_COUNT+1)); printf '  \033[31mFAIL\033[0m %s\n' "$1"; [ -n "${2:-}" ] && printf '       fix: %s\n' "$2"; }
info() { printf '  ....  %s\n' "$1"; }

# --- JSON field extractor (token/id are simple scalar fields) -------------
json_get() { # $1=json $2=field
  if command -v python3 >/dev/null 2>&1; then
    printf '%s' "$1" | python3 -c "import sys,json;d=json.load(sys.stdin);print(d.get('$2',''))" 2>/dev/null
  elif command -v php >/dev/null 2>&1; then
    printf '%s' "$1" | php -r "\$d=json_decode(stream_get_contents(STDIN),true);echo \$d['$2']??'';" 2>/dev/null
  else
    printf '%s' "$1" | sed -n "s/.*\"$2\":\"\{0,1\}\([^\",}]*\)\"\{0,1\}.*/\1/p" | head -1
  fi
}

req() { # $1=method $2=path $3=data(optional) $4=token(optional)
  local m="$1" p="$2" d="${3:-}" t="${4:-}" args=()
  args=(-s -o /tmp/vadmin_body -w '%{http_code}' -X "$m" "$BASE$p" -H 'Content-Type: application/json')
  [ -n "$t" ] && args+=(-H "x-admin-token: $t")
  [ -n "$d" ] && args+=(-d "$d")
  HTTP_CODE=$(curl "${args[@]}" 2>/tmp/vadmin_err) || HTTP_CODE=000
  BODY=$(cat /tmp/vadmin_body 2>/dev/null || true)
}

echo "== Corporate Academy admin live verification =="
echo "   Target: $BASE"
echo

# 0. Health -----------------------------------------------------------------
echo "[0] API reachability"
req GET /healthz
if [ "$HTTP_CODE" = "200" ]; then
  pass "GET /healthz -> 200"
else
  fail "GET /healthz -> $HTTP_CODE" "Check the public_html/api symlink, public/.htaccess (mod_rewrite), and that PHP 8.2+ is selected. Body: $(echo "$BODY" | head -c 200)"
  echo; echo "API is unreachable — aborting remaining checks."; exit 1
fi

# 1. Login ------------------------------------------------------------------
echo "[1] Login"
req POST /admin/login '{"password":"definitely-not-the-password-123"}'
if [ "$HTTP_CODE" = "401" ]; then
  pass "wrong password rejected (401)"
else
  fail "wrong password -> $HTTP_CODE (expected 401)" "If 500: check storage/logs/laravel.log and DB_* values in .env. If 503: ADMIN_PASSWORD missing and no DB password — set ADMIN_PASSWORD in .env then 'php artisan config:cache'."
fi

printf 'Enter the admin password: '
read -rs ADMIN_PW; echo
req POST /admin/login "{\"password\":$(printf '%s' "$ADMIN_PW" | sed 's/\\/\\\\/g; s/"/\\"/g; s/^/"/; s/$/"/')}"
TOKEN=$(json_get "$BODY" token)
if [ "$HTTP_CODE" = "200" ] && [ -n "$TOKEN" ]; then
  pass "login returned a session token"
else
  fail "login -> $HTTP_CODE" "401: wrong password (remember .env ADMIN_PASSWORD only applies until a DB password exists; after config changes run 'php artisan config:cache'). 500: check laravel.log for DB errors — admin_sessions table needs 'php artisan migrate --force'."
  echo; echo "Cannot continue without a token."; exit 1
fi

# 2. Token gate --------------------------------------------------------------
echo "[2] Token enforcement"
req POST /whatsapp-chats '{"imageData":"data:image/png;base64,x","caption":"x"}'
[ "$HTTP_CODE" = "401" ] && pass "admin route without token rejected (401)" \
  || fail "no-token request -> $HTTP_CODE (expected 401)" "Admin middleware not applied — check routes/api.php and that config/route caches were rebuilt (php artisan route:cache)."

# 3. CRUD: WhatsApp chat ------------------------------------------------------
echo "[3] Admin CRUD (WhatsApp chat)"
PNG='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='
req POST /whatsapp-chats "{\"imageData\":\"$PNG\",\"caption\":\"[verify-script] delete me\"}" "$TOKEN"
CHAT_ID=$(json_get "$BODY" id)
if [ "$HTTP_CODE" = "201" ] && [ -n "$CHAT_ID" ]; then
  pass "created test chat (id=$CHAT_ID)"
  req DELETE "/whatsapp-chats/$CHAT_ID" '' "$TOKEN"
  [ "$HTTP_CODE" = "204" ] && pass "deleted test chat" || fail "delete -> $HTTP_CODE" "Check laravel.log."
else
  fail "create chat -> $HTTP_CODE" "413/400 on large bodies: raise post_max_size & upload_max_filesize in cPanel PHP settings. 500: run 'php artisan migrate --force'. Body: $(echo "$BODY" | head -c 200)"
fi

# 4. CRUD: Proof --------------------------------------------------------------
echo "[4] Admin CRUD (proof)"
req POST /proofs "{\"imageData\":\"$PNG\",\"caption\":\"[verify-script] delete me\",\"proofDate\":\"2026-01-01\"}" "$TOKEN"
PROOF_ID=$(json_get "$BODY" id)
if [ "$HTTP_CODE" = "201" ] && [ -n "$PROOF_ID" ]; then
  pass "created test proof (id=$PROOF_ID)"
  req DELETE "/proofs/$PROOF_ID" '' "$TOKEN"
  [ "$HTTP_CODE" = "204" ] && pass "deleted test proof" || fail "delete -> $HTTP_CODE" "Check laravel.log."
else
  fail "create proof -> $HTTP_CODE — body: $(echo "$BODY" | head -c 200)"
fi

# 5. Change password (round trip) ---------------------------------------------
echo "[5] Change password (temporary, restored immediately)"
TMP_PW="Vrfy-$(date +%s)-Tmp1"
OLD_TOKEN="$TOKEN"
req POST /admin/change-password "{\"currentPassword\":$(printf '%s' "$ADMIN_PW" | sed 's/\\/\\\\/g; s/"/\\"/g; s/^/"/; s/$/"/'),\"newPassword\":\"$TMP_PW\"}" "$TOKEN"
NEW_TOKEN=$(json_get "$BODY" token)
if [ "$HTTP_CODE" = "200" ] && [ -n "$NEW_TOKEN" ]; then
  pass "password changed, fresh token issued"
  # old token must now be dead
  req GET /whatsapp-chats '' "$OLD_TOKEN"   # GET is public; use a write instead
  req POST /whatsapp-chats "{\"imageData\":\"$PNG\"}" "$OLD_TOKEN"
  [ "$HTTP_CODE" = "401" ] && pass "old session revoked after password change" \
    || fail "old token still works ($HTTP_CODE)" "revokeAllSessions not effective — check admin_sessions table exists and laravel.log."
  # change back
  req POST /admin/change-password "{\"currentPassword\":\"$TMP_PW\",\"newPassword\":$(printf '%s' "$ADMIN_PW" | sed 's/\\/\\\\/g; s/"/\\"/g; s/^/"/; s/$/"/')}" "$NEW_TOKEN"
  RESTORED_TOKEN=$(json_get "$BODY" token)
  if [ "$HTTP_CODE" = "200" ] && [ -n "$RESTORED_TOKEN" ]; then
    pass "original password restored"
    TOKEN="$RESTORED_TOKEN"
  else
    fail "COULD NOT RESTORE ORIGINAL PASSWORD ($HTTP_CODE)" "Your admin password is currently: $TMP_PW — log in and change it back manually NOW."
    TOKEN="$NEW_TOKEN"
  fi
else
  fail "change-password -> $HTTP_CODE — body: $(echo "$BODY" | head -c 200)"
fi

# 6. Forgot password (OTP email) ------------------------------------------------
echo "[6] Forgot password (OTP email via Resend)"
req POST /admin/forgot-password
case "$HTTP_CODE" in
  200) pass "OTP email dispatched — CHECK the NOTIFY_EMAIL inbox for the 6-digit code";;
  429) info "rate-limited (an OTP was sent within the last minute) — wait 60s and re-run this step";;
  502) fail "OTP email failed to send (502)" "Check RESEND_API_KEY & NOTIFY_EMAIL in .env (then php artisan config:cache). Note: unverified Resend accounts can only send to the Resend account owner's address. See laravel.log for the Resend error.";;
  503) fail "admin password not configured (503)" "Set ADMIN_PASSWORD in .env and run php artisan config:cache.";;
  *)   fail "forgot-password -> $HTTP_CODE — body: $(echo "$BODY" | head -c 200)";;
esac

if [ "$HTTP_CODE" = "200" ]; then
  printf 'Enter the 6-digit OTP from the email (or press Enter to skip reset test): '
  read -r OTP
  if [ -n "$OTP" ]; then
    req POST /admin/reset-password "{\"otp\":\"$OTP\",\"newPassword\":$(printf '%s' "$ADMIN_PW" | sed 's/\\/\\\\/g; s/"/\\"/g; s/^/"/; s/$/"/')}"
    if [ "$HTTP_CODE" = "200" ]; then
      pass "OTP reset completed (password unchanged — reset to the same password)"
      info "all sessions were revoked by the reset — log in again in the admin panel"
    else
      fail "reset-password -> $HTTP_CODE — body: $(echo "$BODY" | head -c 200)" "401 = wrong OTP; 400 = expired; 429 = too many attempts (request a new OTP)."
    fi
  else
    info "OTP reset test skipped"
  fi
fi

# 7. Logout ---------------------------------------------------------------------
echo "[7] Logout"
req POST /admin/logout '' "$TOKEN"
[ "$HTTP_CODE" = "200" ] && pass "logout ok" || info "logout -> $HTTP_CODE (token may already be revoked by the OTP reset — fine)"

echo
echo "== Result: $PASS_COUNT passed, $FAIL_COUNT failed =="
[ "$FAIL_COUNT" -eq 0 ] && echo "Admin panel verified end-to-end on the live server. ✔"
exit $([ "$FAIL_COUNT" -eq 0 ] && echo 0 || echo 1)
