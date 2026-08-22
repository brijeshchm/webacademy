#!/usr/bin/env bash
# =============================================================================
# check-deploy-zip-freshness.sh — Is the deployment zip older than the sources?
# =============================================================================
# Decides freshness from the IMMUTABLE build provenance embedded inside the
# zip's README-DEPLOY.txt (build timestamp + source commit), never from the
# zip file's mtime — a copied/downloaded/touched stale zip gets a new mtime,
# so mtime cannot be trusted.
#
# Checks, in order:
#   1. Zip exists and contains an embedded "Built at (UTC)" timestamp
#      (zips built before this scheme are treated as STALE).
#   2. If git is available and the zip records a source commit: the embedded
#      commit must match the current HEAD (mismatch => STALE). A zip built
#      from dirty sources, or a currently dirty working tree, falls through
#      to the mtime scan below.
#   3. No frontend/backend source file (including root-level build inputs:
#      package.json, pnpm-lock.yaml, pnpm-workspace.yaml, tsconfig files,
#      shared lib/ sources) is newer than the EMBEDDED build timestamp.
#
# Exits 0 (FRESH) only when all checks pass; otherwise exits 1 (STALE).
#
# Usage (from the monorepo root):
#   bash laravel-backend/scripts/check-deploy-zip-freshness.sh
#
# Env overrides (used by the self-test):
#   DEPLOY_CHECK_REPO_ROOT  root of the source tree to scan
#   DEPLOY_CHECK_ZIP_PATH   path to the zip under test
# =============================================================================

set -euo pipefail

DEFAULT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
REPO_ROOT="${DEPLOY_CHECK_REPO_ROOT:-$DEFAULT_ROOT}"
ZIP_PATH="${DEPLOY_CHECK_ZIP_PATH:-$REPO_ROOT/exports/corporate-academy-laravel.zip}"

stale() {
  echo ""
  echo "STALE: $*"
  echo "Rebuild before uploading: bash laravel-backend/scripts/build-deploy-zip.sh"
  exit 1
}

echo ""
echo "Deployment zip freshness check"
echo "------------------------------"

[ -f "$ZIP_PATH" ] || stale "zip not found at $ZIP_PATH"
command -v unzip >/dev/null 2>&1 || { echo "ERROR: unzip not available" >&2; exit 1; }

README_CONTENT="$(unzip -p "$ZIP_PATH" README-DEPLOY.txt 2>/dev/null || true)"
BUILD_TS="$(sed -n 's/^  Built at (UTC):[[:space:]]*//p' <<<"$README_CONTENT" | head -1)"
BUILD_COMMIT="$(sed -n 's/^  Source commit:[[:space:]]*//p' <<<"$README_CONTENT" | head -1)"
BUILD_DIRTY="$(sed -n 's/^  Dirty sources:[[:space:]]*//p' <<<"$README_CONTENT" | head -1)"

echo "Zip:             $ZIP_PATH"
[ -n "$BUILD_TS" ] || stale "no build timestamp embedded in README-DEPLOY.txt — zip predates the provenance scheme (or is corrupt); cannot prove freshness"

echo "Built at (UTC):  $BUILD_TS"
echo "Source commit:   ${BUILD_COMMIT:-unknown}"
echo "Dirty sources:   ${BUILD_DIRTY:-unknown}"

# Validate the timestamp is parseable before trusting it.
date -u -d "$BUILD_TS" +%s >/dev/null 2>&1 || stale "embedded build timestamp is unparseable: $BUILD_TS"

# ── Commit provenance (when both sides have git info) ────────────────────────
MTIME_SCAN_REQUIRED_REASON=""
if git -C "$REPO_ROOT" rev-parse HEAD >/dev/null 2>&1; then
  CURRENT_COMMIT="$(git -C "$REPO_ROOT" rev-parse HEAD)"
  if [ -n "$BUILD_COMMIT" ] && [ "$BUILD_COMMIT" != "unknown" ]; then
    if [ "$BUILD_COMMIT" != "$CURRENT_COMMIT" ]; then
      stale "zip was built from commit $BUILD_COMMIT but the working tree is at $CURRENT_COMMIT"
    fi
    echo "Commit check:    embedded commit matches current HEAD"
  else
    MTIME_SCAN_REQUIRED_REASON="zip does not record a source commit"
  fi
  if [ "$BUILD_DIRTY" = "yes" ]; then
    MTIME_SCAN_REQUIRED_REASON="zip was built from uncommitted (dirty) sources"
  fi
  if [ -n "$(git -C "$REPO_ROOT" status --porcelain 2>/dev/null)" ]; then
    MTIME_SCAN_REQUIRED_REASON="working tree has uncommitted changes"
  fi
else
  MTIME_SCAN_REQUIRED_REASON="git not available in the source tree"
fi
[ -n "$MTIME_SCAN_REQUIRED_REASON" ] && echo "Note:            $MTIME_SCAN_REQUIRED_REASON — relying on source-mtime scan"

# ── Source mtimes vs the EMBEDDED build timestamp ────────────────────────────
# Scan roots: everything that feeds the package, including root-level build
# inputs and shared libs. Missing paths are skipped (matters for self-test
# fixtures and future restructures).
SCAN_ROOTS=()
for p in \
  "$REPO_ROOT/artifacts/corporate-academy" \
  "$REPO_ROOT/laravel-backend" \
  "$REPO_ROOT/lib" \
  "$REPO_ROOT/package.json" \
  "$REPO_ROOT/pnpm-lock.yaml" \
  "$REPO_ROOT/pnpm-workspace.yaml" \
  "$REPO_ROOT"/tsconfig*.json; do
  [ -e "$p" ] && SCAN_ROOTS+=("$p")
done

NEWER_FILES=""
if [ "${#SCAN_ROOTS[@]}" -gt 0 ]; then
  NEWER_FILES="$(
    find "${SCAN_ROOTS[@]}" \
      \( -name node_modules -o -name dist -o -name vendor \
         -o -name storage -o -name .phpunit.result.cache \
         -o -path "$REPO_ROOT/laravel-backend/scripts/data" \) -prune \
      -o -type f -newermt "$BUILD_TS" -print 2>/dev/null | head -20
  )"
fi

if [ -n "$NEWER_FILES" ]; then
  echo ""
  echo "Source files changed after the zip was built ($BUILD_TS):"
  sed "s|^$REPO_ROOT/|  |" <<<"$NEWER_FILES"
  stale "source files are newer than the embedded build timestamp"
fi

echo ""
echo "FRESH: no source changes since the embedded build timestamp. Safe to upload."
exit 0
