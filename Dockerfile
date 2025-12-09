# Multi-stage Dockerfile for Laravel (Apache + PHP 8.2) with Vite assets

# 1) Composer dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock /app/
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# 2) Build frontend assets
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json /app/
RUN npm ci --no-progress
COPY resources /app/resources
COPY vite.config.* /app/
COPY tailwind.config.* /app/
COPY postcss.config.* /app/
RUN npm run build

# 3) Final image (Apache + PHP)
FROM php:8.2-apache

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite and set DocumentRoot to public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN a2enmod rewrite && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Copy Composer vendor and built assets
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=assets /app/dist /var/www/html/public/build

# Prepare storage permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Optional: Create sqlite database file if DB is not configured
RUN mkdir -p database && touch database/database.sqlite && chown www-data:www-data database/database.sqlite

# Health check (optional)
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s CMD curl -f http://localhost/ || exit 1

# Expose Apache port
EXPOSE 80

# Entrypoint script to set APP_KEY if missing and run migrations in safe mode
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["/usr/local/bin/entrypoint.sh"]
