FROM php:7-fpm-stretch

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY . /var/www/html

RUN chmod 0755 /var/www/html/etc/entrypoint.sh
ENTRYPOINT /var/www/html/etc/entrypoint.sh

VOLUME /var/www/html
WORKDIR /var/www/html

