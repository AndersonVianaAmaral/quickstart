#!/bin/bash
chown -R www-data:www-data .
composer install
php artisan key:generate
php artisan migrate
php-fpm