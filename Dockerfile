# Use an official PHP image
FROM php:8.1-apache

# Install dependencies (if required)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

# Expose the default Apache port
EXPOSE 80
