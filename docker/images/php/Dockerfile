FROM php:7.2-fpm

# Install recommended extensions for Symfony
RUN apt-get update && apt-get install -y \
        libicu-dev \
        curl \
        vim \
    && docker-php-ext-install \
        intl \
        opcache \
    && docker-php-ext-enable \
        intl \
        opcache \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install mysqli

RUN apt-get install -y zip unzip zlib1g-dev libpng-dev
RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

# Set www-data as owner for /var/www
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/
RUN chmod -R g+w /var/www/
