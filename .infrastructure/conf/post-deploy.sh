#!/bin/bash

echo "🔍 Checking database state..."

# Check if drivers table has data
DRIVER_COUNT=$(php artisan tinker --execute="echo App\\Models\\Driver::count();")

echo "📊 Current drivers count: $DRIVER_COUNT"

if [ "$DRIVER_COUNT" -eq "0" ]; then
    echo "⚠️  No drivers found! Running seeder..."
    php artisan db:seed --force --class=DriversTableSeeder
    
    # Verify again
    DRIVER_COUNT=$(php artisan tinker --execute="echo App\\Models\\Driver::count();")
    echo "📊 Drivers after seeding: $DRIVER_COUNT"
else
    echo "✅ Drivers already exist"
fi
