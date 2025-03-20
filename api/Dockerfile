# Use PHP 8.1 CLI as the base image
FROM php:8.1-cli

# Set working directory
WORKDIR /app

# Enable necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Create a new user and group
RUN groupadd -g 1000 appuser && \
    useradd -m -u 1000 -g appuser -s /bin/bash appuser

# Copy backend code to container
COPY . .

# Set correct permissions
RUN chown -R appuser:appuser . && chmod -R 755 .

# Switch to the new user
USER appuser

# Define the entry point for running PHP scripts
CMD ["php", "-S", "0.0.0.0:8000"]
