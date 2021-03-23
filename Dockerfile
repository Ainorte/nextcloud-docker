FROM php:apache

COPY apache2.4.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN rm -rf /var/www/
COPY . /var/www/

RUN chown -R www-data:www-data /var/www

RUN mkdir /nextcloud
RUN chown -R www-data:www-data /nextcloud

RUN a2enmod headers
RUN a2enmod env
RUN a2enmod dir
RUN a2enmod mime

RUN apt-get update

RUN apt-get install -y \
        libzip-dev \
        zip

RUN docker-php-ext-install zip

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev 

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN service apache2 restart