# Use an official PHP image with Apache
FROM php:8.1-apache

# Install PHP extensions required by CodeIgniter
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Set permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
