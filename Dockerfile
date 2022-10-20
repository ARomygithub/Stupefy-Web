FROM php:8.0-apache

COPY . /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
