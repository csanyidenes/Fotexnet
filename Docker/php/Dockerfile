# PHP 8.3 + Apache
FROM php:8.3-apache

# Frissítsd a csomagokat és telepítsd a szükséges libeket
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# PHP kiterjesztések telepítése
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Xdebug telepítése (NEM aktiváljuk automatikusan)
RUN pecl install xdebug \
    && rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer telepítése
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js telepítése
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Apache konfiguráció (ha szükséges)
RUN a2enmod rewrite

# Laravel projekthez szükséges jogosultságok
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Xdebug konfiguráció bemásolása (csak ez töltődjön be)
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf


# Port beállítása
EXPOSE 80
EXPOSE 9003
