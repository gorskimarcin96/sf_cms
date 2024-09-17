ARG COMPOSER_VERSION=2.6.5
ARG PHP_VERSION=8.3

#php
FROM php:${PHP_VERSION}-apache

COPY . /var/www/html/

#default
RUN apt-get -y update && apt-get upgrade -y && apt-get install -y \
      git \
      unzip \
      libzip-dev \
      libpq-dev \
      librabbitmq-dev \
      libssl-dev \
      git \
      unzip \
      libzip-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
      pgsql \
      pdo \
      pdo_pgsql \
      zip

#intl
RUN apt-get -y update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

#wkhtmltopdf
RUN apt-get -y update  \
    && apt-get install -y wkhtmltopdf  \
    && cp /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#clean trash
RUN rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean
