# Use PHP Apache as base image
FROM php:8.2-apache

# Install PDO MySQL extension and other required packages
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Optional: Set working directory
WORKDIR /var/www/html

# Optional: Set permissions
RUN chown -R www-data:www-data /var/www/html/