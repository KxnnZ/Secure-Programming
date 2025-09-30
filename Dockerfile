FROM php:8.2-fpm

# pasang ekstensi mysql untuk Laravel
RUN docker-php-ext-install pdo_mysql

# opsional: tambahkan composer supaya bisa jalan di container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
