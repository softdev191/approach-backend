#!/bin/sh
composer dump-autoload
php artisan cache:clear
php artisan config:cache
