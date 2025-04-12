### 🧱 Étape 1 : Construction des assets avec Node + Composer ###
FROM node:20 as build-stage

# Installer PHP CLI + Composer
RUN apt-get update && apt-get install -y \
    php-cli \
    php-mbstring \
    php-xml \
    php-curl \
    php-zip \
    unzip \
    git \
    curl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer le dossier de travail
WORKDIR /app

# Copier les fichiers nécessaires
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances JS et builder les assets avec Vite
RUN npm ci && npm run build


### 🧱 Étape 2 : Image finale pour exécution ###
FROM php:8.3-fpm as runtime-stage

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    curl \
    git \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Copier Composer depuis le container précédent
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier le code source depuis l'étape de build
COPY --from=build-stage /app /var/www

# Donner les bons droits
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chgrp -R www-data /var/www/storage /var/www/bootstrap/cache

# Copier les configurations nginx et supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Rendre le script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exposer le port HTTP
EXPOSE 80

# Point d’entrée
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
