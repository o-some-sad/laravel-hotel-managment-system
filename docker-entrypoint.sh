#!/bin/bash
set -e

# Run migrations (force enabled for production)
echo "Running migrations..."
php artisan migrate --force --seed

# Start Apache in foreground
echo "Starting Apache..."
exec docker-php-entrypoint apache2-foreground
