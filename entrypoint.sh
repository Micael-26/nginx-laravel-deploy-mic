#!/bin/sh

# Extraire les informations de la variable DATABASE_URL
DATABASE_URL="${DATABASE_URL}"

# Vérifier si DATABASE_URL est défini
if [ -z "$DATABASE_URL" ]; then
  echo "❌ DATABASE_URL n'est pas défini."
  exit 1
fi

# Extraire les parties de DATABASE_URL

# Utilisation de regex pour décomposer l'URL
DB_HOST=$(echo $DATABASE_URL | sed -E 's|^postgres://([^:]+):.*|\1|')
DB_PORT=$(echo $DATABASE_URL | sed -E 's|^postgres://[^:]+:([^@]+).*|\1|')
DB_USERNAME=$(echo $DATABASE_URL | sed -E 's|^postgres://([^:]+):([^@]+)@.*|\1|')
DB_PASSWORD=$(echo $DATABASE_URL | sed -E 's|^postgres://[^:]+:([^@]+)@.*|\1|')
DB_DATABASE=$(echo $DATABASE_URL | sed -E 's|^postgres://[^:]+:[^@]+@[^/]+/(.*)|\1|')

echo "⏳ Attente que PostgreSQL soit prêt..."

# Attente jusqu'à ce que la base de données PostgreSQL soit prête
until psql -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" -d "$DB_DATABASE" -c '\q' 2>/dev/null; do
  echo "⏳ PostgreSQL non prêt encore - attente..."
  sleep 2
done

echo "✅ PostgreSQL est prêt, démarrage des migrations..."

# Exécuter les migrations (forcé en production)
php artisan migrate --force

# Optimiser les fichiers de cache et config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lancer supervisord pour démarrer PHP-FPM + Nginx
echo "✅ Lancement du serveur avec supervisord"
exec /usr/bin/supervisord -c /etc/supervisord.conf
