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

# Copier les fichiers du projet
COPY . . 

# Copier les assets compilés depuis l'étape Node
COPY --from=node /var/www/html/public/build ./public/build

# Installer les dépendances Composer (production uniquement)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configurer les permissions sur les répertoires de stockage et cache
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Configurer OPcache pour la production
RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.memory_consumption=256"; \
    echo "opcache.interned_strings_buffer=32"; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Étape 3 : Image finale avec Nginx + PHP-FPM
FROM alpine:3.18

# Installer Nginx, PHP-FPM, supervisord, et bash
RUN apk add --no-cache \
    nginx \
    php82 \
    php82-fpm \
    php82-opcache \
    php82-mbstring \
    php82-pdo \
    php82-pdo_mysql \
    php82-gd \
    php82-zip \
    supervisor \
    bash  # Installer bash ici si vous avez besoin de bash

# Configurer les répertoires nécessaires
RUN mkdir -p /var/www/html && \
    mkdir -p /run/nginx && \
    mkdir -p /run/php && \
    mkdir -p /var/log/php82 && \
    rm /etc/nginx/http.d/default.conf

# Copier la configuration de Nginx et supervisord
COPY deploy/nginx.conf /etc/nginx/http.d/default.conf
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copier les fichiers depuis le builder PHP
WORKDIR /var/www/html
COPY --from=php /var/www/html .

# Configurer les permissions sur les répertoires de stockage et cache
RUN chown -R nginx:nginx /var/www/html/storage \
    && chown -R nginx:nginx /var/www/html/bootstrap/cache \
    && chown -R nginx:nginx /var/log/php82

# Exposer le port 8080 (Render utilise ce port par défaut)
EXPOSE 8080

# Démarrer les services avec Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
