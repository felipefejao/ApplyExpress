# Claude Instructions

This file contains instructions specifically for Claude-based agents.

<!-- ai-harness:start -->
# AI Harness

This project uses mrkoopie/laravel-ai-harness to keep Claude Code guidance, hooks, and skills aligned with the local Laravel development harness.

## Runtime

- Use Herd on macOS when available.
- Use Sail/Docker when a Sail stack is active.
- Fall back to bare PHP only when the environment already provides the required PHP runtime.

## Worktrees

Fetch origin/main before creating worktrees, then start new worktrees from origin/main unless the project explicitly overrides that policy.

Run tests through `.dev/bin/ai-harness test` in managed worktrees so the generated local PHPUnit config applies. It runs Pest in parallel by default when the runner supports it; set `AI_HARNESS_PARALLEL=0` to force a sequential run.

Keep custom Claude-specific notes outside this managed block; this block is refreshed by `php artisan ai-harness:update`.
<!-- ai-harness:end -->
