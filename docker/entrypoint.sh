#!/bin/bash

# Fichiers de cache
CONFIG_CACHE_FILE="bootstrap/cache/config.php"
ROUTES_CACHE_FILE="bootstrap/cache/routes-v7.php"
VIEWS_CACHE_FILE="bootstrap/cache/views.php"
ENV_HASH_FILE="bootstrap/cache/env_hash.txt"

# 1. Migrations (seulement si nécessaires)
if php artisan migrate:status --no-ansi | grep -q 'Pending'; then
    echo "Exécution des migrations..."
    php artisan migrate --force || true
else
    echo "Aucune migration en attente - skip"
fi

# 2. Package Discovery (si composer.lock modifié)
if [ ! -f "vendor/composer/installed.json" ] || [ "vendor/composer/installed.json" -ot "composer.lock" ]; then
    echo "Découverte des packages..."
    php artisan package:discover --ansi
else
    echo "Packages déjà à jour - skip"
fi

# 3. Assets Livewire (avec fallback si jq absent)
if ! command -v jq &> /dev/null; then
    echo "jq non installé, publication forcée des assets Livewire..."
    php artisan livewire:publish --assets --no-interaction
else
    LIVEWIRE_ASSETS_HASH=$(md5sum vendor/livewire/livewire/dist/* 2>/dev/null | md5sum | cut -d' ' -f1)
    if [ ! -f "public/vendor/livewire/manifest.json" ] || [ "$(jq -r '.hash' public/vendor/livewire/manifest.json 2>/dev/null)" != "$LIVEWIRE_ASSETS_HASH" ]; then
        echo "Publication des assets Livewire..."
        php artisan livewire:publish --assets --no-interaction
    else
        echo "Assets Livewire déjà à jour - skip"
    fi
fi

# 4. Cache système (avec hash du .env)
ENV_HASH=$(md5sum .env 2>/dev/null | cut -d' ' -f1)

if [ "$ENV_HASH" != "$(cat $ENV_HASH_FILE 2>/dev/null)" ] || \
   [ ! -f "$CONFIG_CACHE_FILE" ] || \
   [ ! -f "$ROUTES_CACHE_FILE" ] || \
   [ ! -f "$VIEWS_CACHE_FILE" ]; then
    echo "Mise à jour du cache..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "$ENV_HASH" > "$ENV_HASH_FILE"
else
    echo "Cache déjà à jour - skip"
fi

# Démarrer le serveur
exec /usr/bin/supervisord -c /etc/supervisord.conf
