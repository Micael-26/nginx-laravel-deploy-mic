# Étape 1 : Builder les assets frontend (Node.js)
FROM node:18 AS frontend-builder

WORKDIR /var/www
COPY package.json vite.config.js tailwind.config.js ./
COPY resources ./resources

# Génère les fichiers dans /var/www/public/build
RUN npm install && npm run build

# Étape 2 : Builder les dépendances PHP (Composer)
FROM composer:2 AS composer-builder

WORKDIR /var/www
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Étape 3 : Image finale (PHP-FPM + Nginx)
FROM php:8.3-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential libpq-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    locales zip jpegoptim optipng pngquant gifsicle vim unzip git curl \
    libonig-dev libxml2-dev libzip-dev nginx supervisor \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Copie les artefacts des étapes précédentes
WORKDIR /var/www
COPY --from=composer-builder /var/www/vendor ./vendor
COPY --from=frontend-builder /var/www/public/build ./public/build
COPY . .

# Permissions (sécurité)
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 storage bootstrap/cache \
    && chgrp -R www-data storage bootstrap/cache

# Configuration Nginx + Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
