# Use the official PHP image
FROM php:8.0-cli

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Expose port
EXPOSE 8080

# Start PHP server
CMD ["php", "-S", "0.0.0.0:8080"]
