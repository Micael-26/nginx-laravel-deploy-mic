# Étape 1 : Image de base avec PHP
FROM php:8.3-fpm AS base

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip unzip git curl \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm \
    nginx \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer le dossier de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances NPM et compiler Vite
RUN npm install && npm run build

# Donne les bons droits
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Supprimer conf Nginx par défaut et copier la tienne
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Supervisord
COPY docker/supervisord.conf /etc/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exposer le port
EXPOSE 80

# Démarrer les services
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
