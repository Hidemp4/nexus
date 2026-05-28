FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


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

RUN composer install --no-dev --optimize-autoloader

COPY --from=frontend /app/public/build ./public/build

RUN rm -f public/hot

RUN mkdir -p database && touch database/database.sqlite

EXPOSE 8000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]