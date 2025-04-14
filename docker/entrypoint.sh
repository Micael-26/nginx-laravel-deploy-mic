#!/bin/sh

# Exécuter les migrations (elles échoueront silencieusement si PostgreSQL n'est pas prêt)
php artisan migrate --force || true

# Discover packages (nécessaire si on a utilisé --no-scripts dans le Dockerfile)
php artisan package:discover --ansi

# Livewire (publication des assets)
php artisan livewire:publish --assets

# Cache Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur
exec /usr/bin/supervisord -c /etc/supervisord.conf
