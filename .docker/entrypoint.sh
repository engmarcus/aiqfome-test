#!/bin/sh
set -e

# Inicializa progresso 0%
echo "0" > /var/www/public/progress.txt

mkdir -p /var/www/storage/framework/views /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache
echo "20" > /var/www/public/progress.txt

composer install --no-interaction --prefer-dist
echo "70" > /var/www/public/progress.txt

php artisan app:Setup
echo "95" > /var/www/public/progress.txt
echo "100" > /var/www/public/progress.txt

exec php-fpm
echo "100" > /var/www/public/progress.txt
