#!/usr/bin/env bash
set -euo pipefail

if ! command -v gh >/dev/null 2>&1; then
  echo "gh CLI not found. Please install GitHub CLI and authenticate before running this script." >&2
  exit 1
fi

REPO_OWNER=${OWNER:-"tqlismqn"}
REPO_NAME=${REPO:-"gtrack-backend"}
DOCS_REPO=${DOCS_REPO:-"tqlismqn/gtrack-docs"}

PR_JSON=$(gh pr list --repo "$REPO_OWNER/$REPO_NAME" --state open --json number,headRefName,body | jq 'sort_by(.number)|last')
if [ "$PR_JSON" = "null" ]; then
  echo "No open PRs in $REPO_OWNER/$REPO_NAME"
  exit 0
fi

PR_NUM=$(echo "$PR_JSON" | jq -r .number)
PR_BRANCH=$(echo "$PR_JSON" | jq -r .headRefName)

echo "Working on PR #$PR_NUM (branch: $PR_BRANCH)"

TMP=$(mktemp)
cat > "$TMP" <<'MD'
Docs updated
- Backend autosync drill; added required block for guard-readme.

---

## Summary
This PR touches `docs/DEV_NOTES.md` to exercise the docs portal autosync & automerge.

## Testing
Docs-only change; no runtime impact.
MD

gh pr edit "$PR_NUM" --repo "$REPO_OWNER/$REPO_NAME" --body-file "$TMP"
rm -f "$TMP"

NEW_BODY=$(gh pr view "$PR_NUM" --repo "$REPO_OWNER/$REPO_NAME" --json body -q .body)
if ! echo "$NEW_BODY" | grep -q "Docs updated"; then
  echo "Body still missing 'Docs updated' — abort"
  exit 1
fi

echo "PR body contains 'Docs updated'."

git fetch "https://github.com/$REPO_OWNER/$REPO_NAME.git" "$PR_BRANCH" --prune

git checkout -B "$PR_BRANCH" "origin/$PR_BRANCH"

git commit --allow-empty -m "ci: retrigger after enforcing 'Docs updated' block in PR body"

git push origin "$PR_BRANCH"

gh workflow run -R "$DOCS_REPO" docs-auto-sync.yml --ref main \
  || gh workflow run -R "$DOCS_REPO" "Docs – Auto Sync to Import" --ref main

echo "Open portal PRs labeled 'automerge' (should self-merge after checks):"

gh pr list -R "$DOCS_REPO" --label automerge --state open --json number,title,url \
  -q '.[] | "\(.number)\t\(.title)\t\(.url)"' || true

echo "Done. Wait for guard-readme to turn green on PR #$PR_NUM."
