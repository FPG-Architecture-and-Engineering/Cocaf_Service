# Use the official PHP image with Apache
FROM php:8.2-apache

# Enable commonly used PHP extensions (optional)
RUN docker-php-ext-install pdo pdo_mysql mysqli
COPY . .

# Enable Apache mod_rewrite (optional)
RUN a2enmod rewrite
# RUN apt-get update && apt-get install -y \
#         libldap2-dev \
#     && rm -rf /var/lib/apt/lists/* \
#     && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
#     && docker-php-ext-install ldap

# Expose Apache's port
EXPOSE 80

# Default command to run Apache in foreground
CMD ["apache2-foreground"]


# Use the Alpine-based PHP 8.2 Apache image
# FROM php:8.2-fpm-alpine

# # Install dependencies
# RUN apk --no-cache add \
#         openldap-dev \
#         libldap \
#         icu-dev \
#         oniguruma-dev \
#         git \
#         bash \
#     && docker-php-ext-install \
#         pdo \
#         pdo_mysql \
#         mysqli \
#         ldap \
#     && rm -rf /var/cache/apk/*

# # Copy application code
# COPY . /var/www/html/

# # Set working directory
# WORKDIR /var/www/html/

# # Expose PHP-FPM port
# EXPOSE 9000

# # Default command to run PHP-FPM
# CMD ["php-fpm"]

