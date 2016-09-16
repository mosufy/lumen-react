#!/usr/bin/env bash

#
# Server build script -- run once per server
#
# Designed to run on a CentOS 6 minimal install
#

#
# Variables
#
APPNAME=lumenapi
DBHOST=localhost
DBNAME=lumenapi
DBUSER=lumenapi
DBPASS=password
DBAPASS=rootpassword
BASEPATH=$PWD

##################################################################################
#
# Common section
#
##################################################################################

#
# Failsafe nameserver
#
echo "nameserver 8.8.8.8" >> /etc/resolv.conf

#
# Install a few useful basic RPMs
#
echo "Install some useful basic RPMs"
yum -y install sysstat wget ntp bind-utils zip unzip rsync openssh-clients mlocate telnet
chmod +x /etc/cron.daily/mlocate.cron

#
# Generate SSH Key for vagrant
#
ssh-keygen -t rsa -N "" -f ~/.ssh/id_rsa

#
# Change the permission
#
chmod 600 ~/.ssh/id_rsa
chmod 644 ~/.ssh/id_rsa.pub

#
# Set to UTC -- change the timezone specifier below to the
# timezone that you want to use.
#
echo "Set time zone UTC"
echo 'ZONE="UTC"' > /etc/sysconfig/clock
ln -sf /usr/share/zoneinfo/UTC /etc/localtime

#
# Install and enable the EPEL and Webtatic repos.
#
echo "Install EPEL and Webtatic repos"
rpm -Uvh http://dl.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
yum -y upgrade ca-certificates --disablerepo=epel
yum clean all
yum makecache

##################################################################################
#
# Web Server Section
#
# Only run this on a web server -- i.e. not on a server that is going to be a
# standalone database server.
#
##################################################################################

echo "Install web server"

#
# Install LAMP base.
#
yum -y install httpd mod_ssl
yum -y install php56w mysql
yum -y install php56w-mcrypt
yum -y install php56w-tidy
yum -y install php56w-mysql
yum -y install php56w-gd
yum -y install php56w-imap
yum -y install php56w-mbstring
yum -y install php56w-odbc
yum -y install php56w-pear
yum -y install php56w-soap
yum -y install php56w-xml
yum -y install php56w-xmlrpc

#
# Install some PHP extensions
#
yum -y install php56w-pecl-apcu
yum -y install php56w-pecl-igbinary
yum -y install php56w-pecl-imagick
yum -y install php56w-pecl-memcache
yum -y install php56w-pecl-memcached

#
# Composer
#
curl -sS https://getcomposer.org/installer | php
mv ./composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

#
# memcached
#
yum -y install memcached
service memcached start
chkconfig memcached on

#
# Redis
#
yum -y install redis
service redis start
chkconfig redis on

#
# Vim
#
yum -y install vim

#
# Install nginx and initialise the cache
#
yum -y install nginx16
yum -y install php56w-fpm
mkdir -p /var/lib/nginx/cache /etc/nginx/ssl
chown nginx.nginx /var/lib/nginx/cache /etc/nginx/ssl
chmod 700 /var/lib/nginx/cache /etc/nginx/ssl
service nginx start
service php-fpm start
chkconfig nginx on
chkconfig php-fpm on

#
# Sendmail
#
yum -y install sendmail sendmail-cf make mailx
yum -y erase postfix

# New sendmail config puts aliases file in /etc/mail
cp -a /etc/aliases /etc/mail/aliases

chkconfig sendmail on

##################################################################################
#
# Database Server Section
#
# Only run this on a database server -- i.e. not on a server that is going to be a
# web server only and have a separate database server attached.
#
##################################################################################

echo "Install Database"

#
# Percona DB
#
# Install yum repositories
#
yum -y install http://www.percona.com/downloads/percona-release/redhat/0.1-3/percona-release-0.1-3.noarch.rpm

#
# Install Percona DB, swapping out MySQL
#
rpm -e --nodeps `rpm -qa | grep mysql-`
yum -y install Percona-Server-server-56 Percona-Server-client-56
yum -y install php56w-mysql

#
# Create a my.cnf file with a few of the necessary parameters.  We will
# swap this out during the deployment script.
#
cat <<EOFMYCNF > /etc/my.cnf
[mysqld]
innodb_log_file_size=64M
EOFMYCNF

#
# Get rid of the logfiles so that they will be created on next start.
#
/bin/rm -f /var/lib/mysql/ib_logfile*

#
# Start MySQL service
#
service mysql start
mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql mysql
chkconfig mysql on

#
# MySQL Secure Installation as defined via: mysql_secure_installation
#
mysql -u root <<-EOF
UPDATE mysql.user SET Password=PASSWORD('$DBAPASS') WHERE User='root';
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%';
FLUSH PRIVILEGES;
EOF

##################################################################################
#
# Elasticsearch Server Section
#
# Only run this on an elasticsearch server -- i.e. not on a server that is going
# to be a web server only and have a separate database server attached.
#
##################################################################################

echo "Install Elasticsearch with plugin GUI"

#
# Install OpenJDK
#
yum -y install java-1.7.0-openjdk

#
# Download and import the public signing key
#
rpm --import https://packages.elastic.co/GPG-KEY-elasticsearch

