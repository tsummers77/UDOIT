# Generate a single Docker container running Nginx/PHP
# Notes:
# - Leading dollar signs ($) need to be escaped to prevent build errors 
FROM php:7.3-fpm-alpine

RUN apk --no-cache --update add \
    openrc \
    apk-cron \
    zip \
    unzip \
    autoconf \
    build-base \
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

# DEBUG packages
RUN apk --no-cache add \
    iputils

WORKDIR /var/www/html
COPY . .

RUN php composer.phar install
#RUN cat /var/www/html/public/index.php # DEBUG

# ---------------------------------------------------------
# Docker Development setup SSL
# ---------------------------------------------------------
RUN mkdir -p /etc/ssl/private && \
    mv local_certs/nginx-selfsigned.key /etc/ssl/private && \
    mkdir -p /etc/ssl/certs && \
    mv local_certs/nginx-selfsigned.crt /etc/ssl/certs && \
    mv local_certs/dhparam.pem /etc/ssl/certs && \
    mkdir -p /etc/nginx/snippets && \
    mv local_certs/self-signed.conf /etc/nginx/snippets && \
    mv local_certs/ssl-params.conf /etc/nginx/snippets

# Create directories for SSL settings
RUN mkdir -p /etc/ssl/private && mkdir -p /etc/ssl/certs && mkdir -p /etc/nginx/snippets

# Create self-signed cert with subj settings
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt -subj '/CN=localhost/O=Penn State/C=US/ST=Pennsylvania/L=State College'
# RUN openssl x509 -in /etc/ssl/certs/nginx-selfsigned.crt -text -noout # DEBUG Dump cert we just created

# Create a strong Diffie-Hellman group
RUN openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048

# Create a Configuration Snippet Pointing to the SSL Key and Certificate
RUN printf 'ssl_certificate /etc/ssl/certs/nginx-selfsigned.crt; ssl_certificate_key /etc/ssl/private/nginx-selfsigned.key;' > /etc/nginx/snippets/self-signed.conf
#RUN cat /etc/nginx/snippets/self-signed.conf # DEBUG Dump self-signed.conf

# # Create a Configuration Snippet with Strong Encryption Settings
# RUN printf '# from https://cipherli.st/ \n\
# # and https://raymii.org/s/tutorials/Strong_SSL_Security_On_nginx.html \n\
# \n\
# ssl_protocols TLSv1 TLSv1.1 TLSv1.2; \n\
# ssl_prefer_server_ciphers on; \n\
# ssl_ciphers "EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH"; \n\
# ssl_ecdh_curve secp384r1; \n\
# #ssl_session_cache shared:SSL:10m; \n\
# ssl_session_tickets off; \n\
# ssl_stapling on; \n\
# ssl_stapling_verify on; \n\
# resolver 8.8.8.8 8.8.4.4 valid=300s; \n\
# resolver_timeout 5s; \n\
# # Disable preloading HSTS for now.  You can use the commented out header line that includes \n\
# # the "preload" directive if you understand the implications. \n\
# #add_header Strict-Transport-Security "max-age=63072000; includeSubdomains; preload"; \n\
# add_header Strict-Transport-Security "max-age=63072000; includeSubdomains"; \n\
# #add_header X-Frame-Options ALLOW; \n\
# add_header Content-Security-Policy "frame-src 'worldcampus.instructure.com:443';" always; \n\
# add_header X-Content-Type-Options nosniff; \n\
# \n\
# ssl_dhparam /etc/ssl/certs/dhparam.pem;' > /etc/nginx/snippets/ssl-params.conf
# #RUN cat /etc/nginx/snippets/ssl-params.conf # DEBUG Dump ssl-params.conf

# nginx configuration
# ---------------------
WORKDIR /etc/nginx/conf.d
RUN mkdir -p /run/nginx \
        && printf 'server { \n\
        listen 8080 default_server; \n\
        listen [::]:8080 default_server; \n\
        server_name localhost; \n\
\n\
        return 302 https://$server_name$request_uri; # SSL \n\
    } # SSL \n\
\n\
    server { \n\
        listen 443 ssl http2 default_server; # SSL \n\
        listen [::]:443 ssl http2 default_server; # SSL \n\
        include snippets/self-signed.conf; # SSL \n\
        include snippets/ssl-params.conf; # SSL \n\
     \n\
        index index.php index.html; \n\
        error_log  /var/log/nginx/error.log debug; \n\
        access_log /var/log/nginx/access.log; \n\
        root /var/www/html/public; \n\
 \n\
        location ~ [^/]\.php(/|$) { \n\
# try_files \$uri =404; \n\
            fastcgi_split_path_info ^(.+?\.php)(/.*)$; \n\
            fastcgi_param HTTP_PROXY \"\"; \n\
            fastcgi_pass localhost:9000; \n\
            fastcgi_index index.php; \n\
            include fastcgi_params; \n\
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
            fastcgi_param PATH_INFO $fastcgi_path_info; \n\
            fastcgi_read_timeout 3600; \n\
        } \n\
    }' > default.conf
#RUN cat /etc/nginx/conf.d/default.conf # DEBUG Dump default.conf
# ---------------------------------------------------------------------------------------------
# Setup cron job to keep worker.php up and running
# https://stackoverflow.com/questions/37015624/how-to-run-a-cron-job-inside-a-docker-container
# ----------
RUN printf '---\n' > /var/log/udoit-worker-monitor.log

WORKDIR /etc/crontabs
COPY udoit-crontab .
RUN chmod 600 udoit-crontab \
        && crontab udoit-crontab

WORKDIR /usr/bin
COPY udoit-worker-monitor .

#RUN ls /etc/init.d

# ---------------------------------------------------------------------------------------------
# Setup startup
# ---------------------------------------------------------------------------------------------

WORKDIR /etc/local.d
RUN printf '#!/bin/sh \n\
         /usr/sbin/crond -b -d 0 \n\
         /usr/local/sbin/php-fpm -D \n\
         nginx -g "daemon off;"' > udoit.start \
    && chmod +x udoit.start
#RUN cat /etc/nginx/fastcgi_params # DEBUG

ENTRYPOINT ["/etc/local.d/udoit.start"]