# Gunakan image resmi PHP 8.2 dengan Apache
FROM php:8.2-apache

# Atur direktori kerja dalam container
WORKDIR /var/www/html

# Install extensions yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file dari project ke direktori kerja
COPY . .

# Copy file konfigurasi Apache untuk Laravel
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Atur permission pada direktori Laravel
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Jalankan Composer install untuk menginstall dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy file environment
COPY .env.example .env

# Generate application key
RUN php artisan key:generate

# Expose port 80
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
