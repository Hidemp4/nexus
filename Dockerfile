FROM php:8.3.6-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        bcmath \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

# 👇 IMPORTANTE
RUN mkdir -p database && touch database/database.sqlite

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}