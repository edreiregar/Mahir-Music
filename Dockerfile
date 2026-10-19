FROM php:8.2-apache

# Install ekstensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Aktifkan mod_rewrite untuk Apache (Penting agar route Laravel tidak 404)
RUN a2enmod rewrite

# Ubah DocumentRoot Apache agar langsung mengarah ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy semua file project Laravel ke dalam container server
COPY . /var/www/html

# Masuk ke direktori kerja
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

# Jalankan instalasi dependensi Laravel tanpa dev-dependencies
RUN composer install --no-dev --optimize-autoloader

# Berikan hak akses izin folder storage dan bootstrap agar tidak error permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
