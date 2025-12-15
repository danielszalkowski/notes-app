#!/bin/sh
set -e

echo "🚀 Init backend..."

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ ! -f database/database.sqlite ]; then
  mkdir -p database
  touch database/database.sqlite
fi

composer install --no-interaction --prefer-dist

php artisan key:generate --force
php artisan migrate --force

echo "✅ Backend listo, arrancando proceso principal..."

exec "$@"
