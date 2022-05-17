FROM php:8.0.2-apache
# Arguments defined in docker-compose.yml
ARG user
ARG uid
RUN apt-get update && apt-get install -y libmagickwand-dev libzip-dev zip libmcrypt-dev mariadb-client --no-install-recommends && rm -rf /var/lib/apt/lists/*
# install imagick
# Version is not officially released https://pecl.php.net/get/imagick but following works for PHP 8
RUN mkdir -p /usr/src/php/ext/imagick; \
    curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
    docker-php-ext-install imagick;
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

RUN a2enmod rewrite
COPY .000-default.conf /etc/apache2/sites-available/000-default.conf

RUN pecl install xdebug-3.0.4 && docker-php-ext-enable xdebug
RUN echo "[xdebug]\n" \
         # "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20200930/xdebug.so\n" \
         "xdebug.start_with_request=yes\n" \
         "xdebug.discover_client_host=1\n" \
         "xdebug.idekey=VSCODE\n" \
         "xdebug.remote_handler=dbgp\n" \
         "xdebug.profiler_enable=off\n" \
         "xdebug.output_dir=\"/app\"\n" \
         "xdebug.client_port=9003\n" \
         "xdebug.client_host=host.docker.internal\n" \
         "xdebug.mode=develop,debug" > /usr/local/etc/php/conf.d/xdebug.ini
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
#add npm
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh && bash nodesource_setup.sh && apt-get -y --force-yes install nodejs
# Set working directory
WORKDIR /app
USER $user
