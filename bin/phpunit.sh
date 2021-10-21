#!/bin/sh

if [ $1 -gt 0 ]
then
        if [ $2 -gt 0 ]
        then
            rm test.html && vendor/phpunit/phpunit/phpunit --filter $3 >> test.html
            echo "Access this to browser: file:///var/www/customer/test.html"
            echo "Test success"
        else
            rm test.html && vendor/phpunit/phpunit/phpunit >> test.html
            echo "Access this to browser: file:///var/www/customer/test.html"
            echo "Test success"
        fi

else
        if [ $2 -gt 0 ]
        then
            vendor/phpunit/phpunit/phpunit --filter $3
        else
            vendor/phpunit/phpunit/phpunit
        fi
fi


