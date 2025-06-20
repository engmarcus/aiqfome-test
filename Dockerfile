FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY .docker/php.ini /usr/local/etc/php/conf.d/custom.ini

RUN chmod +x /usr/local/bin/entrypoint.sh
