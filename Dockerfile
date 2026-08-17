# ---------- Frontend build ----------
FROM node:22 AS frontend

WORKDIR /var/www

COPY package*.json ./
RUN npm install

COPY resources ./resources
COPY vite.config.* ./
COPY public ./public

RUN npm run build


# ---------- Laravel / PHP ----------
FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --prefer-source

# Copy Vite's compiled assets
COPY --from=frontend /var/www/public/build ./public/build

RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache \
    /var/www/database

COPY docker/nginx.conf /etc/nginx/sites-available/default

COPY docker/ca.pem /etc/ssl/certs/aiven-ca.pem

EXPOSE 80

CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'"]