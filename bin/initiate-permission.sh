#!/bin/sh
chown -R 1000:1000 .
touch storage/logs/laravel.log
chmod -R 775 database/ resources/ database/ config/ bootstrap/
chmod -R 777 storage/
composer update
composer dump-autoload
php artisan cache:clear
php artisan config:cache
