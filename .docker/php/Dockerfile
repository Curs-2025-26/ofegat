FROM composer:2 AS composer_stage
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
      libzip-dev libicu-dev zlib1g-dev git unzip curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j"$(nproc)" zip intl mbstring opcache
# Instal·la Xdebug però NO l’activa al base; s’activarà amb l’ini del perfil dev
RUN pecl install xdebug

COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Config PHP bàsica
RUN { \
      echo "display_errors=1"; \
      echo "display_startup_errors=1"; \
      echo "error_reporting=E_ALL"; \
      echo "memory_limit=512M"; \
      echo "post_max_size=10M"; \
      echo "upload_max_filesize=10M"; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Habilita ping/status de FPM (per healthcheck)
RUN { \
      echo "ping.path = /fpm-ping"; \
      echo "pm.status_path = /fpm-status"; \
    } > /usr/local/etc/php-fpm.d/zz-ping.conf

# Mini server per respondre /fpm-ping via HTTP (port 9001)
RUN echo '<?php header("Content-Type:text/plain"); echo "pong";' > /fpm-ping.php
CMD php -S 0.0.0.0:9001 /fpm-ping.php & php-fpm

WORKDIR /var/www/php