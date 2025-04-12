# ========= ÉTAPE BUILD =========
FROM node:18 AS builder

WORKDIR /var/www

# 1. Copie stratégique pour optimiser le cache
COPY package.json package-lock.json vite.config.js tailwind.config.js* ./

# 2. Installation précise des dépendances
RUN npm ci --silent

# 3. Copie ET build des assets
COPY resources ./resources
RUN npm run build && \
    # Vérification que les fichiers sont bien générés
    ls -la public/build/assets/

# ========= ÉTAPE FINALE =========
FROM php:8.3-fpm-alpine

# 1. Dépendances strictement nécessaires
RUN apk add --no-cache \
    nginx supervisor \
    libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# 2. Configuration optimisée
WORKDIR /var/www

# 3. Copie des artefacts Vite
COPY --from=builder /var/www/public/build ./public/build

# 4. Copie intelligente du reste
COPY --from=builder /var/www/vendor ./vendor
COPY . .

# 5. Installation Composer sécurisée
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader --no-scripts && \
    php artisan package:discover

# 6. Permissions renforcées
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache public/build

# 7. Entrypoint optimisé
COPY docker/entrypoint.sh /entrypoint
RUN chmod +x /entrypoint

EXPOSE 80
CMD ["/entrypoint"]
