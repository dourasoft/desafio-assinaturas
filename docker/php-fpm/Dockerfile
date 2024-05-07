FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    
EXPOSE 9000

ENTRYPOINT ["sh", "-c", "composer install && php artisan migrate && php artisan queue:work --tries=3 & php artisan schedule:work & php-fpm"]
