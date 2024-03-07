FROM php:8.0

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer    

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y nodejs npm

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000