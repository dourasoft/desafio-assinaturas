FROM composer:2.7.4 as composer
COPY . /app
RUN composer install --ignore-platform-reqs --no-scripts

FROM php:8.2-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache openssl bash nodejs npm postgresql-dev

RUN docker-php-ext-install bcmath pdo pdo_pgsql

RUN rm -rf /var/www/html  
RUN ln -s public html

COPY . /var/www
COPY --from=composer /app/vendor /var/www/vendor

RUN chmod -R 777 /var/www/storage

EXPOSE 9000
