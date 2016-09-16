#!/bin/sh

#
# Software testing deployment script -- run via jenkins or from the command line
#
# usage: /bin/sh ./runtests.sh
#

##################################################################################
# Set these variables in Jenkins via its Environment Injection
##################################################################################

APPKEY=${APPKEY}
TRUSTEDPROXIES=${TRUSTEDPROXIES}

TARGETDBAPASS=${TARGETDBAPASS}
TARGETDBHOST=${TARGETDBHOST}
TARGETDBNAME=${TARGETDBNAME}
TARGETDBUSER=${TARGETDBUSER}
TARGETDBPASS=${TARGETDBPASS}

STARTDIR=$PWD

#
# Deploy modified config files
#
echo "Deploying config files in ${STARTDIR}/deploy/testing"
cd ${STARTDIR}/deploy/testing
for file in *; do
    if [ -f "$file" ]; then
        TARGETFILE=`echo $file | sed -e 's;+;/;g' -e 's/DOT/\./g'`
        echo "Copying $file to ${STARTDIR}/${TARGETFILE}"
        sudo /bin/cp -rf $file ${STARTDIR}/${TARGETFILE}
    fi
done

#
# Replace values in DOTenv from Jenkins environment
#
echo "Replacing DOTenv files to correct values"
cd ${STARTDIR}
sudo sed -i "/APP_KEY=/c\APP_KEY=${APPKEY}" .env
sudo sed -i "/DB_DATABASE=/c\DB_DATABASE=${TARGETDBNAME}" .env
sudo sed -i "/DB_USERNAME=/c\DB_USERNAME=${TARGETDBUSER}" .env
sudo sed -i "/DB_PASSWORD=/c\DB_PASSWORD=${TARGETDBPASS}" .env
sudo sed -i "/DBA_PASSWORD=/c\DBA_PASSWORD=${TARGETDBAPASS}" .env
sudo sed -i "/TRUSTED_PROXIES=/c\TRUSTED_PROXIES=${TRUSTEDPROXIES}" .env

#
# Web user config post install
#
/usr/local/bin/composer install --no-interaction

##################################################################################
# Deploy database
##################################################################################

echo "Creating new database"
#
# Drop and recreate the database to ensure it's clean.
#
mysql -uroot --password=${TARGETDBAPASS} -h ${TARGETDBHOST} \
<< EOFDB
    SET FOREIGN_KEY_CHECKS=0;
    DROP DATABASE IF EXISTS ${TARGETDBNAME};
    CREATE DATABASE ${TARGETDBNAME} CHARACTER SET utf8;
    GRANT ALL ON ${TARGETDBNAME}.* TO ${TARGETDBUSER}@localhost IDENTIFIED BY '${TARGETDBPASS}';
EOFDB

#
# Run the database migration and seeder.
#
echo "Running database migration"
sudo chmod -R g-w .
php artisan migrate --force
php artisan db:seed

##################################################################################
#
# Common section
#
##################################################################################

#
# Import elasticsearch indexes
#
echo "Importing elasticsearch indexes"
php artisan elasticsearch:importIndex

#################################################################################
#
# codeception test runner
#
#################################################################################

#
# Clean up after any previous test runs
#
rm -rf tests/_output
mkdir -p tests/_output documents
rm -f documents/coverage.xml documents/phpunit.xml

vendor/bin/codecept run api,functional,unit --xml --html --coverage-html --coverage-xml
