# Use Node.js for building the React app
FROM node:18 AS build

# Set working directory
WORKDIR /app

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm install --legacy-peer-deps  # Prevent dependency issues

# Copy the rest of the app's source code
COPY . .

# Build the app
RUN npm run build

# Use Nginx to serve the React app
FROM nginx:alpine

# Create a non-root user
RUN addgroup -g 1000 appgroup && adduser -D -u 1000 -G appgroup appuser

# Set working directory
WORKDIR /usr/share/nginx/html

# Copy the built React app from the previous stage
COPY --from=build /app/build .

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Set correct permissions
RUN chown -R appuser:appgroup /usr/share/nginx/html

# Switch to the new user
USER appuser

# Expose port 80
EXPOSE 80

# Start Nginx (must run as root)
USER root
CMD ["nginx", "-g", "daemon off;"]
