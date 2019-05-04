#!/bin/bash

apt update;

apt upgrade;

apt install php7.2 php7.2-mycrypt php7.2-mysql;

apt install apache2 mysql-server;

rm -rf /var/www/html/cse201;

git clone git://github.com/nickist/cse201.git /var/www/html/cse201;

rm /var/www/html/cse201/config.php;

cp ~/config.php /var/www/html/cse201;

mysql -u thatzthebookuser -p  < /var/www/html/cse201/databaseCreate.sql

echo "please go to https://thatzthebook.duckdns.org/cse201 to access the site";
