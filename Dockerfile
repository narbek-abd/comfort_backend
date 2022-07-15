FROM php:8-fpm
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html