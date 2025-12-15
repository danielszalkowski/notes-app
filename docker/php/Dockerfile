FROM php:8.4-fpm-alpine

# Argumentos para permisos (muy importante en Linux)
ARG UID=1000
ARG GID=1000

# Instalamos dependencias y extensiones necesarias
RUN apk add --no-cache \
    sqlite-dev \
    libzip-dev \
    shadow \
    && docker-php-ext-install pdo pdo_sqlite zip

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ajustamos el usuario www-data para que coincida con tu usuario local
# Esto evita el error de "Permission denied" al escribir en storage o database
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Directorio de trabajo
WORKDIR /var/www/html

# Cambiamos al usuario www-data
USER www-data

# Comanda por defecto (ya viene en la imagen base, pero explícito es mejor)
CMD ["php-fpm"]
