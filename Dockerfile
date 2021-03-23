FROM php:apache

COPY apache2.4.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite \
&& rm -rf /var/www/

COPY . /var/www/

RUN chown -R www-data:www-data /var/www \
&& mkdir /nextcloud \
&& chown -R www-data:www-data /nextcloud \
&& a2enmod headers \
&& a2enmod env \
&& a2enmod dir \
&& a2enmod mime \
&& apt-get update \
&& apt-get install -y \
        libzip-dev \
        zip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
&& docker-php-ext-install zip \
&& apt-get install -y \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd \
&& docker-php-ext-install mysqli pdo pdo_mysql \
&& service apache2 restart 