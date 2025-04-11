FROM php:8.3-fpm

# 1. Installer les dépendances système + extensions PHP + dos2unix
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
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
    dos2unix \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# 2. Installer Node.js (LTS) avec vérification
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && node -v \
    && npm -v \
    && npm install -g npm@latest

# 3. Étape frontend sécurisée
WORKDIR /var/www

# 3.1 Copie séparée pour meilleur cache
COPY package.json package-lock.json* ./

# 3.2 Installation avec gestion d'erreur
RUN npm install --legacy-peer-deps || \
    (echo "Fallback: clean node_modules and retry..." && rm -rf node_modules/ && npm install --legacy-peer-deps) \
    && npm cache clean --force

# 3.3 Build avec variables nécessaires
ENV NODE_ENV=production
COPY resources/ ./resources/
COPY vite.config.js ./
RUN npm run build || \
    (echo "Build failed - retrying..." && npm rebuild && npm run build)

# 4. Backend PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

# 4.1 Installation Composer sécurisée
RUN composer install --no-dev --optimize-autoloader --no-interaction || \
    (rm -rf vendor/ && composer install --no-dev --optimize-autoloader --no-interaction)

# 5. Permissions (ajustées pour éviter les conflits)
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 6. Configuration serveur
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisord.conf

# 7. Entrypoint robuste
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && dos2unix /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
