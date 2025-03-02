# PHP Image for Laravel (PHP 8.2 and Composer)
FROM php:8.2-fpm

# 2. Working Directory
WORKDIR /var/www

# 3. Install Dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd mbstring pdo pdo_mysql xml

# 4. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Copy Laravel Files
COPY . /var/www

# 6. File and Authorization for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 7. Start Service for Laravel
CMD ["php-fpm"]
