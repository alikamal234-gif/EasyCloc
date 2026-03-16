FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

RUN composer install

RUN php artisan key:generate

EXPOSE 80