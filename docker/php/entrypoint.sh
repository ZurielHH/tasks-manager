#!/usr/bin/env sh
set -eu

APP_DIR="/var/www/html"
VAR_DIR="$APP_DIR/var"
DB_FILE="$VAR_DIR/data/tasks.db"

mkdir -p "$APP_DIR/data" "$VAR_DIR/data" "$VAR_DIR/log" "$VAR_DIR/cache"

chown -R www-data:www-data "$APP_DIR/data" "$VAR_DIR"
chmod -R 775 "$APP_DIR/data" "$VAR_DIR"

if [ -f "$APP_DIR/composer.json" ] && [ ! -d "$APP_DIR/vendor" ]; then
  composer install --no-interaction --prefer-dist
fi

if [ ! -f "$DB_FILE" ]; then
  if [ -f "$APP_DIR/doctrine" ] && [ -d "$APP_DIR/vendor" ]; then
    php "$APP_DIR/doctrine" orm:schema-tool:create
  fi
fi

exec "$@"
