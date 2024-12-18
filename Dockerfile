FROM dunglas/frankenphp

# Update package list and install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libpng-dev \
  libjpeg-dev \
  libwebp-dev \
  libxpm-dev \
  libfreetype6-dev \
  libzip-dev \
  zip \
  unzip \
  git \
  bash \
  fcgiwrap \
  libmcrypt-dev \
  libonig-dev \
  libpq-dev \
  default-mysql-client \
  nano \
  && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install gd \
  && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath opcache

# Install Composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Ganti direktori tempat kita run command
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Generate autoload and optimize
RUN composer dump-autoload --optimize

# Set ownership and permissions for the /var/www/html directory to www-data
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html/storage

USER www-data

EXPOSE 9000

CMD ["php", "artisan", "octane:frankenphp", "--workers=4", "--max-requests=500"]