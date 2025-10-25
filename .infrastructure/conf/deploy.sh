#!/bin/bash

# Deploy script for Laravel Cloud

echo "🚀 Starting deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate --force

# Seed database (with fresh data)
php artisan db:seed --force --class=DriversTableSeeder

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
