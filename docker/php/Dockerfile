FROM php:8.5-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    tzdata  \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENV TZ=America/Mexico_City

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

RUN echo "date.timezone=America/Mexico_City" > /usr/local/etc/php/conf.d/timezone.ini

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]