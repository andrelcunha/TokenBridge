#!/bin/sh
cd /var/www/

php artisan wait_db_alive && php artisan migrate:fresh --seed
php artisan serve --host=0.0.0.0 --port=8000