#
# Add elasticsearch repo
#
cat <<EOFELSREPO > /etc/yum.repos.d/elasticsearch.repo
[elasticsearch-2.x]
name=Elasticsearch repository for 2.x packages
baseurl=https://packages.elastic.co/elasticsearch/2.x/centos
gpgcheck=1
gpgkey=https://packages.elastic.co/GPG-KEY-elasticsearch
enabled=1
EOFELSREPO

#
# Elasticsearch
#
# Install Elasticsearch
#
yum -y install elasticsearch

#
# Configure to start Elasticsearch
#
chkconfig --add elasticsearch

#
# Restart Elasticsearch
#
service elasticsearch restart

#
# Installing Elasticsearch plugin GUI
#
/usr/share/elasticsearch/bin/plugin install jettro/elasticsearch-gui

##################################################################################
#
# Common section
#
##################################################################################

#
# Install apigen -- alternative to PhpDocumentor.
#
echo "Install apigen"
wget http://apigen.org/apigen.phar
mv apigen.phar /usr/local/bin/apigen
chmod +x /usr/local/bin/apigen

#
# Deploy modified config files
#
echo "Deploying config files in deploy/vagrant/root"
cd /vagrant/deploy/vagrant/root
for file in *; do
    TARGETFILE=`echo $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
    echo "Copying $file to ${TARGETFILE}"
    yes | cp $file /${TARGETFILE}
done

#
# Create phpinfo file
#
echo "Create phpinfo page to test PHP Installation"
echo "<?php phpinfo(); ?>" > /usr/share/nginx/html/info.php

##################################################################################
#
# App specific section
#
##################################################################################

#
# Install self-signed SSL Cert
#
echo "Install self-signed SSL Cert"
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/ssl/cert.key -out /etc/nginx/ssl/cert.crt -subj "/C=SG/ST=Singapore/L=Singapore/O=Webmaster/OU=./CN=vagrant/emailAddress=vagrant@localhost.localdomain"

#
# Make laravel logs dir writable
#
echo "Fixing permissions"
chmod 766 -R -f /var/www/${APPNAME}/storage/logs

#
# Create the Database
#
echo "Create Database"
mysql -uroot -p$DBAPASS -e "CREATE DATABASE $DBNAME"
mysql -uroot -p$DBAPASS -e "GRANT ALL PRIVILEGES on $DBNAME.* to '$DBUSER'@'localhost' IDENTIFIED BY '$DBPASS'"

#
# Setup CRON Job for artisan scheduler
#
echo "Setting up artisan scheduler CRON Job"
# Run artisan scheduler every minute
echo "* * * * * php /var/www/${APPNAME}/artisan schedule:run 1>> /dev/null 2>&1" >> mycron
# Add a blank line, required for CRON to properly function
echo '' >> mycron
crontab -u nginx mycron
/bin/rm -f mycron
echo "CRON Job for artisan scheduler created"

#
# Install dependencies
#
echo "Installing dependencies"
cd /var/www/${APPNAME}
/usr/local/bin/composer install
cd ${BASEPATH}

#
# Copy .env
#
echo "Creating .env from .env.example"
cp /var/www/${APPNAME}/.env.example /var/www/${APPNAME}/.env

#
# Start migration
#
echo "Starting migration"
php /var/www/${APPNAME}/artisan migrate
echo "Starting Seeding"
php /var/www/${APPNAME}/artisan db:seed

#
# Import indexes
#
echo "Importing Elasticsearch index"
php /var/www/${APPNAME}/artisan elasticsearch:importIndex

#
# Install Supervisor
#
echo "Installing Supervisor"
yum -y install supervisor
chkconfig supervisord
service supervisord restart

#
# Updating supervisord config
#
cat <<EOFSUPERVISR >> /etc/supervisord.conf
[program:lumenapi_queue]
command=/usr/local/bin/run_lumenapi_queue.sh
autostart=true
autorestart=true
stderr_logfile=/var/log/lumenapi_queue.err.log
stdout_logfile=/var/log/lumenapi_queue.out.log
EOFSUPERVISR
chmod +x /etc/supervisord.conf

#
# Setting queue to run
#
cat <<EOFQUEUERUNNER > /usr/local/bin/run_lumenapi_queue.sh
#!/bin/bash
php /var/www/${APPNAME}/artisan --env=local --timeout=240 queue:work --queue:high,default,low
EOFQUEUERUNNER
chmod +x /usr/local/bin/run_lumenapi_queue.sh

#
# Restart supervisord
#
service supervisord restart

##################################################################################
#
# Install vbox guest additions.
#
# Fix for when yum update causes the kernel to be outdated.
# Ensure to run 'vagrant up' from Terminal to re-sync web directory.
#
##################################################################################

#
# Install all updates
#
echo "Updating server"
yum -y update

#
# Install kernel-devel to allow building of make file
#
echo "Installing kernel-devel tool"
yum install -y gcc make kernel-devel

#
# Install guest additionas
#
echo "Installing updated guests kernel"
yum install -y kernel-devel-2.6.32-504.16.2.el6.x86_64

echo "Initizalizing guests kernel"
/etc/init.d/vboxadd setup
echo "Guest kernel installed"

#
# Do a package list
#
yum list all > /root/yum.list.all

#
# Done, reboot
#
echo "Done, rebooting"
reboot
echo "System reboot successful."
echo "SSH to vagrant and run 'sudo /etc/init.d/vboxadd setup'. Then, 'vagrant reload' on Terminal."
