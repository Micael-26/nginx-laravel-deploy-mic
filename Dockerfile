FROM php:8.3-fpm

# Installer les dépendances système (y compris libpq-dev pour PostgreSQL)
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \  # Pour PostgreSQL
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*  # Nettoyage après l'installation pour réduire la taille de l'image

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crée le dossier de travail
WORKDIR /var/www

# Copie le projet Laravel
COPY . .

# Installe les dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Donne les bons droits d'accès
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chgrp -R www-data /var/www/storage /var/www/bootstrap/cache

# Supprime la configuration nginx par défaut et ajoute la tienne
COPY nginx.conf /etc/nginx/nginx.conf

# Configuration supervisord pour lancer PHP-FPM + Nginx ensemble
COPY supervisord.conf /etc/supervisord.conf

# Expose le port HTTP
EXPOSE 80

# Lance supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
