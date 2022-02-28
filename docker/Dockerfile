FROM php:8.1-apache

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      wkhtmltopdf \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      libpng-dev \
      supervisor \
      cron \
      sudo \
      libzip-dev \
      libpq-dev \
      wget \
      librabbitmq-dev \
    && pecl install amqp-1.11.0beta \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
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
    && docker-php-ext-enable amqp \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && cp /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf \
    && apt-get clean

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
