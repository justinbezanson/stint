# Stage 1: Base image with PHP 8.3 and extensions
FROM php:8.3-fpm as base

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Add this to your "base" or "development" stage
RUN mkdir -p /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/bootstrap/cache

# Fix ownership so PHP can write to its internal folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP extensions for MySQL and Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Stage 2: Development (includes Node.js for Vite/Inertia)
FROM base as development
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stage 3: Production (Optimized)
FROM base as production
COPY . .
RUN composer install --no-dev --optimize-autoloader
# Node.js only used to build assets, then discarded
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install && npm run build \
    && apt-get remove -y nodejs && apt-get autoremove -y