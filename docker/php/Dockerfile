FROM php:8.4-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN apk add --no-cache \
    $PHPIZE_DEPS \
    sqlite-dev \
    libzip-dev \
    shadow \
    && docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN if [ ${UID:-0} -ne 0 ] && [ ${GID:-0} -ne 0 ]; then \
    usermod -u ${UID} www-data && \
    groupmod -g ${GID} www-data; \
fi

COPY entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh \
 && chmod +x /entrypoint.sh

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

USER www-data

ENTRYPOINT ["/entrypoint.sh"]
