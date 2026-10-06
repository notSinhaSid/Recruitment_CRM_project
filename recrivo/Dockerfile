# Recrivo — Dockerfile for Render deployment
# Place this file at: recrivo/Dockerfile  (same level as artisan, composer.json)

# ---- Stage 1: build frontend assets (Tailwind/Vite) ----
FROM node:20-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# ---- Stage 2: PHP app ----
FROM php:8.3-cli

# System dependencies + PHP extensions Laravel/MySQL need
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first (layer caching — faster rebuilds when only code changes)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy the rest of the application
COPY . .

# Bring in compiled frontend assets from the Node stage
COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --optimize

# Laravel needs these writable
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Render injects $PORT at runtime — Laravel's built-in server binds to it.
# Migrations run on every boot; safe for `migrate` (idempotent), matches your Railway setup.
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
