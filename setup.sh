#!/bin/bash

apt update;

apt upgrade;

apt install php7.2 php7.2-mycrypt php7.2-mysql;

apt install apache2 mysql-server;

rm -rf /var/www/html/cse201;

git clone git://github.com/nickist/cse201.git /var/www/html/cse201;

mysql_secure_installation;

mysql -u root -p  -e "
USE mysql;
UPDATE mysql.user SET authentication_string='iuahf87shd9goisd9f8g' WHERE User='root';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.db WHERE Db='test' OR Db='test_%';
DROP DATABASE IF EXISTS thatzthebookdb;
CREATE DATABASE  thatzthebookdb;
FLUSH PRIVILEGES;
DROP USER IF EXISTS 'thatzthebookuser'@'localhost';
CREATE USER 'thatzthebookuser'@'localhost' IDENTIFIED BY 'aidhv87aHUBh8fh98yu';
GRANT ALL PRIVILEGES ON thatzthebookdb.* TO 'thatzthebookuser'@'localhost';
FLUSH PRIVILEGES;";

systemctl restart mariadb;

mysql -u thatzthebookuser -p[aidhv87aHUBh8fh98yu] thatzthebookdb < /var/www/html/cse201/databaseCreate.sql;

apt-get install software-properties-common
add-apt-repository ppa:certbot/certbot
apt-get update
apt-get install python-certbot-apache

certbot --apache -d thatzthebook.duckdns.org -d thatzthebook.duckdns.org


echo "please go to https://thatzthebook.duckdns.org/cse201 to access the site";
