FROM phpdockerio/php:7.4-fpm

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
	cron \
	nano \
	php7.4-cli \
    php7.4-memcached \
    php7.4-memcache \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-intl \
    php7.4-interbase \
    php7.4-soap \
    php7.4-gd \
    php7.4-imagick \
    php7.4-opcache \
    php7.4-zip \
	php7.4-xdebug \
    php-pear php7.4-dev libmcrypt-dev gcc make autoconf libc-dev pkg-config \
    && pecl install mcrypt-1.0.4

# DO NOT install php7.4-xdebug package for site running in production! It will slow it down significantly.


# Sendmail
RUN apt-get update &&\
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

# cron
#COPY ./cron/cronjob /etc/cron.d/cronjob
#RUN chmod 0644 /etc/cron.d/cronjob
#RUN crontab /etc/cron.d/cronjob
#RUN touch /var/log/cron.log
#CMD cron

#RUN ["chmod", "+x", "/tmp/entrypoint.sh"]

COPY ./conf.d/php.ini /etc/php/7.4/fpm/conf.d/90-php.ini
COPY ./conf.d/php.ini /etc/php/7.4/cli/conf.d/90-php.ini


RUN usermod -u 1000 www-data
RUN chmod 777 -R /tmp && chmod o+t -R /tmp

RUN  apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/var/www/html"

EXPOSE 9000
