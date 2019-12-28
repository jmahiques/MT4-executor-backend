FROM php:7.3-apache

COPY php.ini /usr/local/etc/php/php.ini
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install json mbstring

RUN apt-get update

RUN apt-get install -y libcurl3-dev \
  && docker-php-ext-install curl

RUN pecl install xdebug-2.7.2
RUN docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN pecl install redis
RUN docker-php-ext-enable redis

RUN a2enmod rewrite

#create DocumentRoot to avoid apache crashing before volumes are mounted
RUN mkdir -p /var/www/html

RUN usermod -u 1000 www-data
