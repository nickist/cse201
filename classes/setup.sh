#!/bin/bash          


sudo apt update;
sudo apt upgrade;
sudo apt install php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-mcrypt;
sudo apt install apache2;
sudo apt install mysql-server php7.2-mysql;
git clone git@gitlab.csi.miamioh.edu:hongh/cse201.git /var/www/html;
echo Start Executing SQL commands
sqlplus thatztheapp/<password> @databaseCreate.sql

