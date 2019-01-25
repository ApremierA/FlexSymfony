FROM php:7.2-fpm-stretch

# for composer install
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip

# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./etc/xdebug.ini /usr/local/etc/php/conf.d/

# composer install
RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY . /var/www/html

RUN chmod 0755 /var/www/html/etc/entrypoint.sh
ENTRYPOINT /var/www/html/etc/entrypoint.sh

VOLUME /var/www/html
WORKDIR /var/www/html

