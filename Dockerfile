FROM php:7.2-apache

WORKDIR /var/www

RUN apt-get update \
 && apt-get install -y git zlib1g-dev \
 && docker-php-ext-install zip \
 && docker-php-ext-install pdo pdo_mysql \
 && docker-php-ext-install mysqli \
 && docker-php-ext-install mbstring \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \