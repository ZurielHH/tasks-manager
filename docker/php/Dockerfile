FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    tzdata  \
    && apt-get clean

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN mkdir -p /var/www/html/data && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/data

ENV TZ=America/Mexico_City

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

RUN echo "date.timezone=America/Mexico_City" > /usr/local/etc/php/conf.d/timezone.ini

RUN mkdir -p /var/www/html/var/data

EXPOSE 9000