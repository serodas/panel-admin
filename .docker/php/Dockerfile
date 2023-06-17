FROM php:8.2-fpm-buster
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y --no-install-recommends \
    acl \
    libcurl4-openssl-dev \
    procps \
    zip \
    unzip \
    wget \
    git \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    unixodbc \
    unixodbc-dev \
    ldap-utils libldap2-dev \
    libpng-dev && \
    docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install \
    gd \
    zip \
    intl \
    mysqli \
    pdo \
    pdo_odbc \
    xml \
    curl \
    mbstring \
    opcache \
    ldap \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-source extract \
    && set -x \
    && cd /usr/src/php/ext/odbc \
    && phpize \
    && sed -ri 's@^ *test +"\$PHP_.*" *= *"no" *&& *PHP_.*=yes *$@#&@g' configure \
    && docker-php-ext-configure odbc --with-unixODBC=shared,/usr \
    && docker-php-ext-install odbc \
    && docker-php-ext-enable odbc \
    && docker-php-source delete \
    && php -m

RUN pecl install xdebug-3.2.0 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

COPY odbc/ibm-iaccess-1.1.0.12-1.0.amd64.deb /tmp/
RUN dpkg -i /tmp/ibm-iaccess-1.1.0.12-1.0.amd64.deb
RUN rm /tmp/ibm-iaccess-1.1.0.12-1.0.amd64.deb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

COPY xdebug/xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
COPY opcache/opcache.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini
COPY odbc/odbc.ini /etc/odbc.ini
WORKDIR /var/www/project