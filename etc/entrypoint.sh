#!/usr/bin/env bash

composer -vvv install --prefer-dist

chown -R  1000:1000 /var/www/html

#chmod -R 0700 /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions
#chown -R www-data:www-data /var/www/html/var/cache /var/www/html/var/logs /var/www/html/var/sessions

exec php-fpm
