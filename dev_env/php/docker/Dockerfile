# Get PHP
FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
  libzip-dev \
  unzip \
  && docker-php-ext-configure zip \
  && docker-php-ext-install pdo_mysql zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Install Redis extensions
RUN pecl install redis && docker-php-ext-enable redis

# Copy PHP configuration file
COPY ./dev_env/php/conf/php.ini /usr/local/etc/php/

# Install Composer 2
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x /usr/local/bin/composer

# Copy app files to the container
COPY . .

# Get composer autoloader
RUN composer install
RUN composer dump-autoload --optimize

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
  apt-get install -y nodejs && \
  npm install -g sass

# Enable rewriting
RUN a2enmod rewrite