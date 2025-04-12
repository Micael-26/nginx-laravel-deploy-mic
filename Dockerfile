# ========= ÉTAPE 1 : BUILD DES ASSETS =========
FROM node:18 AS frontend-builder

WORKDIR /var/www

# 1. Copie des fichiers de configuration (optimisation cache Docker)
# Note: package-lock.json est optionnel, on l'ignore s'il n'existe pas
COPY package.json vite.config.js tailwind.config.js* ./
COPY package-lock.json* ./

# 2. Installation des dépendances Node (plus rapide que npm install)
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

# 3. Copie des ressources et compilation
COPY resources ./resources
RUN npm run build && \
    # Vérification que les fichiers sont bien générés
    ls -la public/build/assets/ && \
    echo "✅ Build des assets réussi"

# ========= ÉTAPE 2 : BUILD PHP =========
FROM composer:2 AS php-builder

WORKDIR /var/www

# Copie sélective pour optimiser le cache
COPY composer.json composer.lock ./

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# ========= ÉTAPE 3 : IMAGE FINALE =========
FROM php:8.3-fpm

# 1. Installation des dépendances système minimales
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev nginx supervisor \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# 2. Installation de Composer
COPY --from=php-builder /usr/bin/composer /usr/bin/composer

# 3. Configuration du workspace
WORKDIR /var/www

# 4. Copie des artefacts
COPY --from=frontend-builder /var/www/public/build ./public/build
COPY --from=php-builder /var/www/vendor ./vendor

# 5. Copie du code source
COPY . .

# 6. Configuration des permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache

# 7. Découverte des packages Laravel
RUN php artisan package:discover

# 8. Configuration serveur
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/supervisord.conf

# 9. Entrypoint
COPY docker/entrypoint.sh /entrypoint
RUN chmod +x /entrypoint

EXPOSE 80
CMD ["/entrypoint"]
