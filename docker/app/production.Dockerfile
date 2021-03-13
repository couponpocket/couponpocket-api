FROM repo-clicksports.clicksports.de/docker/php-fpm-prod:7.4

COPY  --chown=www-data:www-data ./html /var/www/html

USER www-data