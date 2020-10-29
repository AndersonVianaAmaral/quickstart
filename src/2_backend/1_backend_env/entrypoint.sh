#!/bin/bash
dockerize -template ./1_backend_env/.env:.env -wait tcp://db:3306 -timeout 40s
chown -R www-data:www-data .
composer install
php artisan key:generate
php artisan migrate
php-fpm