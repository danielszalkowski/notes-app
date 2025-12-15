#!/bin/sh
set -e

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ ! -f database/database.sqlite ]; then
  mkdir -p database
  touch database/database.sqlite
fi

php artisan key:generate --force
php artisan migrate --force

exec php-fpm
