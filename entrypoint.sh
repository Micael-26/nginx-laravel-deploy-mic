#!/bin/sh

# Attendre que la base de données soit disponible (important pour Render/PostgreSQL)
echo "⏳ Attente de la base de données..."
until pg_isready -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USERNAME}"; do
  echo "⏳ PostgreSQL non prêt encore - attente..."
  sleep 2
done
echo "✅ Base de données prête."

# Appliquer les migrations avec force (prod)
echo "🚀 Lancement des migrations..."
php artisan migrate --force

# Optimiser le cache de config/route/view
echo "⚙️ Optimisation Laravel (config, route, view)..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Donner les bons droits
echo "🔐 Attribution des permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Démarrer le serveur via supervisord (PHP-FPM + Nginx)
echo "🚦 Démarrage du serveur supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
