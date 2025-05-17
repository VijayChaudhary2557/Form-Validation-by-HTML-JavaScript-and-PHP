# Base PHP image with Apache
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module (optional, only if needed)
RUN a2enmod rewrite

# Copy all project files to Apache root
COPY . /var/www/html/

# Set proper permissions (optional)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
