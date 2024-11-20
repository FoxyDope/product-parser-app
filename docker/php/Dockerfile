FROM php:8.2-fpm

# Install required system dependencies and libraries
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    pkg-config \
    libssl-dev \
    librabbitmq-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# Clean up to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html