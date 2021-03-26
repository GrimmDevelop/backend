#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    exec php-fpm
elif [ "$role" = "queue" ]; then
    php artisan queue:listen --verbose --tries=3 --timeout=90
elif [ "$role" = "scheduler" ]; then
    while [ true ]
    do
        php artisan schedule:run --verbose --no-interaction &
        sleep 60
    done
else
    echo "Unknown role"
    exit 1
fi
