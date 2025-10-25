# G-Track Backend

Transport Management System (TMS) - Backend API

## About G-Track

G-Track is a modern SaaS platform for transport logistics management, built with Laravel 11 and PostgreSQL.

## Tech Stack

- **Framework:** Laravel 11
- **Database:** PostgreSQL 16
- **Authentication:** Auth0 (RS256)
- **API:** RESTful API (v0)
- **Testing:** Pest

## Installation

```bash
# Clone repository
git clone https://github.com/tqlismqn/gtrack-backend.git
cd gtrack-backend

# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed
```

## Development

```bash
# Start local server
php artisan serve

# Run tests
php artisan test

# Code formatting
./vendor/bin/pint
```

## Environment Configuration

Key environment variables:

```env
DB_CONNECTION=pgsql
DB_HOST=your-database-host
DB_PORT=5432
DB_DATABASE=gtrack
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

## API Documentation

API base URL: `/api/v0`

Full documentation: https://docs.g-track.eu

## Deployment

- **Production:** Laravel Cloud
- **URL:** https://gtrack-backend.laravel.cloud

## License

Proprietary - G-Track TMS
