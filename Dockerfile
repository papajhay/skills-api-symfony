FROM dunglas/frankenphp:php8.2

WORKDIR /app

# Keep the extensions used by the Symfony application.
RUN install-php-extensions \
        intl \
        opcache \
        pdo_pgsql \
        xml \
        zip

# Composer is copied from the official Composer image; no second PHP runtime
# or PHP-FPM process is installed.
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY docker/php/conf.d/99-app.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/Caddyfile /etc/caddy/Caddyfile

COPY . /app

RUN composer install \
        --no-interaction \
        --prefer-dist \
        --no-progress \
        --optimize-autoloader

RUN setcap -r /usr/local/bin/frankenphp
 
RUN chmod +x /usr/local/bin/frankenphp

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
