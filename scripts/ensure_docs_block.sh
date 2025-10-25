#!/usr/bin/env bash
# Script to ensure PR body contains "## Docs updated" block
# Used by CI workflow: gtrack-policy-v2 / guard-readme

set -e

# GitHub Actions provides PR body via environment variable
PR_BODY="${PR_BODY:-}"

if [ -z "$PR_BODY" ]; then
    echo "Error: PR_BODY environment variable is not set"
    echo "This script should be called from GitHub Actions workflow"
    exit 1
fi

# Check if PR body contains "## Docs updated" section
if echo "$PR_BODY" | grep -q "^## Docs updated"; then
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
