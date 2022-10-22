FROM php:8.1.3-fpm-alpine3.14 AS source

WORKDIR /var/www

COPY src/ ./src
COPY public/* ./html/
COPY composer.json .
COPY composer.lock .
RUN apk upgrade && apk update && apk add --no-cache composer openssl-dev 

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \ 
    && pecl install mongodb-1.14.1 \
    && apk del pcre-dev ${PHPIZE_DEPS} \
    && echo 'extension=mongodb.so' >> /usr/local/etc/php/php.ini

FROM source AS base
RUN composer install --no-dev && composer dump-autoload
RUN rm composer.json && rm composer.lock

FROM source AS local
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \ 
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && apk del pcre-dev ${PHPIZE_DEPS}
COPY local/xdebug/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY codeception.yml .
COPY tests/ ./tests
RUN composer install && composer dump-autoload
