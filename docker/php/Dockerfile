FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        sqlite-dev \
        libzip-dev \
        && docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www/html
