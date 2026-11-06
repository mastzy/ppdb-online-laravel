FROM php:8.5-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions: pdo_mysql, gd, zip, bcmath, opcache, mbstring
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        opcache \
        mbstring \
        exif \
        pcntl

# Install and enable redis extension via PECL
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
