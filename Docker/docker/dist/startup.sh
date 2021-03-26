#!/usr/bin/env sh

# [ ! -e .env ] && cp .env.docker .env

chmod +x /var/www/html/docker/dist/wait-for-it.sh

echo "Connecting to: $DB_HOST:$DB_PORT \n"
/var/www/html/docker/dist/wait-for-it.sh -t 0 $DB_HOST:$DB_PORT

[ $? -eq 0 ] || exit $?;

php artisan trax:boot

supervisord -c /etc/supervisor/supervisord.conf