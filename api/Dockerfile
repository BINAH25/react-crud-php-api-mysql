# Use a smaller PHP base image
FROM php:8.1-alpine

# Set working directory
WORKDIR /app

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install AWS SDK for PHP
COPY composer.json composer.lock ./
RUN apt-get update && apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Create a new user and group
RUN addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser -s /bin/sh appuser

# Copy backend code to container
COPY --chown=appuser:appuser . .

# Switch to the new user
USER appuser

# Expose port 8000
EXPOSE 8000

# Define the entry point for running PHP scripts
CMD ["php", "-S", "0.0.0.0:8000"]
