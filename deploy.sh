#!/usr/bin/env bash
set -e 

echo "Running Deployment Script..."

# 1. Install PHP dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Install Node dependencies and Build Assets
echo "Building Frontend Assets..."
npm install
npm run build

# 3. Cache Configuration (Optional here, can also be done in start command, but good for build artifact)
echo "Caching Configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build Configuration Complete!"
