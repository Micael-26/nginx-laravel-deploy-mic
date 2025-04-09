FROM php:8.3-fpm

# Installe les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
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
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crée le dossier de travail
WORKDIR /var/www

# Copie le projet Laravel
COPY . .

# Installe les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Donne les bons droits d'accès
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Supprime la configuration nginx par défaut et ajoute la tienne
COPY nginx.conf /etc/nginx/nginx.conf

# Configuration supervisord pour lancer PHP-FPM + Nginx ensemble
COPY supervisord.conf /etc/supervisord.conf

# Expose le port HTTP
EXPOSE 80

# Lance supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
