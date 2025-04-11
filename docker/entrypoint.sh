#!/bin/sh

# Exécuter les migrations (elles échoueront silencieusement si PostgreSQL n'est pas prêt)
php artisan migrate --force || true

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur
exec /usr/bin/supervisord -c /etc/supervisord.conf
