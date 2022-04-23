#!/bin/bash

composer install

sleep 30 # wait for mysql is up

php artisan migrate
