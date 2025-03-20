# Use Node.js for building the React app
FROM node:18 AS build

# Set working directory
WORKDIR /app

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm install --legacy-peer-deps  # Prevent dependency issues

# Copy the rest of the app's source code
COPY . .

# Build the React app
RUN npm run build

# Use PHP with Apache to serve the React app and API
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Enable necessary Apache modules
RUN a2enmod rewrite proxy proxy_http headers

# Copy the built React app from the previous stage
COPY --from=build /app/build/ /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Create a new non-root user
RUN groupadd -g 1000 appuser && \
    useradd -m -u 1000 -g appuser -s /bin/bash appuser

# Set permissions and switch to non-root user
RUN chown -R appuser:appuser /var/www/html
USER appuser

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable the new site configuration
USER root  
RUN a2ensite 000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache as the non-root user
USER appuser
CMD ["apache2-foreground"]
