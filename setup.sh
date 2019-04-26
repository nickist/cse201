#!/bin/bash         

apt update;
apt upgrade;
apt install php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-mcrypt;
apt install apache2;
apt install mysql-server php7.2-mysql;
git clone git@gitlab.csi.miamioh.edu:hongh/cse201.git /var/www/html;
echo Start Executing SQL commands
sqlplus thatztheapp/<Your-password> @databaseCreate.sql
