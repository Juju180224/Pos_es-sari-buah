FROM php:8.2-fpm

# =========================
# System dependencies
# =========================
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip

# =========================
# PHP Extensions
# =========================
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# =========================
# Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# App directory
# =========================
WORKDIR /var/www

COPY . .

# =========================
# Install dependencies
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# Permissions
# =========================
RUN chmod -R 775 storage bootstrap/cache

# =========================
# Copy configs
# =========================
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/php.ini
COPY start.sh /start.sh

RUN chmod +x /start.sh

# =========================
# Laravel optimizations
# =========================
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 8080

CMD ["/start.sh"]