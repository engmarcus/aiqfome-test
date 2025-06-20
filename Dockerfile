FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura diretório de trabalho
WORKDIR /var/www

# Copia arquivo php.ini customizado
COPY .docker/php.ini /usr/local/etc/php/conf.d/custom.ini
