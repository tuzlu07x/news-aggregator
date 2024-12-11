# Stage 1: Install dependencies
FROM composer:lts as composer

WORKDIR /app

# Copy the entire Laravel project
COPY . /app

# Run Composer to install dependencies
RUN --mount=type=cache,target=/root/.composer \
    composer install --no-dev --no-interaction --optimize-autoloader

# Stage 2: Build the final image
FROM php:8.3-apache

# Install required PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application code and dependencies
COPY --from=composer /app /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set environment variables for Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache configuration to use the public directory
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose the default port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
