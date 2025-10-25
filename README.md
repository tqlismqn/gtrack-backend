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

## Database Management

### Reset Demo Data

**Via Laravel Cloud Terminal:**

```bash
# SSH into Laravel Cloud
# (Use Laravel Cloud dashboard terminal)

# Reset and seed database
php artisan demo:reset

# Or manually:
php artisan migrate:fresh --force
php artisan db:seed --force

# Verify data
php artisan tinker
>>> App\Models\Driver::count()
>>> # Should return 25
```

### Check Database Stats

**API Endpoint:**

```
GET https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/stats
```

**Response:**

```json
{
  "drivers": 25,
  "documents": 225,
  "files": 0,
  "comments": 0,
  "users": 1
}
```

### Health Check

```
GET https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/health
```

**Response:**

```json
{
  "status": "ok",
  "version": "0.1.0",
  "database": "connected",
  "drivers_count": 25,
  "timestamp": "2025-10-25T17:00:00Z"
}
```

---

## [Important: Manual Step After Deployment]

After this PR is merged and deployed, you need to **manually trigger database reset** via Laravel Cloud dashboard:

**Steps:**

1. **Open Laravel Cloud Dashboard:**
```
https://cloud.laravel.com/projects/gtrack-backend
```
2. **Go to Terminal/Console**

3. **Run command:**
```bash
php artisan demo:reset
```

Or:

```bash
php artisan migrate:fresh --force
php artisan db:seed --force
```

4. **Verify:**
   
   ```bash
   php artisan tinker
   >>> App\Models\Driver::count()
   >>> exit
   ```
   
   Should show: **25**
5. **Test API:**
   
   ```
   https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/drivers
   ```
   
   Should return 25 drivers ✅

---

## [Testing After Deployment]

### 1. Check Stats Endpoint

```bash
curl https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/stats

# Should show:
# {"drivers":25,"documents":225,...}
```

### 2. Check Health Endpoint

```bash
curl https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/health

# Should show:
# {"status":"ok","drivers_count":25,...}
```

### 3. Check Drivers Endpoint

```bash
curl https://gtrack-backend-gtrack-backend-lnf9mi.laravel.cloud/api/v0/drivers

# Should return array with 25 drivers
```

### 4. Check Frontend

```
https://app.g-track.eu/drivers
```

Should show:

- ✅ Table with 25 drivers
- ✅ Document status indicators
- ✅ Split layout with details
