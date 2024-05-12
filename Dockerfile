# php official fpm image
FROM php:8.2-fpm

# Set user and group IDs as build arguments (defaults to 1000)
ARG USER_ID=1000
ARG GROUP_ID=1000

# Update the www-data user and group IDs
RUN usermod -u $USER_ID www-data \
    && groupmod -g $GROUP_ID www-data

# Set environment variables for user and group IDs
ENV USER_ID $USER_ID
ENV GROUP_ID $GROUP_ID

# installs basic tools, then postgres ppa then nodejs ppa then nodejs and postgresql-client packages
# (and some other required dependencies). It then installs and configures several php extensions
# including pdo_pgsql and redis. Finally, it downloads and installs composer in the image.
RUN apt-get update \
    && apt-get install -y gnupg curl wget ca-certificates unzip lsb-release \
    && wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
    && echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" | tee  /etc/apt/sources.list.d/pgdg.list \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        nodejs \
        postgresql-client-14 \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql zip bcmath pcntl exif \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && npm install -g npm \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && chown -R www-data:www-data /var/www

COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

COPY ./docker/entrypoint.sh /

ENTRYPOINT ["sh", "/entrypoint.sh"]

EXPOSE 80

WORKDIR /var/www/html
USER www-data
