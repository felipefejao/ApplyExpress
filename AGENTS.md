# AI Agent Instructions

This file contains project-specific instructions for AI agents (like Cascade, Claude Code, and Codex).

<!-- ai-harness:start -->
# AI Harness

This project uses mrkoopie/laravel-ai-harness to keep agent instructions, MCP config, workspace hooks, and quality guidance fresh.

## Project Context

- App: ApplyExpress
- PHP target: 8.2
- Default worktree base: origin/main
- Worktree setup: fetch origin/main before creating a new worktree.

## Agent Rules

- Prefer Laravel conventions and existing project patterns.
- Use the generated skills before editing matching domains.
- In managed worktrees, run tests through `.dev/bin/ai-harness test` so the generated local PHPUnit config applies. It runs Pest in parallel by default when the runner supports it; set `AI_HARNESS_PARALLEL=0` to force a sequential run.
- Run the smallest relevant tests before reporting work complete.
- Keep custom project rules outside this managed block; this block is refreshed by `php artisan ai-harness:update`.
<!-- ai-harness:end -->

## Custom Project Rules

- **Testing**: Always create tests for implemented functionalities.
- **Demo Data**: Always create seeders/demo data to populate new functionalities.
- **Tech Stack**:
    - Framework: Laravel 11
    - Admin Panel: Filament 3
    - Automation: Console commands for batch processing (emails).
    - Business Model: Subscription-based with credit transactions.
