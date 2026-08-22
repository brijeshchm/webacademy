#!/usr/bin/env bash
# =============================================================================
# test-deploy-zip-freshness-check.sh — Self-test for the freshness gate
# =============================================================================
# Builds tiny fixture zips + a fake source tree in /tmp and asserts that
# check-deploy-zip-freshness.sh passes/fails in the right scenarios,
# INCLUDING the trap it must not fall into: a stale zip whose file mtime was
# refreshed by copying/downloading.
#
# Usage: bash laravel-backend/scripts/test-deploy-zip-freshness-check.sh
# =============================================================================

set -euo pipefail

CHECK="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/check-deploy-zip-freshness.sh"
TMP="$(mktemp -d /tmp/freshness-test.XXXXXX)"
trap 'rm -rf "$TMP"' EXIT

PASS=0; FAIL=0

# make_zip <zip-path> <built-at> <commit> <dirty>   (omit built-at line if empty)
make_zip() {
  local zip="$1" ts="$2" commit="$3" dirty="$4" dir
  dir="$(mktemp -d "$TMP/zipsrc.XXXXXX")"
  {
    echo "Corporate Academy deployment package (test fixture)"
    echo ""
    echo "Build info:"
    [ -n "$ts" ]     && echo "  Built at (UTC):  $ts"
    [ -n "$commit" ] && echo "  Source commit:   $commit"
    [ -n "$dirty" ]  && echo "  Dirty sources:   $dirty"
  } > "$dir/README-DEPLOY.txt"
  ( cd "$dir" && zip -q "$zip" README-DEPLOY.txt )
}

# make_repo <dir> — fake source tree (no git)
make_repo() {
  mkdir -p "$1/artifacts/corporate-academy/src" "$1/laravel-backend/app" "$1/lib/db/src"
  echo '{}' > "$1/package.json"
  echo ''   > "$1/pnpm-lock.yaml"
  echo 'x'  > "$1/artifacts/corporate-academy/src/App.tsx"
  echo 'x'  > "$1/laravel-backend/app/Model.php"
  echo 'x'  > "$1/lib/db/src/index.ts"
}

# expect <name> <expected-exit> <repo> <zip>
expect() {
  local name="$1" want="$2" repo="$3" zip="$4" got=0
  DEPLOY_CHECK_REPO_ROOT="$repo" DEPLOY_CHECK_ZIP_PATH="$zip" \
    bash "$CHECK" > "$TMP/out.log" 2>&1 || got=$?
  if [ "$got" -eq "$want" ]; then
    echo "  ✓ $name"
    PASS=$((PASS+1))
  else
    echo "  ✗ $name (expected exit $want, got $got)"
    sed 's/^/      /' "$TMP/out.log"
    FAIL=$((FAIL+1))
  fi
}

PAST="$(date -u -d '2 hours ago' +%Y-%m-%dT%H:%M:%SZ)"
FUTURE_SAFE="$(date -u -d '+1 minute' +%Y-%m-%dT%H:%M:%SZ)"

echo "Freshness-gate self-test"
echo "------------------------"

# 1. FRESH: embedded timestamp newer than every source file.
R1="$TMP/repo1"; make_repo "$R1"
make_zip "$TMP/fresh.zip" "$FUTURE_SAFE" unknown unknown
expect "fresh zip passes" 0 "$R1" "$TMP/fresh.zip"

# 2. STALE despite refreshed zip mtime: embedded timestamp is old, sources
#    are newer, and the zip file itself is touched to NOW (simulates a stale
#    zip that was copied/downloaded after source changes).
R2="$TMP/repo2"; make_repo "$R2"
make_zip "$TMP/stale.zip" "$PAST" unknown unknown
touch "$TMP/stale.zip"
expect "stale zip with refreshed mtime fails" 1 "$R2" "$TMP/stale.zip"

# 3. STALE: root-level build input (pnpm-lock.yaml) changed after build.
R3="$TMP/repo3"; make_repo "$R3"
find "$R3" -type f -exec touch -d '3 hours ago' {} +
make_zip "$TMP/rootinput.zip" "$PAST" unknown unknown
touch "$R3/pnpm-lock.yaml"   # newer than $PAST
expect "changed root-level build input fails" 1 "$R3" "$TMP/rootinput.zip"

# 4. STALE: zip without embedded provenance (pre-scheme zip).
make_zip "$TMP/noprov.zip" "" "" ""
expect "zip without build timestamp fails" 1 "$R1" "$TMP/noprov.zip"

# 5. STALE: embedded commit differs from current HEAD (git repo fixture).
if command -v git >/dev/null 2>&1; then
  R5="$TMP/repo5"; make_repo "$R5"
  git -C "$R5" -c init.defaultBranch=main init -q
  git -C "$R5" -c user.email=t@t -c user.name=t add -A
  git -C "$R5" -c user.email=t@t -c user.name=t commit -qm one
  OLD_COMMIT="$(git -C "$R5" rev-parse HEAD)"
  echo 'y' >> "$R5/package.json"
  git -C "$R5" -c user.email=t@t -c user.name=t commit -qam two
  find "$R5" -type f -exec touch -d '3 hours ago' {} +
  make_zip "$TMP/mismatch.zip" "$FUTURE_SAFE" "$OLD_COMMIT" no
  expect "commit mismatch fails even with fresh timestamp" 1 "$R5" "$TMP/mismatch.zip"

  # 6. FRESH: commit matches, clean tree, clean-built zip.
  make_zip "$TMP/match.zip" "$FUTURE_SAFE" "$(git -C "$R5" rev-parse HEAD)" no
  expect "matching commit on clean tree passes" 0 "$R5" "$TMP/match.zip"
fi

echo ""
if [ "$FAIL" -gt 0 ]; then
  echo "FAILED: $FAIL test(s) failed, $PASS passed"
  exit 1
fi
echo "OK: all $PASS tests passed"
