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
