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

# Copie le projet Laravel
COPY . /var/www

# Donne les bons droits
WORKDIR /var/www
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Supprime la configuration nginx par défaut et ajoute la tienne
COPY nginx.conf /etc/nginx/nginx.conf

# Configuration supervisord pour lancer PHP-FPM + Nginx ensemble
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
