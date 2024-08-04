FROM php:8.1-fpm-buster
ARG TIMEZONE

COPY docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# get install script and pass it to execute:
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash
# and install node
RUN apt-get install nodejs -y

WORKDIR /var/www/symfony

COPY --chown=www-data assets/ assets/
COPY --chown=www-data bin/ bin/
COPY --chown=www-data config/ config/
COPY --chown=www-data public/ public/
COPY --chown=www-data src/ scr/
COPY --chown=www-data templates/ templates/
COPY --chown=www-data .env .env
COPY --chown=www-data composer.json composer.json
COPY --chown=www-data composer.lock composer.lock
COPY --chown=www-data package.json package.json
COPY --chown=www-data symfony.lock symfony.lock
COPY --chown=www-data webpack.config.js webpack.config.js
COPY --chown=www-data yarn.lock yarn.lock

RUN composer install --no-scripts


RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt update && apt install -y yarn

WORKDIR /var/www/symfony
