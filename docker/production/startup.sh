#!/usr/bin/env sh

# [ ! -e .env ] && cp .env.docker .env
sed "s/FRONTEND_HOST/$FRONTEND_HOST/g" /var/www/html/docker/production/grimm.conf > /var/www/html/docker/production/tmp.conf
sed "s/BACKEND_HOST/$BACKEND_HOST/g" /var/www/html/docker/production/tmp.conf > /var/www/html/docker/production/site.conf

# wait for mariadb
chmod +x /var/www/html/docker/production/wait-for-it.sh

echo "Connecting to: $DB_HOST:$DB_PORT \n"
/var/www/html/docker/production/wait-for-it.sh -t 0 $DB_HOST:$DB_PORT

[ $? -eq 0 ] || exit $?;

[ ! -e storage/purify ] && mkdir storage/purify

php artisan grimm:deploy

supervisord -c /etc/supervisor/supervisord.conf