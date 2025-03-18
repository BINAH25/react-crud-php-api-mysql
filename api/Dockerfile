FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Enable necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Modify Apache configuration to allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Create a new user and group
RUN groupadd -g 1000 appuser && \
    useradd -m -u 1000 -g appuser -s /bin/bash appuser

# Copy backend code to container
COPY . .

# Set correct permissions
RUN chown -R appuser:appuser . && chmod -R 755 .

# Switch to the new user
USER appuser

# Expose port 80 for Apache
EXPOSE 80

# Start Apache (must be run as root)
USER root
CMD ["apache2-foreground"]
