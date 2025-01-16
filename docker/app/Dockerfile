FROM php:7.3-apache

# Arguments defined in docker-compose.yml
ARG WEB_USER
ARG WEB_GROUP
ARG APACHE_ROOT_DIR
ARG APACHE_LOG_DIR
ARG INSTALL_MYSQL_CLIENT

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    sudo \
    iputils-ping \
    libmcrypt-dev

RUN apt-get update \
    && apt-get install -y default-mysql-client

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Prepare fake SSL certificate
RUN apt-get install -y ssl-cert

# Setup Apache2 mod_ssl
RUN a2enmod ssl

RUN a2enmod rewrite

RUN a2enmod headers

# Setup Apache2 HTTPS env
#RUN a2ensite default-ssl.conf

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    mbstring  \
    exif  \
    pcntl  \
    bcmath  \
    gd  \
    iconv


#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug && \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \

# Fisrt you need to check and update teh path to your /usr/local/etc/php/php.ini
RUN pecl install xdebug-2.9.2 && \
    docker-php-ext-enable xdebug && \
    echo "[xdebug]" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug-settings.ini && \
    echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug-settings.ini && \
    echo "xdebug.remote_connect_back = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug-settings.ini && \
    echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug-settings.ini && \
    echo 'xdebug.idekey = "PHPSTORM"' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug-settings.ini &&\
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $WEB_GROUP -d /home/$WEB_USER $WEB_USER
RUN mkdir -p /home/$WEB_USER/.composer && \
    chown -R $WEB_USER:$WEB_USER /home/$WEB_USER

RUN chmod -R 755 $APACHE_ROOT_DIR
RUN chown -R $WEB_USER:$WEB_USER $APACHE_ROOT_DIR

# Set working directory
WORKDIR $APACHE_ROOT_DIR

USER $WEB_USER
