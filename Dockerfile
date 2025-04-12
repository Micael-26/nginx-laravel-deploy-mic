# ================================================
# Étape 1 : Builder les assets frontend (Node.js)
# ================================================
FROM node:18 AS frontend-builder

WORKDIR /var/www

# 1. Copie les fichiers nécessaires pour npm install (optimisation cache)
COPY package.json vite.config.js ./

# 2. Copie conditionnelle de tailwind.config.js si existant
COPY tailwind.config.js* ./

# 3. Copie des ressources frontend
COPY resources ./resources

# 4. Installation et build
RUN npm install && npm run build

# ================================================
# Étape 2 : Image finale (PHP-FPM + Nginx)
# ================================================
FROM php:8.3-fpm

# 1. Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential libpq-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    locales zip jpegoptim optipng pngquant gifsicle vim unzip git curl \
    libonig-dev libxml2-dev libzip-dev nginx supervisor \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# 2. Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Configurer le répertoire de travail
WORKDIR /var/www

# 4. Copier les artefacts de build
COPY --from=frontend-builder /var/www/public/build ./public/build

# 5. Copier les fichiers du projet (sauf ce qui est déjà dans .dockerignore)
COPY . .

# 6. Installer les dépendances PHP (avec gestion des scripts)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts && \
    # Lancer manuellement package:discover si besoin
    php artisan package:discover --ansi

# 7. Configurer les permissions
RUN chown -R www-data:www-data /var/www && \
    find /var/www -type d -exec chmod 755 {} \; && \
    find /var/www -type f -exec chmod 644 {} \; && \
    chmod -R 775 storage bootstrap/cache && \
    chgrp -R www-data storage bootstrap/cache

# 8. Configuration Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# 9. Configuration Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# 10. Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
