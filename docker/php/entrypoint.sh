#!/bin/sh
set -eu

cd /var/www/html

mkdir -p var/cache var/log var/sessions

if [ ! -f vendor/autoload.php ] && [ -f composer.lock ]; then
    composer install --no-interaction --prefer-dist --no-progress
fi

exec docker-php-entrypoint "$@"
