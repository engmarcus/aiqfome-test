#!/bin/sh
set -e

mkdir -p /var/www/storage/framework/views /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache

composer install --no-interaction --prefer-dist

php artisan app:Setup

exec php-fpm
