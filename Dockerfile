# Étape 1 : Builder les assets frontend (Node.js)
FROM node:20 as node

WORKDIR /var/www/html
COPY package.json vite.config.js ./ 
COPY resources ./resources

RUN npm install && npm run build

# Étape 2 : Builder PHP et installer les dépendances
FROM php:8.4-fpm as php

WORKDIR /var/www/html

# Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libwebp-dev \
    libjpeg-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        gd \
        zip \
        opcache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers du projet (sauf node_modules, etc.)
COPY . . 
COPY --from=node /var/www/html/public/build ./public/build

# Installer les dépendances Composer (production uniquement)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Configurer OPcache pour la production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=32" >> /usr/local/etc/php/conf.d/opcache.ini

# Étape 3 : Nginx
FROM nginx:alpine

# Copier la configuration Nginx
COPY deploy/nginx.conf /etc/nginx/conf.d/default.conf

# Copier les fichiers depuis le builder PHP
WORKDIR /var/www/html
COPY --from=php /var/www/html .

# Exposer le port 8080 (Render utilise ce port par défaut)
EXPOSE 8080

# Démarrer PHP-FPM et Nginx (assurez-vous que les deux processus s'exécutent correctement)
CMD ["sh", "-c", "php-fpm && nginx -g 'daemon off;'"]
