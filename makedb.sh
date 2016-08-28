#!/bin/sh

#
# Build a test database
#

#
# Set up local environment
#
. ./.env

#
# Create the test database, adjust the root password as required below.
#
mysql -u root --password=${DBA_PASSWORD} << EOFDB
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

# Run migrations and seeds
php artisan cache:clear
php artisan migrate
php artisan db:seed

# Clear cache again
php artisan cache:clear

echo "Done."

