FROM php:8.0-apache

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      wkhtmltopdf \
      procps \
      nano \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      libpng-dev \
      supervisor \
      cron \
      libzip-dev \
      libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
      pgsql \
      pdo \
      pdo_pgsql \
      sockets \
      intl \
      opcache \
      pcntl \
      soap \
      zip \
      gd  \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && cp /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf \
    && apt-get clean

#git
RUN apt-get update && apt-get upgrade -y && apt-get install -y git

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
