FROM phpdockerio/php:8.0-fpm

ARG UID
ARG GID

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    php8.0-memcached \
    php8.0-memcache \
    php8.0-mbstring \
    php8.0-mysql \
    php8.0-intl \
    php8.0-interbase \
    php8.0-soap \
    php8.0-gd \
    php8.0-imagick \
    php8.0-opcache \
    php8.0-zip \
    php8.0-xdebug \
    php-pear php8.0-dev libmcrypt-dev gcc make autoconf libc-dev pkg-config git openssh-client\
    && pecl install mcrypt-1.0.4 \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY ./.docker/etc/php80/conf.d/php.ini /etc/php/8.0/fpm/conf.d/90-php.ini
COPY ./.docker/etc/php80/conf.d/php.ini /etc/php/8.0/cli/conf.d/90-php.ini
COPY ./.docker/etc/php80/.gitconfig /root/.gitconfig

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Work in the specific space

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupmod -g ${GID} www-data
RUN usermod -u ${UID} www-data

WORKDIR "/var/www/html"

EXPOSE 9000
