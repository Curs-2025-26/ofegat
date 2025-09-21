# --- Stage 1: Composer (per copiar binari) ---
FROM composer:2 AS composer_stage

# --- Stage 2: PHP-FPM ---
FROM php:8.3-fpm

# Paquets de sistema (consolidat i net)
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev libicu-dev zlib1g-dev git unzip \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP comunes
RUN docker-php-ext-install -j$(nproc) \
        zip intl mbstring opcache

# Xdebug (opcional). Deixa'l instal·lat però l’habilites amb ini separat
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copia Composer del stage oficial
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Config bàsica de PHP (error reporting, etc.)
RUN { \
      echo "display_errors=1"; \
      echo "display_startup_errors=1"; \
      echo "error_reporting=E_ALL"; \
      echo "memory_limit=512M"; \
      echo "post_max_size=10M"; \
      echo "upload_max_filesize=10M"; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Xdebug desactivat per defecte; activa-ho amb un fitxer ini en dev
# (si uses docker compose amb perfil 'dev', munta un xdebug.ini)
# Exemple d’un xdebug.ini per a dev:
#   zend_extension=xdebug
#   xdebug.mode=debug,develop
#   xdebug.start_with_request=trigger
#   xdebug.client_host=host.docker.internal
#   xdebug.client_port=9003

WORKDIR /var/www/php
