#!/bin/sh

#
# Set up local environment
#
if [ ! -f .env ]; then
    cp .env.example .env
fi

. ./.env

BASEPATH=$PWD

#
# Install root config files.
#
echo "Installing root configuration files"
cd deploy/vagrant/root
for file in *; do
    TARGETFILE=`echo $file | sed 's;+;/;g'`
    echo "Copying $file to /${TARGETFILE}"
    sudo /bin/cp -rf $file /${TARGETFILE}
done

#
# Create the test database, adjust the root password as required below.
#
echo "Building database"
cd ${BASEPATH}
mysql -uroot --password=${DBA_PASSWORD} << EOFDB
SET FOREIGN_KEY_CHECKS=0;
DROP DATABASE IF EXISTS ${DB_DATABASE};
CREATE DATABASE ${DB_DATABASE} CHARACTER SET utf8;
GRANT ALL ON ${DB_DATABASE}.* TO ${DB_USERNAME}@localhost IDENTIFIED BY '${DB_PASSWORD}';
EOFDB

#
# Ensure that dependencies are installed
#
if [ -f composer.lock ]; then
    /usr/local/bin/composer install
else
    /usr/local/bin/composer update
fi

#
# Reload nginx and php-fpm
#
echo "Reloading nginx and php-fpm"
sudo service nginx reload > /dev/null 2>&1
sudo service php-fpm reload > /dev/null 2>&1

# Run migrations and seeds
echo "Running migration and seeders"
php artisan cache:clear
php artisan migrate
php artisan db:seed

# Clear cache again
php artisan cache:clear

# Import Elasticsearch indexes
php artisan elasticsearch:importIndex

echo "Done."

