FROM php:7.3-apache

COPY php.ini /usr/local/etc/php/php.ini

RUN apt-get update

RUN pecl install redis
RUN docker-php-ext-enable redis

RUN docker-php-ext-install pcntl

RUN mkdir -p /var/www/html

RUN usermod -u 1000 www-data

CMD ["php", "react.php"]
