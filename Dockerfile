#
# Application
#
FROM ubuntu:20.04

WORKDIR /var/www/html

RUN apt-get update

# Add mariadb repository for mariadb-client
RUN apt-get install curl -yqq
RUN curl https://downloads.mariadb.com/MariaDB/mariadb_repo_setup --output mariadb_repo_setup
RUN echo "fd3f41eefff54ce144c932100f9e0f9b1d181e0edd86a6f6b8f2a0212100c32c mariadb_repo_setup" \
    | sha256sum -c -
RUN chmod +x mariadb_repo_setup
RUN ./mariadb_repo_setup \
   --mariadb-server-version="mariadb-10.6"

# Install packages
RUN apt-get update && apt-get install software-properties-common -yqq --no-install-recommends && add-apt-repository ppa:ondrej/php && apt-get update && apt-get install mariadb-client php8.0 nginx supervisor ca-certificates \
        php8.0-fpm php8.0-curl php8.0-mbstring php8.0-mysql php8.0-xml php8.0-gd php8.0-ldap php8.0-zip php8.0-redis php8.0-bcmath \
         -yqq --no-install-recommends \
          && rm -rf /var/lib/apt/lists/*

# Install supercronic
ENV SUPERCRONIC_URL=https://github.com/aptible/supercronic/releases/download/v0.1.12/supercronic-linux-amd64 \
    SUPERCRONIC=supercronic-linux-amd64 \
    SUPERCRONIC_SHA1SUM=048b95b48b708983effb2e5c935a1ef8483d9e3e

RUN php -r "copy('$SUPERCRONIC_URL', '$SUPERCRONIC');" \
 && echo "${SUPERCRONIC_SHA1SUM}  ${SUPERCRONIC}" | sha1sum -c - \
 && chmod +x "$SUPERCRONIC" \
 && mv "$SUPERCRONIC" "/usr/local/bin/${SUPERCRONIC}" \
 && ln -s "/usr/local/bin/${SUPERCRONIC}" /usr/local/bin/supercronic

# Write nginx log too stdout and stderr, prepare default site location
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# Store pid file in an accessible directory and redirect errors to stderr
RUN sed -i -e "s/pid =.*/pid = \/var\/supervisor\/pid\/php8.0-fpm.pid/" /etc/php/8.0/fpm/php-fpm.conf
RUN sed -i -e "s/error_log =.*/error_log = \/proc\/self\/fd\/2/" /etc/php/8.0/fpm/php-fpm.conf
# Run fpm as a front process instead of daemon
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/8.0/fpm/php-fpm.conf
# Pass environment variables from container to scripts
RUN sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /etc/php/8.0/fpm/pool.d/www.conf
# Move FPM unix socket to an accessible directory
RUN sed -i -e "s/listen\s*=.*/listen = \/var\/supervisor\/sockets\/php8.0-fpm.sock/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/;php_admin_flag\[log_errors\]\s*=\s*on/php_admin_flag[log_errors] = on/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/;decorate_workers_output\s*=\s*no/decorate_workers_output = no/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/pm.max_children\s*=\s*5/pm.max_children = 15/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/pm.min_spare_servers\s*=\s*1/pm.min_spare_servers = 6/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/pm.max_spare_servers\s*=\s*3/pm.max_spare_servers = 10/g" /etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i -e "s/pm.start_servers\s*=\s*2/pm.start_servers = 8/g" /etc/php/8.0/fpm/pool.d/www.conf

# Create intermediate file structure for no-root setup
RUN mkdir -p /var/supervisor/logs && mkdir -p /var/supervisor/sockets && mkdir -p /var/supervisor/pid \
    && chown -R www-data:www-data /var/supervisor

# Enable cronjob for Laravel Task Scheduling
RUN echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/crontab

# Set the maximum upload size pretty high for PHP to allow fine grained control via the load balancer.
RUN echo "upload_max_filesize = 100M" > /etc/php/8.0/fpm/conf.d/90-grimm.ini

# Copy grimm build files
COPY --chown=www-data:www-data . /var/www/html

# Nginx configuration
COPY docker/production/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/production/nginx.conf /etc/nginx/nginx.conf
RUN ln -sf /var/www/html/docker/production/site.conf /etc/nginx/sites-available/default && chown -R www-data:www-data /var/www/html && rm -rf index.nginx-debian.html

USER www-data

# fix missing view chache dir
RUN mkdir -p /var/www/html/storage/framework/views

RUN APP_ENV=production php artisan package:discover

RUN rm -rf /var/www/html/storage
RUN rm -rf /var/www/html/public/media

EXPOSE 8080

CMD ["sh", "/var/www/html/docker/production/startup.sh"]