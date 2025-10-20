#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
DOC_FILE="$REPO_ROOT/docs/DEV_NOTES.md"

if [[ ! -f "$DOC_FILE" ]]; then
  echo "docs/DEV_NOTES.md is required" >&2
  exit 1
fi

BODY="${PR_BODY:-}"
if [[ -z "$BODY" ]]; then
  echo "PR body is empty; expected 'Docs updated' block" >&2
  exit 1
fi

if ! printf '%s' "$BODY" | grep -qi 'Docs updated'; then
  echo "PR body must contain 'Docs updated' block" >&2
  exit 1
fi

exit 0
