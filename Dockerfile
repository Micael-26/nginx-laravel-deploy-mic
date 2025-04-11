# ========== ÉTAPE DE BUILD ==========
FROM node:20 AS frontend-builder

WORKDIR /app

# 1. Installer les dépendances frontend
COPY package.json package-lock.json ./
RUN npm install --legacy-peer-deps && npm cache clean --force

# 2. Builder les assets
COPY resources/ ./resources/
COPY vite.config.js ./
RUN npm run build

# ========== ÉTAPE DE PRODUCTION ==========
FROM php:8.3-fpm-alpine

# 1. Installer les dépendances système minimales
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# 2. Configurer l'environnement
WORKDIR /var/www
ENV NODE_ENV=production
ENV APP_ENV=production

# 3. Copier les assets compilés depuis l'étape frontend
COPY --from=frontend-builder /app/public/build/ ./public/build/

# 4. Installer les dépendances PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 5. Configurer les permissions
RUN chown -R www-data:www-data /var/www \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \; \
    && chmod -R 775 storage bootstrap/cache

# 6. Configurer les services
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# 7. Configurer l'entrypoint (conversion des fins de ligne)
COPY docker/entrypoint.sh /usr/local/bin/
RUN apk add --no-cache dos2unix \
    && dos2unix /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["sh", "/usr/local/bin/entrypoint.sh"]
