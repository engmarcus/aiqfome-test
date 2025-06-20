#!/bin/sh
set -e
git config --global --add safe.directory /var/www
echo "0" > /var/www/public/progress.txt
mkdir -p /var/www/storage/framework/views /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache
echo "35" > /var/www/public/progress.txt
composer install --no-interaction --prefer-dist
echo "65" > /var/www/public/progress.txt
php artisan key:generate
echo "75" > /var/www/public/progress.txt
php artisan jwt:secret
echo "80" > /var/www/public/progress.txt
php artisan app:Setup || true
echo "95" > /var/www/public/progress.txt
echo "100" > /var/www/public/progress.txt
exec php-fpm
