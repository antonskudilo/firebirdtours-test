#!/bin/sh
set -e

composer install --no-interaction --prefer-dist

php artisan key:generate --force
php artisan migrate --seed --force
php artisan currency:update-rates

exec apache2-foreground
