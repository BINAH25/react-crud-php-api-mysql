# First stage: Build React app using a minimal Node.js image
FROM node:22-alpine AS build

# Set working directory
WORKDIR /app

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm ci --legacy-peer-deps  # Ensures a clean, reproducible install

# Copy the rest of the app's source code
COPY . .

# Build the React app
RUN npm run build

# Second stage: Use nginx to serve the built frontend
FROM nginx:alpine

# Set working directory
WORKDIR /usr/share/nginx/html

# Create a new non-root user
RUN addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser -s /bin/bash appuser

# Copy build output from the previous stage
COPY --from=build /app/build /usr/share/nginx/html

# Copy custom Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# give permissions for necessary directories
RUN chown -R appuser:appuser /etc/nginx/conf.d/default.conf /usr/share/nginx/html /var/cache/nginx /var/run /var/log/nginx \
    && chmod -R 777 /var/cache/nginx /var/run /var/log/nginx

# Switch to the new user
USER appuser

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
