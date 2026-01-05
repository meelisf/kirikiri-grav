FROM php:8.3-apache

# 1. Installime vajalikud teegid
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd zip intl opcache

# 2. Kasutame production seadeid
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# 3. SEADISTAME APACHE JOOKSMA MITTE-ROOT KASUTAJANA
# Muudame Apache pordi 80 -> 8080 (sest tavakasutaja ei saa porti 80 avada)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Lubame mod_rewrite
RUN a2enmod rewrite

# 4. Õiguste korrastamine
# Apache vajab ligipääsu teatud kaustadele, et logida ja PID faile hoida
RUN chown -R www-data:www-data /var/www/html /var/run/apache2 /var/lock/apache2 /var/log/apache2

# Vahetame kasutajat - nüüdsest peale on kõik käsud ja protsessid www-data õigustes
USER www-data

WORKDIR /var/www/html

# Expose port (informatiivne)
EXPOSE 8080
