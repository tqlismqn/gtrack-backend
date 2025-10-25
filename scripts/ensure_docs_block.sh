#!/usr/bin/env bash
# Script to ensure PR body contains "## Docs updated" block
# Used by CI workflow: gtrack-policy-v2 / check-docs

set -e

PR_BODY_FILE="${1:-pr_body.txt}"

if [ ! -f "$PR_BODY_FILE" ]; then
    echo "Error: PR body file not found: $PR_BODY_FILE"
    exit 1
fi

# Check if PR body contains "## Docs updated" section
if grep -q "^## Docs updated" "$PR_BODY_FILE"; then
    echo "✅ PR body contains required '## Docs updated' block"
    exit 0
else
    echo "❌ PR body must contain '## Docs updated' block"
    echo ""
    echo "Example:"
    echo "## Docs updated"
    echo "- Added X"
    echo "- Updated Y"
    exit 1
fi
