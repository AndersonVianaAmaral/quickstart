#!/bin/bash
dockerize -template ./1_backend_env/.env:.env -template ./1_backend_env/.env.testing:.env.testing  -wait tcp://db:3306 -timeout 40s
chown -R www-data:www-data .
composer install
php artisan key:generate
php artisan migrate --seed
php-fpm