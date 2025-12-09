#!/usr/bin/env bash
set -e

# Move to app
cd /var/www/html

# If no APP_KEY, generate one
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" == "" ]]; then
  php artisan key:generate --force || true
fi

# Cache config/views if possible (non-fatal)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache in foreground
apache2-foreground

