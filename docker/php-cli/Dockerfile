FROM php:7.2-cli

WORKDIR /api/www

RUN apt-get update -qq \
    && apt-get install -qy --no-install-recommends \
        autoconf \
        git \
        g++ \
        make \
        cmake \
        curl \
        pkg-config \
        libtool \
        zlib1g-dev \
        tar \
        zip \
        unzip \
        wget

RUN mkdir /var/log/php

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

# MongoDb
RUN pecl install mongodb