#!/usr/bin/env bash

rm -rf /var/www/html/var/cache
rm -rf /var/www/html/var/logs
rm -rf /var/www/html/var/sessions

mkdir -p /var/www/html/var/cache
mkdir -p /var/www/html/var/cache/dev
mkdir -p /var/www/html/var/cache/prod
mkdir -p /var/www/html/var/logs
mkdir -p /var/www/html/var/sessions

chmod 777 /var/www/html/var
chmod -R 777 /var/www/html/var/cache
chmod -R 777 /var/www/html/var/logs
chmod -R 777 /var/www/html/var/sessions

chown -R www-data:1000 /var/www/html/