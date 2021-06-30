FROM alpine:3.13

LABEL maintainer="Apfelwurm<Alexander@volzit.de>"
ARG PHP_VERSION="8.0.6-r0"
ARG PHP_Timezone="UTC"

ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk --no-cache add php8=${PHP_VERSION} \
    php8-ctype \
    php8-curl \
    php8-dom \
    php8-exif \
    php8-fileinfo \
    php8-fpm \
    php8-gd \
    php8-iconv \
    php8-intl \
    php8-mbstring \
    php8-mysqli \
    php8-opcache \
    php8-openssl \
    php8-pecl-imagick \
    php8-pecl-redis \
    php8-phar \
    php8-session \
    php8-simplexml \
    php8-soap \
    php8-xml \
    php8-xmlreader \
    php8-zip \
    php8-zlib \
    php8-pdo \
    php8-xmlwriter \
    php8-tokenizer \
    php8-pdo_mysql \
    nginx supervisor curl tzdata htop dcron bash

RUN rm /etc/nginx/conf.d/default.conf

# Symlink php8 => php
RUN ln -s /usr/bin/php8 /usr/bin/php

COPY docker_prd/nginx.conf /etc/nginx/nginx.conf
COPY docker_prd/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
COPY docker_prd/php.ini /etc/php8/conf.d/99-openinnovacdr.ini
COPY docker_prd/start-container /usr/local/bin/start-container
COPY docker_prd/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker_prd/wait-for.sh /usr/local/bin/wait-for.sh
COPY docker_prd/start-supervisord /usr/local/bin/start-supervisord

RUN sed -i "s|%REPLACETIMEZONE%|${PHP_Timezone}|g" /etc/php8/conf.d/99-openinnovacdr.ini

RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/wait-for.sh
RUN chmod +x /usr/local/bin/start-supervisord

# Set working directory
WORKDIR /var/www/html

RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

USER nobody
WORKDIR /var/www/html
COPY --chown=nobody . /var/www/html/

RUN rm -rf /var/www/html/docker*

EXPOSE ${NGINX_PORT}

ENTRYPOINT ["start-container"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=20s CMD curl --silent --fail http://127.0.0.1:${NGINX_PORT}/fpm-ping
