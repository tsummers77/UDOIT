FROM php:7.3-fpm-alpine
     
     RUN apk --no-cache --update add \
         openrc \
         apk-cron \
         zip \
         unzip \
         autoconf \
         git \
         freetype-dev \
         libjpeg-turbo-dev \
         libpng-dev \
         postgresql-dev \
         wget \
         gnupg \
         nginx \
         && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
         && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
         && docker-php-ext-install \
         gd \
         pdo_mysql \
         pdo \
         pgsql \
         pdo_pgsql
     
     WORKDIR /var/www/html
     COPY . .
     RUN php composer.phar install
     
     # setup nginx, background worker monitor and crontab
     # ---------------------
     RUN mkdir -p /run/nginx \
         && mv psu/default.conf /etc/nginx/conf.d/ \
         && mv psu/udoit-worker-monitor /usr/bin/ \
         && chmod +x /usr/bin/udoit-worker-monitor \
         && mv psu/udoit-crontab /etc/crontabs/ \
         && chmod 600 /etc/crontabs/udoit-crontab \
         && crontab /etc/crontabs/udoit-crontab
     
     # Startup
     # --------------------------------
     WORKDIR /etc/local.d
     RUN printf '#!/bin/sh \n\
              crond -b -d 0 \n\
              php-fpm -D \n\
              nginx -g "daemon off;"' > udoit.start \
         && chmod +x udoit.start
     
     ENTRYPOINT ["/etc/local.d/udoit.start"]