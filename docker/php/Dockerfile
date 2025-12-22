FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

COPY docker/php/etc/apache2-site.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/etc/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/entrypoint-app.sh /entrypoint-app.sh
COPY docker/php/entrypoint-queue.sh /entrypoint-queue.sh

RUN chmod +x /entrypoint-app.sh /entrypoint-queue.sh
RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite
