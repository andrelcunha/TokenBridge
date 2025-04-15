FROM php:8.4-fpm

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev && \
    docker-php-ext-install pdo_pgsql

WORKDIR /var/www

# Install Composer (directly in this build stage)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code (including artisan)
COPY task-service .
COPY shared /var/shared
COPY ./run.sh /tmp

# Rename .env.production to .env
RUN cp .env.production .env

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist --no-interaction

# Set application permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www

RUN chmod +x /tmp/run.sh

EXPOSE 8000

# Start Laravel's development server
# CMD php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000
CMD [ "/tmp/run.sh" ]
