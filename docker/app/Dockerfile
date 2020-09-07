FROM php:7.4-fpm AS cs-php-fpm

LABEL maintainer="Alexander Schlegel CLICKSPORTS"
LABEL DOCKER_IMAGE_VERSION="1.0"

# install non php modules
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libssl-dev \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
        libc-client-dev \
        libkrb5-dev \
        libcurl4-openssl-dev \
        zlib1g-dev \
        curl \
        zip \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

# Configure imap
RUN set -eux; PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl

# Configure GD
RUN docker-php-ext-configure gd --with-freetype=/usr/local/ --with-jpeg=/usr/local/

# install php modules, ssh2 is missing
RUN docker-php-ext-install \
    imap \
    gd \
    zip \
    mbstring \
    pdo \
    pdo_mysql \
    xml \
    mysqli \
    curl \
    calendar

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# set php ini and apache config
RUN rm /usr/local/etc/php/php.ini-development \
    && rm /usr/local/etc/php/php.ini-production

COPY docker/app/php.ini /usr/local/etc/php/php.ini

## Start Development Setup
FROM cs-php-fpm AS cs-php-fpm-dev

ENV APP_ENV development

RUN apt-get update \
    && apt-get install -y \
        nano

COPY docker/app/.bashrc /root/.bashrc

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

## Start Production Setup
FROM cs-php-fpm AS cs-php-fpm-prod

ENV APP_ENV production

COPY ./html /var/www/html

RUN chown -R www-data: /var/www/html