# Use the official WordPress image as a base
FROM wordpress:latest

# Copy your WordPress files over
# Assuming Dockerfile is in the project root; adjust the path if it's inside the wordpress directory
COPY wordpress /var/www/html

# Optional: If you have custom plugins or themes, make sure they're included in the wordpress/wp-content directory
COPY wordpress/wp-content/plugins /var/www/html/wp-content/plugins
COPY wordpress/wp-content/themes /var/www/html/wp-content/themes

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Note: Configuration through wp-config.php or environment variables

