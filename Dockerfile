# Use the official WordPress image as a parent image
FROM wordpress:php7.4-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY wordpress/ /var/www/html/

# Optionally, customize PHP.ini settings (e.g., upload_max_filesize)
# COPY custom-php.ini /usr/local/etc/php/conf.d/

