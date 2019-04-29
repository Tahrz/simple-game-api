FROM php:7.2-fpm-alpine

RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    postgresql-dev

RUN mkdir /var/log/php

RUN docker-php-ext-configure pgsql \
        -with-pgsql=/usr/include/postgresql/ \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql

# MongoDb
RUN pecl install mongodb