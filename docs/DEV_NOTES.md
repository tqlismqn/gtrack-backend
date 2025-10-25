# G-Track Backend - Development Notes

## Setup Completed

- ✅ Laravel 11.x installed
- ✅ PostgreSQL configured as default database
- ✅ Development environment ready

## Next Steps

1. Run `composer install` to install dependencies
2. Copy `.env.example` to `.env`
3. Run `php artisan key:generate` to generate APP_KEY
4. Configure database credentials in `.env`
5. Run `php artisan migrate` to set up database schema

## Tech Stack

- **Framework:** Laravel 11.x
- **PHP:** ^8.2
- **Database:** PostgreSQL 16
- **Testing:** Pest
- **Authentication:** Sanctum (API tokens)

## Development

```bash
# Install dependencies
composer install

# Start local server
php artisan serve

# Run tests
php artisan test
```

## Database

PostgreSQL configuration:
- Connection: pgsql
- Default database: gtrack
- Port: 5432

Update `.env` with your PostgreSQL credentials before running migrations.

## API Routes

Base URL: `/api/v0`

API routes defined in `routes/api.php`.

## Documentation

Full project documentation: https://docs.g-track.eu

---

## Documentation

### Auto-Sync with gtrack-docs

Any changes to `docs/**` in this repository are automatically synced to the main documentation repository.

**Workflow:**
1. Commit changes to `docs/**` on any branch
2. Merge to `main`
3. `notify-docs-sync` workflow triggers
4. Sends webhook to `gtrack-docs` repository
5. gtrack-docs creates PR with label `automerge`
6. PR auto-merges
7. Changes appear at https://docs.g-track.eu within 2-3 minutes

**What gets synced:**
- All files from `docs/**` → `import/backend/**` in gtrack-docs

**CHANGELOG:**
- Always update `docs/CHANGELOG.md` when making significant changes
- Follow [Keep a Changelog](https://keepachangelog.com/) format
- Use semantic versioning

**Module Documentation:**
- Each module should have comprehensive docs in `docs/modules/<module>/`
- See `docs/modules/README.md` for structure requirements

### Documentation Standards

When documenting new features:

1. **Update CHANGELOG.md** with changes
2. **Create/update module docs** in `docs/modules/<module>/`
3. **Add API documentation** if new endpoints added
4. **Update DEV_NOTES.md** if dev process changes

Example commit:
```bash
git add docs/
git commit -m "docs(drivers): add database schema documentation"
git push
# Auto-sync will handle the rest!
```
