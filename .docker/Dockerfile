# Define base image
FROM php:8.0.14-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    openssl \
    libssl-dev \
    zip \
    curl \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-source delete

# Clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Virtual Host File
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the owner/group of the web root & enable apache modules
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite headers
