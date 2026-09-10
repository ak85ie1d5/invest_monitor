FROM php:8.5-apache

# Install packages from Aptitude
RUN apt-get update && apt-get install -y --no-install-recommends \
    ghostscript \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmagickwand-dev \
    libpng-dev \
    libxslt1-dev \
    libwebp-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    inotify-tools \
    && rm -rf /var/lib/apt/lists/*

# Configure libraries with Docker PHP extention package
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Install libraries with Docker PHP extention package
# (docker-php-ext-install enables the extensions automatically)
# opcache is omitted on purpose: since PHP 8.5 it is compiled statically into
# the binary, so it can neither be installed nor enabled as a shared module.
# It is configured through the [opcache] section of Docker/php/php.ini.
RUN docker-php-ext-install -j$(nproc) \
    pcntl \
    bcmath \
    exif \
    gd \
    intl \
    mysqli \
    pdo_mysql \
    zip \
    xsl

# Install packages from PECL
RUN pecl install imagick \
    && pecl install xdebug \
    && pecl install apcu

# Enable PECL extensions. Extensions built with docker-php-ext-install are
# enabled automatically.
RUN docker-php-ext-enable imagick xdebug apcu

ENV SYMFONY_ROOT /var/www/html

# change default Apache2 document root
ENV APACHE_DOCUMENT_ROOT ${SYMFONY_ROOT}/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY Docker/php/symfony.conf /etc/apache2/conf-available/symfony.conf

# Enable Apache2 modules
RUN a2enmod rewrite expires headers \
    && a2enconf symfony

# Install Symfony-CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv ${HOME}/.symfony5/bin/symfony /usr/local/bin/symfony

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install NodeJS
# COPY --from=node:lts-bookworm /usr/local/bin /usr/local/bin
# COPY --from=node:lts-bookworm /usr/local/lib/node_modules /usr/local/lib/node_modules
# COPY --from=node:lts-bookworm /opt /opt

###> symfony/panther ###
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        chromium \
        chromium-driver \
    && rm -rf /var/lib/apt/lists/*
###< symfony/panther ###

# Add and enable SSL/TLS certificate
RUN set -eux; \
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=FR/ST=France/L=Chantilly/O=Business Profilers/OU=BP Team Web/CN=businessprofilers.local"; \
	chmod 777 /etc/ssl/private; \
	chmod 777 /etc/ssl/private/ssl-cert-snakeoil.key; \
	a2enmod ssl; \
	a2ensite default-ssl

WORKDIR ${SYMFONY_ROOT}
VOLUME ${SYMFONY_ROOT}

RUN useradd -m devmaster

# Set entrypoint
COPY Docker/php/local-deploy.sh /usr/local/bin/local-deploy
RUN chmod +x /usr/local/bin/local-deploy
COPY Docker/php/asset-map-watch.sh /usr/local/bin/asset-map-watch
RUN chmod +x /usr/local/bin/asset-map-watch
ENTRYPOINT ["local-deploy"]

CMD ["apache2-foreground"]
