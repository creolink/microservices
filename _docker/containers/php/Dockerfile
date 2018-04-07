FROM php:7.2.2-fpm

ENV APPLICATION_ENV development

RUN apt-get update && apt-get upgrade -y \
    wget \
    mc \
    g++ \
    libc-client-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libkrb5-dev \
    libpq-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libpng-dev \
    libmemcached-dev \
    libssl-dev \
    libssl-doc \
    libsasl2-dev \
    zlib1g-dev \
    libbz2-dev \
    libxml2-dev \
    && docker-php-ext-install \
    bz2 \
    iconv \
    mbstring \
    mysqli \
#    pgsql \
    pdo_mysql \
#    pdo_pgsql \
    soap \
    zip \
    && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
#    && yes '' | pecl install imagick && docker-php-ext-enable imagick \
#    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
#    && docker-php-ext-install imap \
#    && pecl install memcached && docker-php-ext-enable memcached \
#    && pecl install mongodb && docker-php-ext-enable mongodb \
#    && pecl install redis && docker-php-ext-enable redis \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && apt-get autoremove -y --purge \
    && apt-get clean \
    && rm -Rf /tmp/*

RUN wget https://phar.phpunit.de/phpunit-6.1.phar \
    && chmod +x phpunit-6.1.phar \
    && mv phpunit-6.1.phar /usr/local/bin/phpunit

RUN usermod -u 1000 www-data

