# Stage 1: Build Frontend Assets
FROM node:20 AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Serve with PHP/Apache
FROM php:8.2-apache

# Install System Dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql bcmath zip

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Set Document Root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set Working Directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Project Files
COPY . .

# Copy Frontend Assets
COPY --from=frontend /app/public/build public/build

# Install PHP Dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose Port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
