FROM php:7.4-fpm

COPY ./docker-pool.conf /usr/local/etc/php-fpm.d/docker-pool.conf

ARG workdir="/var/www/html"

RUN apt-get update && apt-get install git libcurl4-gnutls-dev libicu-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev -yqq \
    && docker-php-ext-install -j$(nproc) iconv pdo_mysql curl json intl gd xml bz2 bcmath
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN pecl install -o -f redis \
	&&  rm -rf /tmp/pear \
	&&  docker-php-ext-enable redis

WORKDIR "$workdir"

COPY ./start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

CMD ["/usr/local/bin/start"]