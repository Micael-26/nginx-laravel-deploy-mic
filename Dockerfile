# Étape 1: Base PHP-FPM
FROM php:8.2-fpm

# Étape 2: Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Étape 3: Installer les extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Étape 4: Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Étape 5: Configurer le répertoire de travail
WORKDIR /var/www/html

# Étape 6: Copier les fichiers de l'application
COPY . .

# Étape 7: Installer les dépendances (production)
RUN composer install --optimize-autoloader --no-dev

# Étape 8: Configurer les permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Étape 9: Copier les configurations
COPY deploy/nginx.conf /etc/nginx/sites-available/default
COPY deploy/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Étape 11: Exposer le port 80
EXPOSE 80

# Étape 12: Lancer Supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
